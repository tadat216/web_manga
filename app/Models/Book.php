<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Book
 * 
 * @property int $id
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
class Book extends Model
{
	protected $table = 'books';

	protected $casts = [
		'is_active' => 'bool',
		'is_premium' => 'bool',
		'view_count' => 'int'
	];

	protected $fillable = [
		'author_name',
		'description',
		'cover_image',
		'avatar_image',
		'status',
		'is_active',
		'is_premium',
		'view_count'
	];

	public function genres()
	{
		return $this->belongsToMany(Genre::class)
					->withPivot('id')
					->withTimestamps();
	}

	public function users()
	{
		return $this->belongsToMany(User::class)
					->withPivot('id', 'chapter_id', 'is_saved', 'is_read')
					->withTimestamps();
	}

	public function chapters()
	{
		return $this->hasMany(Chapter::class);
	}
}
