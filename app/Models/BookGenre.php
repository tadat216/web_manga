<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookGenre
 * 
 * @property int $id
 * @property int $book_id
 * @property int $genre_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Book $book
 * @property Genre $genre
 *
 * @package App\Models
 */
class BookGenre extends Model
{
	protected $table = 'book_genre';

	protected $casts = [
		'book_id' => 'int',
		'genre_id' => 'int'
	];

	protected $fillable = [
		'book_id',
		'genre_id'
	];

	public function book()
	{
		return $this->belongsTo(Book::class);
	}

	public function genre()
	{
		return $this->belongsTo(Genre::class);
	}
}
