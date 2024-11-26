<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Book[] $books
 *
 * @package App\Models
 */
class Genre extends Model
{
	protected $table = 'genres';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
		'description',
		'is_active'
	];

	public function books()
	{
		return $this->belongsToMany(Book::class)
					->withPivot('id')
					->withTimestamps();
	}
}
