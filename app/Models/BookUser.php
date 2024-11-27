<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookUser
 * 
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property int|null $chapter_id
 * @property bool $is_saved
 * @property bool $is_read
 * @property bool $is_suggested
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Book $book
 * @property Chapter|null $chapter
 * @property User $user
 *
 * @package App\Models
 */
class BookUser extends Model
{
	protected $table = 'book_user';

	protected $casts = [
		'book_id' => 'int',
		'user_id' => 'int',
		'chapter_id' => 'int',
		'is_saved' => 'bool',
		'is_read' => 'bool',
		'is_suggested' => 'bool'
	];

	protected $fillable = [
		'book_id',
		'user_id',
		'chapter_id',
		'is_saved',
		'is_read',
		'is_suggested'
	];

	public function book()
	{
		return $this->belongsTo(Book::class);
	}

	public function chapter()
	{
		return $this->belongsTo(Chapter::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
