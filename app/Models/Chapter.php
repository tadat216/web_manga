<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Chapter
 * 
 * @property int $id
 * @property int $book_id
 * @property string $title
 * @property string|null $description
 * @property int $chapter_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Book $book
 * @property Collection|BookUser[] $book_users
 * @property Collection|ChapterPage[] $chapter_pages
 *
 * @package App\Models
 */
class Chapter extends Model
{
	protected $table = 'chapters';

	protected $casts = [
		'book_id' => 'int',
		'chapter_number' => 'int'
	];

	protected $fillable = [
		'book_id',
		'title',
		'description',
		'chapter_number'
	];

	public function book()
	{
		return $this->belongsTo(Book::class);
	}

	public function book_users()
	{
		return $this->hasMany(BookUser::class);
	}

	public function chapter_pages()
	{
		return $this->hasMany(ChapterPage::class);
	}
}
