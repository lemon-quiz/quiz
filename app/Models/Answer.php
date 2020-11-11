<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelCode\EventSourcing\Models\SearchBehaviourTrait;

/**
 * App\Models\Answer.
 *
 * @property int $instance_id
 * @property int $quiz_id
 * @property int|null $author_id
 * @property int $item_id
 * @property int $correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereInstanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Answer paginatedResources(\Illuminate\Http\Request $request, $withQuery = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer resource($modelId, \Illuminate\Http\Request $request, $withQuery = null)
 */
class Answer extends Model
{
    use HasFactory, SearchBehaviourTrait;
}
