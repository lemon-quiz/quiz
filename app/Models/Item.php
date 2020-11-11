<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Item.
 *
 * @property int $id
 * @property string $item_a
 * @property string $item_b
 * @property int $quiz_id
 * @property-read \App\Models\Quiz $quiz
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereItemA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereItemB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereQuizId($value)
 * @mixin \Eloquent
 * @property int $group
 * @property int $position
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePosition($value)
 * @property int $revision_number
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereRevisionNumber($value)
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_a',
        'item_b',
        'group',
        'position',
    ];

    public $timestamps = false;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
