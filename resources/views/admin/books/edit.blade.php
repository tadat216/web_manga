@extends('layouts.admin')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h1 class="text-xl font-semibold text-gray-900">Chỉnh sửa sách</h1>
    </div>

    <div class="p-6">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Tên sách <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required value="{{ old('title', $book->title) }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="author_name" class="block text-sm font-medium text-gray-700">Tác giả</label>
                <input type="text" name="author_name" id="author_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('author_name', $book->author_name) }}">
                @error('author_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cover" class="block text-sm font-medium text-gray-700">Ảnh bìa</label>
                @if($book->getFirstMediaUrl('cover'))
                    <div class="mt-2">
                        <img src="{{ $book->getFirstMediaUrl('cover') }}" alt="Cover" class="w-32 h-32 object-cover">
                    </div>
                @endif
                <input type="file" name="cover" id="cover" class="mt-1 block w-full" accept="image/*">
                @error('cover')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="avatar" class="block text-sm font-medium text-gray-700">Ảnh đại diện</label>
                @if($book->getFirstMediaUrl('avatar'))
                    <div class="mt-2">
                        <img src="{{ $book->getFirstMediaUrl('avatar') }}" alt="Avatar" class="w-32 h-32 object-cover">
                    </div>
                @endif
                <input type="file" name="avatar" id="avatar" class="mt-1 block w-full" accept="image/*">
                @error('avatar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái phát hành <span class="text-red-500">*</span></label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @foreach(App\Models\Book::getStatuses() as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $book->status) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
                <div class="mt-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $book->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Kích hoạt</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Premium</label>
                <div class="mt-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_premium" value="0">
                        <input type="checkbox" name="is_premium" value="1" class="sr-only peer" {{ old('is_premium', $book->is_premium) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Premium</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Thể loại
                </label>
                
                <!-- Dropdown chọn thể loại -->
                <select id="genre-select" class="w-full border rounded px-3 py-2 mb-2">
                    <option value="">Chọn thể loại</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" data-name="{{ $genre->title }}">
                            {{ $genre->title }}
                        </option>
                    @endforeach
                </select>

                <!-- Container chứa các tags đã chọn -->
                <div id="selected-genres" class="flex flex-wrap gap-2">
                    @foreach($book->genres as $genre)
                        <div class="flex items-center gap-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                            <span>{{ $genre->title }}</span>
                            <button type="button" data-id="{{ $genre->id }}" class="remove-genre text-blue-600 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Input ẩn để lưu các genre IDs -->
                <input type="hidden" name="genres" id="genre-ids" value="{{ $book->genres->pluck('id')->join(',') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Danh sách Chapter
                </label>
                <div id="chapters-container">
                    @foreach($book->chapters as $chapter)
                        <div class="chapter-item mb-4 border rounded p-4" data-number="{{ $chapter->chapter_number }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <button type="button" class="move-up mr-2 text-gray-500 hover:text-gray-700" {{ $chapter->chapter_number === 1 ? 'disabled' : '' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="font-bold">Chapter {{ $chapter->chapter_number }}</span>
                                </div>
                                <div class="flex items-center">
                                    <button type="button" class="toggle-chapter mr-2 text-blue-600 hover:text-blue-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button type="button" class="remove-chapter text-red-600 hover:text-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="chapter-content">
                                <input type="hidden" name="chapters[{{ $chapter->chapter_number }}][chapter_number]" value="{{ $chapter->chapter_number }}">
                                <div class="mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                                    <input type="text" name="chapters[{{ $chapter->chapter_number }}][title]" value="{{ $chapter->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Mô tả</label>
                                    <textarea name="chapters[{{ $chapter->chapter_number }}][description]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $chapter->description }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nội dung</label>
                                    <textarea name="chapters[{{ $chapter->chapter_number }}][content]" id="editor-{{ $chapter->chapter_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="10">{{ $chapter->content }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-chapter" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Thêm Chapter
                </button>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.books') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Hủy
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

<!-- Thêm đoạn JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const genreSelect = document.getElementById('genre-select');
    const selectedGenres = document.getElementById('selected-genres');
    const genreIds = document.getElementById('genre-ids');
    let selectedGenreIds = new Set(genreIds.value ? genreIds.value.split(',') : []);

    // Khởi tạo CKEditor cho các chapter hiện có
    document.querySelectorAll('[id^="editor-"]').forEach(editor => {
        ClassicEditor
            .create(editor)
            .catch(error => {
                console.error(error);
            });
    });

    genreSelect.addEventListener('change', function() {
        const genreId = this.value;
        const genreName = this.options[this.selectedIndex].dataset.name;
        
        if (genreId && !selectedGenreIds.has(genreId)) {
            // Thêm genre mới
            selectedGenreIds.add(genreId);
            
            // Tạo tag mới
            const tag = document.createElement('div');
            tag.className = 'flex items-center gap-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full';
            tag.innerHTML = `
                <span>${genreName}</span>
                <button type="button" data-id="${genreId}" class="remove-genre text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            
            selectedGenres.appendChild(tag);
            updateGenreIds();
        }
        
        // Reset select về giá trị mặc định
        this.value = '';
    });

    // Xử lý xóa tag
    selectedGenres.addEventListener('click', function(e) {
        if (e.target.closest('.remove-genre')) {
            const button = e.target.closest('.remove-genre');
            const genreId = button.dataset.id;
            selectedGenreIds.delete(genreId);
            button.closest('div').remove();
            updateGenreIds();
        }
    });

    // Cập nhật input ẩn chứa genre IDs
    function updateGenreIds() {
        genreIds.value = Array.from(selectedGenreIds).join(',');
    }

    // Xử lý thêm chapter
    let chapterCount = document.querySelectorAll('.chapter-item').length;
    const chaptersContainer = document.getElementById('chapters-container');
    const addChapterButton = document.getElementById('add-chapter');

    addChapterButton.addEventListener('click', function() {
        chapterCount++;
        const chapterDiv = document.createElement('div');
        chapterDiv.className = 'chapter-item mb-4 border rounded p-4';
        chapterDiv.dataset.number = chapterCount;
        chapterDiv.innerHTML = `
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <button type="button" class="move-up mr-2 text-gray-500 hover:text-gray-700" ${chapterCount === 1 ? 'disabled' : ''}>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <span class="font-bold">Chapter ${chapterCount}</span>
                </div>
                <div class="flex items-center">
                    <button type="button" class="toggle-chapter mr-2 text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" class="remove-chapter text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="chapter-content">
                <input type="hidden" name="chapters[${chapterCount}][chapter_number]" value="${chapterCount}">
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                    <input type="text" name="chapters[${chapterCount}][title]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Mô tả</label>
                    <textarea name="chapters[${chapterCount}][description]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nội dung</label>
                    <textarea name="chapters[${chapterCount}][content]" id="editor-${chapterCount}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="10"></textarea>
                </div>
            </div>
        `;
        chaptersContainer.appendChild(chapterDiv);

        // Khởi tạo CKEditor cho textarea content mới
        ClassicEditor
            .create(document.querySelector(`#editor-${chapterCount}`))
            .catch(error => {
                console.error(error);
            });
    });

    // Xử lý thu gọn/mở rộng chapter
    chaptersContainer.addEventListener('click', function(e) {
        if (e.target.closest('.toggle-chapter')) {
            const chapterItem = e.target.closest('.chapter-item');
            const content = chapterItem.querySelector('.chapter-content');
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        }
    });

    // Xử lý xóa chapter
    chaptersContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-chapter')) {
            if (confirm('Bạn có chắc chắn muốn xóa chapter này? Hành động này không thể hoàn tác.')) {
                const chapterItem = e.target.closest('.chapter-item');
                chapterItem.remove();
                updateChapterNumbers();
            }
        }
    });

    // Xử lý di chuyển chapter lên
    chaptersContainer.addEventListener('click', function(e) {
        if (e.target.closest('.move-up')) {
            const currentChapter = e.target.closest('.chapter-item');
            const previousChapter = currentChapter.previousElementSibling;
            
            if (previousChapter) {
                chaptersContainer.insertBefore(currentChapter, previousChapter);
                updateChapterNumbers();
            }
        }
    });

    // Cập nhật số thứ tự chapter
    function updateChapterNumbers() {
        const chapters = chaptersContainer.querySelectorAll('.chapter-item');
        chapters.forEach((chapter, index) => {
            const newNumber = index + 1;
            chapter.dataset.number = newNumber;
            chapter.querySelector('.font-bold').textContent = `Chapter ${newNumber}`;
            chapter.querySelector('input[name*="[chapter_number]"]').value = newNumber;
            
            // Cập nhật tất cả các name attribute
            const inputs = chapter.querySelectorAll('[name^="chapters["]');
            inputs.forEach(input => {
                input.name = input.name.replace(/chapters\[\d+\]/, `chapters[${newNumber}]`);
            });

            // Disable/enable nút move-up
            const moveUpButton = chapter.querySelector('.move-up');
            moveUpButton.disabled = newNumber === 1;
        });
    }
});
</script>
@endsection