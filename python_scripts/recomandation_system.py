import numpy as np
import pandas as pd
import mysql.connector
from sklearn.metrics.pairwise import cosine_similarity
import os
from dotenv import load_dotenv

# Kết nối database
def get_db_connection():

    load_dotenv('./.env')
    
    db_config = {
        "host": os.getenv('DB_HOST'),
        "port": int(os.getenv('DB_PORT')),
        "user": os.getenv('DB_USERNAME'), 
        "password": os.getenv('DB_PASSWORD'),
        "database": os.getenv('DB_DATABASE')
    }
    try:
        connection = mysql.connector.connect(**db_config)
        if connection.is_connected():
            return connection
    except mysql.connector.Error as e:
        print(f"Lỗi kết nối database: {e}")
    return None


# Reset `is_suggested` về False
def reset_is_suggested():
    connection = get_db_connection()
    if not connection:
        return

    try:
        cursor = connection.cursor()
        query = "UPDATE book_user SET is_suggested = 0"
        cursor.execute(query)
        connection.commit()
        print("Đặt lại `is_suggested` về False thành công.")
    except mysql.connector.Error as e:
        print(f"Lỗi khi đặt lại `is_suggested`: {e}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()


# Xóa các bản ghi dư thừa
def delete_redundant_records():
    connection = get_db_connection()
    if not connection:
        return

    try:
        cursor = connection.cursor()
        query = """
            DELETE FROM book_user 
            WHERE is_read = 0 AND is_saved = 0 AND is_suggested = 1
        """
        cursor.execute(query)
        connection.commit()
        print("Xóa các bản ghi dư thừa thành công.")
    except mysql.connector.Error as e:
        print(f"Lỗi khi xóa bản ghi dư thừa: {e}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()


# Tải dữ liệu từ database
def load_data():
    connection = get_db_connection()
    if not connection:
        return None

    try:
        # Lấy tất cả sách và người dùng
        query = """
            SELECT 
                u.id AS user_id,
                u.name AS user_name,
                b.id AS book_id,
                b.title AS book_title,
                COALESCE(bu.is_read, 0) as is_read,
                COALESCE(bu.is_saved, 0) as is_saved,
                COALESCE(bu.is_suggested, 0) as is_suggested
            FROM users u
            CROSS JOIN books b
            LEFT JOIN book_user bu ON u.id = bu.user_id AND b.id = bu.book_id
        """
        df = pd.read_sql(query, connection)
        return df
    except mysql.connector.Error as e:
        print(f"Lỗi khi tải dữ liệu: {e}")
        return None
    finally:
        if connection.is_connected():
            connection.close()


# Xây dựng ma trận người dùng - sách
def build_user_book_matrix(data):
    # Tạo ma trận tương tác, giá trị là 1 nếu user đã đọc hoặc đã lưu sách
    data['interaction'] = (data['is_read'].astype(bool) | data['is_saved'].astype(bool)).astype(int)
    
    # Pivot table để tạo ma trận user-book
    user_book_matrix = data.pivot_table(
        index='user_id',
        columns='book_id',
        values='interaction',
        fill_value=0,
        aggfunc='max'  # Sử dụng max để đảm bảo 1 nếu có bất kỳ tương tác nào
    )
    
    # Ghi ma trận vào file log
    with open('python_scripts/user_book_matrix.log', 'w', encoding='utf-8') as f:
        f.write("Ma trận tương tác người dùng - sách:\n")
        f.write(user_book_matrix.to_string())
        f.write("\n\nKích thước ma trận: " + str(user_book_matrix.shape))
    
    return user_book_matrix


# Tính toán ma trận tương đồng giữa các sách (Item-Based CF)
def calculate_item_similarity(user_book_matrix):
    # Tính toán ma trận tương đồng giữa các sách
    item_similarity = cosine_similarity(user_book_matrix.T)  # Chuyển vị để tính giữa sách
    item_similarity_df = pd.DataFrame(
        item_similarity, index=user_book_matrix.columns, columns=user_book_matrix.columns
    )
    return item_similarity_df


# Đề xuất sách dựa trên Item-Based Collaborative Filtering
def recommend_books_item_based(user_id, user_book_matrix, item_similarity_df, data, num_recommendations=10):
    # Lấy danh sách sách mà người dùng đã đọc
    user_books = user_book_matrix.loc[user_id]
    user_books_read = user_books[user_books > 0].index

    # Tìm các sách tương tự
    similar_books = pd.Series(dtype='float64')
    for book_id in user_books_read:
        similar_books = similar_books.add(item_similarity_df[book_id], fill_value=0)

    # Loại bỏ sách mà người dùng đã đọc
    similar_books = similar_books[user_books == 0]

    # Sắp xếp và lấy top sách
    recommendations = similar_books.sort_values(ascending=False).head(num_recommendations)

    # Lấy thông tin sách từ dataframe gốc
    recommended_books = data[data['book_id'].isin(recommendations.index)][['book_id', 'book_title']]
    recommended_books = recommended_books.drop_duplicates()

    return recommended_books


# Đánh dấu `is_suggested` cho sách được đề xuất
def update_suggested_books(user_id, recommended_books):
    connection = get_db_connection()
    if not connection:
        return

    try:
        cursor = connection.cursor()
        for book_id in recommended_books['book_id']:
            query = """
                INSERT INTO book_user (user_id, book_id, is_suggested, is_read, is_saved)
                VALUES (%s, %s, 1, 0, 0)
                ON DUPLICATE KEY UPDATE is_suggested = 1
            """
            cursor.execute(query, (user_id, book_id))
        connection.commit()
        print(f"Đánh dấu `is_suggested` cho {len(recommended_books)} sách thành công cho người dùng ID {user_id}.")
    except mysql.connector.Error as e:
        print(f"Lỗi khi cập nhật `is_suggested`: {e}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()


# Gợi ý sách cho tất cả người dùng
def suggest_books_for_all_users():
    # Reset tất cả các cờ `is_suggested`
    reset_is_suggested()

    # Xóa các bản ghi dư thừa
    delete_redundant_records()

    # Tải dữ liệu từ database
    data = load_data()
    if data is None:
        print("Không thể tải dữ liệu từ cơ sở dữ liệu.")
        return

    # Xây dựng ma trận người dùng - sách
    user_book_matrix = build_user_book_matrix(data)

    # Tính toán ma trận tương đồng giữa các sách
    item_similarity_df = calculate_item_similarity(user_book_matrix)

    # Lấy danh sách tất cả người dùng
    users = user_book_matrix.index.tolist()

    # Thực hiện gợi ý cho từng người dùng
    for user_id in users:
        recommended_books = recommend_books_item_based(user_id, user_book_matrix, item_similarity_df, data)
        if not recommended_books.empty:
            update_suggested_books(user_id, recommended_books)


# Gọi hàm để thực hiện gợi ý cho tất cả người dùng
suggest_books_for_all_users()