@extends('layouts.admin')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h1 class="text-xl font-semibold text-gray-900">Thêm sách mới</h1>
    </div>

    <div class="p-6">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Tên sách <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required value="{{ old('title') }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="author_name" class="block text-sm font-medium text-gray-700">Tác giả</label>
                <input type="text" name="author_name" id="author_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('author_name') }}">
                @error('author_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cover_image" class="block text-sm font-medium text-gray-700">Ảnh bìa</label>
                <input type="file" name="cover_image" id="cover_image" class="mt-1 block w-full">
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="avatar_image" class="block text-sm font-medium text-gray-700">Ảnh đại diện</label>
                <input type="file" name="avatar_image" id="avatar_image" class="mt-1 block w-full">
                @error('avatar_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái <span class="text-red-500">*</span></label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="incoming" {{ old('status') == 'incoming' ? 'selected' : '' }}>Sắp ra mắt</option>
                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Đang tiến hành</option>
                    <option value="complete" {{ old('status') == 'complete' ? 'selected' : '' }}>Hoàn thành</option>
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
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
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
                        <input type="checkbox" name="is_premium" value="1" class="sr-only peer" {{ old('is_premium') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Premium</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.books') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Hủy
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Thêm mới
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
