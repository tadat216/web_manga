<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChapterPage
 * 
 * @property int $id
 * @property string $image_path
 * @property int $chapter_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Chapter $chapter
 *
 * @package App\Models
 */
class ChapterPage extends Model
{
	protected $table = 'chapter_pages';

	protected $casts = [
		'chapter_id' => 'int'
	];

	protected $fillable = [
		'image_path',
		'chapter_id'
	];

	public function chapter()
	{
		return $this->belongsTo(Chapter::class);
	}
}
