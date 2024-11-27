import numpy as np
import pandas as pd
import mysql.connector
from sklearn.metrics.pairwise import cosine_similarity


# Kết nối database
def get_db_connection():
    db_config = {
        "host": "112.213.87.61",
        "port": 3306,
        "user": "web_user",
        "password": "t@huynhd4t",
        "database": "web_doc_truyen"
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
        query = """
            SELECT bu.user_id, u.name AS user_name, bu.book_id, b.title AS book_title, 
                   bu.is_read, bu.is_saved, bu.is_suggested
            FROM book_user bu
            JOIN users u ON bu.user_id = u.id
            JOIN books b ON bu.book_id = b.id
        """
        df = pd.read_sql(query, connection)
        return df
    except mysql.connector.Error as e:
        print(f"Lỗi khi tải dữ liệu: {e}")
        return None
    finally:
        if connection.is_connected():
            connection.close()


# Lấy danh sách tất cả người dùng
def get_all_users():
    connection = get_db_connection()
    if not connection:
        return []

    try:
        cursor = connection.cursor()
        query = "SELECT id FROM users"
        cursor.execute(query)
        users = [row[0] for row in cursor.fetchall()]
        return users
    except mysql.connector.Error as e:
        print(f"Lỗi khi lấy danh sách người dùng: {e}")
        return []
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()


# Xây dựng ma trận người dùng - sách
def build_user_book_matrix(data):
    # Tạo ma trận, giá trị là 1 nếu user đã đọc/lưu sách, ngược lại là 0
    data['interaction'] = data['is_read'] | data['is_saved']
    user_book_matrix = data.pivot_table(index='user_id', columns='book_id', values='interaction', fill_value=0)
    return user_book_matrix


# Đề xuất sách dựa trên User-Based Collaborative Filtering
def recommend_books(user_id, user_book_matrix, similarity_matrix, data, num_recommendations=30):
    # Tìm chỉ số của người dùng
    user_idx = user_book_matrix.index.get_loc(user_id)

    # Lấy danh sách người dùng tương tự (trừ chính người dùng đó)
    similarity_scores = pd.Series(similarity_matrix[user_idx], index=user_book_matrix.index)
    similarity_scores = similarity_scores.sort_values(ascending=False)

    # Lấy danh sách sách đã đọc bởi những người dùng tương tự
    similar_users = similarity_scores.index[1:]  # Bỏ chính người dùng
    similar_books = user_book_matrix.loc[similar_users].sum(axis=0)

    # Loại bỏ sách mà người dùng hiện tại đã đọc hoặc lưu
    user_books = user_book_matrix.loc[user_id]
    books_to_recommend = similar_books[user_books == 0]

    # Sắp xếp theo mức độ phổ biến (giảm dần)
    recommendations = books_to_recommend.sort_values(ascending=False)

    # Lấy thông tin sách từ dataframe gốc
    recommended_books = data[data['book_id'].isin(recommendations.index)][['book_id', 'book_title']]
    recommended_books = recommended_books.drop_duplicates()

    # Chọn 30 sách ngẫu nhiên từ danh sách đề xuất
    if len(recommended_books) > num_recommendations:
        recommended_books = recommended_books.sample(n=num_recommendations, random_state=42)

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

    # Tính toán ma trận tương đồng giữa người dùng
    similarity_matrix = cosine_similarity(user_book_matrix)

    # Lấy danh sách tất cả người dùng
    users = user_book_matrix.index.tolist()

    # Thực hiện gợi ý cho từng người dùng
    for user_id in users:
        recommended_books = recommend_books(user_id, user_book_matrix, similarity_matrix, data)
        if not recommended_books.empty:
            update_suggested_books(user_id, recommended_books)


# Gọi hàm để thực hiện gợi ý cho tất cả người dùng
suggest_books_for_all_users()