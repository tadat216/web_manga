<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Book
 * 
 * @property int $id
 * @property string $title
 * @property string|null $author_name
 * @property string|null $description
 * @property string|null $cover_image
 * @property string|null $avatar_image
 * @property string $status
 * @property bool $is_active
 * @property bool $is_premium
 * @property int $view_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Genre[] $genres
 * @property Collection|User[] $users
 * @property Collection|Chapter[] $chapters
 *
 * @package App\Models
 */
class Book extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'books';

    protected $casts = [
        'is_active' => 'bool',
        'is_premium' => 'bool',
        'view_count' => 'int'
    ];

    protected $fillable = [
        'title',
        'author_name',
        'description', 
        'cover_image',
        'avatar_image',
        'status',
        'is_active',
        'is_premium',
        'view_count'
    ];

    const STATUS_INCOMING = 'incoming';
    const STATUS_ONGOING = 'ongoing';
    const STATUS_COMPLETE = 'complete';

    public static function getStatuses()
    {
        return [
            self::STATUS_INCOMING => 'Sắp ra mắt',
            self::STATUS_ONGOING => 'Đang tiến hành',
            self::STATUS_COMPLETE => 'Hoàn thành'
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile();

        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class)
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'book_user')
                    ->withPivot('id', 'chapter_id', 'is_saved', 'is_read')
                    ->withTimestamps()
                    ->leftJoin('chapters', 'chapters.id', '=', 'book_user.chapter_id')
                    ->select('users.*', 'chapters.title as chapter_title', 'chapters.id as chapter_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getLastReadChapters()
    {
        return $this->chapters()
                    ->join('book_user', 'chapters.id', '=', 'book_user.chapter_id')
                    ->where('book_user.is_read', true)
                    ->whereNotNull('book_user.chapter_id')
                    ->with(['book', 'book.genres'])
                    ->orderBy('book_user.updated_at', 'desc')
                    ->get();
    }

    public function getSuggestedBooks()
    {
        return $this->users()
                    ->where('book_user.is_suggested', true)
                    ->with(['genres', 'chapters'])
                    ->inRandomOrder()
                    ->limit(15)
                    ->get();
    }
}
