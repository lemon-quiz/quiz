<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelCode\EventSourcing\Models\SearchBehaviourTrait;

/**
 * App\Models\Quiz.
 *
 * @property int $id
 * @property string $name
 * @property string $lang_a
 * @property string $lang_b
 * @property bool $active
 * @property int $revision_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Item[] $items
 * @property-read int|null $items_count
 * @method static Builder|Quiz newModelQuery()
 * @method static Builder|Quiz newQuery()
 * @method static Builder|Quiz paginatedResources(\Illuminate\Http\Request $request, $withQuery = null)
 * @method static Builder|Quiz query()
 * @method static Builder|Quiz resource($modelId, \Illuminate\Http\Request $request, $withQuery = null)
 * @method static Builder|Quiz whereActive($value)
 * @method static Builder|Quiz whereCreatedAt($value)
 * @method static Builder|Quiz whereId($value)
 * @method static Builder|Quiz whereLangA($value)
 * @method static Builder|Quiz whereLangB($value)
 * @method static Builder|Quiz whereName($value)
 * @method static Builder|Quiz whereRevisionNumber($value)
 * @method static Builder|Quiz whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Instance[] $instances
 * @property-read int|null $instances_count
 */
class Quiz extends Model
{
    use HasFactory, SearchBehaviourTrait;

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $includes = ['items'];

    public function search()
    {
        return [
            'name' => function (Builder $query, $value) {
                return $query->where('name', 'like', '%'.$value.'%');
            },
            'id',
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function instances()
    {
        return $this->hasMany(Instance::class);
    }
}
