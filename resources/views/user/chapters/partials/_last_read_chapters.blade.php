@if($lastReadChapters->count() > 0)
    <div class="last-read-chapters">
        <h4>Chương đã đọc gần đây</h4>
        <div class="list-group">
            @foreach($lastReadChapters as $chapter)
                <a href="{{ route('user.chapters.show', ['id' => $chapter->book_id, 'chapter_id' => $chapter->id]) }}" 
                   class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $chapter->book->title }}</h6>
                            <small>{{ $chapter->title }}</small>
                        </div>
                        <small class="text-muted">
                            {{ $chapter->updated_at->diffForHumans() }}
                        </small>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif 