<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Book[] $books
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasRoles, Notifiable;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function books()
	{
		return $this->belongsToMany(Book::class)
					->withPivot('id', 'chapter_id', 'is_saved', 'is_read', 'is_suggested')
					->withTimestamps();
	}
	public function getLastReadChapters()
	{
		return $this->belongsToMany(Chapter::class, 'book_user', 'user_id', 'chapter_id')
					->where('is_read', true)
					->whereNotNull('book_user.chapter_id')
					->with(['book', 'book.genres', 'book.chapters'])
					->orderBy('book_user.updated_at', 'desc')
					->get();
	}

	public function getSuggestedBooks()
	{
		return $this->books()
				->where('is_suggested', true)
				->with(['genres', 'chapters'])
				->inRandomOrder()
				->limit(15)
				->get();
	}
}
