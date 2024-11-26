@extends('layouts.admin')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-900">Danh sách truyện</h1>
        <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Thêm truyện
        </a>
    </div>

    <div class="overflow-x-auto">
        @if($books->isEmpty())
        <div class="p-4 text-center text-gray-500">
            Chưa có bản ghi nào
        </div>
        @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tên truyện
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Mô tả
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Lượt xem
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Trạng thái
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kích hoạt
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Thao tác
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($books as $book)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $book->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $book->title }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="max-w-xs md:max-w-sm lg:max-w-md truncate">
                            {{ $book->description }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $book->view_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $book->status }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" {{ $book->is_active ? 'checked' : '' }}
                                onchange="updateStatus({{ $book->id }}, this.checked)">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.books.show', $book->id) }}" class="text-blue-600 hover:text-blue-900">
                                Xem
                            </a>
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                Sửa
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $books->links() }}
        </div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg" id="success-message">
    {{ session('success') }}
</div>
<script>
    setTimeout(function() {
        document.getElementById('success-message').style.display = 'none';
    }, 3000);
</script>
@endif

<script>
function updateStatus(id, status) {
    fetch(`/admin/books/${id}/update-is-active`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            is_active: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Có thể thêm thông báo thành công nếu cần
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection
