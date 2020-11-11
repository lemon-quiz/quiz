<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelCode\EventSourcing\Models\SearchBehaviourTrait;

/**
 * App\Models\Instance.
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $lang
 * @property int $position
 * @property int|null $author_id
 * @property array $data
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Quiz $quiz
 * @method static \Illuminate\Database\Eloquent\Builder|Instance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $num_questions
 * @property int $num_answers
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereNumAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereNumQuestions($value)
 * @property int $group
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereGroup($value)
 * @property int $revision_number
 * @method static \Illuminate\Database\Eloquent\Builder|Instance whereRevisionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance paginatedResources(\Illuminate\Http\Request $request, $withQuery = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Instance resource($modelId, \Illuminate\Http\Request $request, $withQuery = null)
 */
class Instance extends Model
{
    use HasFactory, SearchBehaviourTrait;

    protected $casts = [
        'data' => 'array',
        'completed' => 'boolean',
        'position' => 'integer',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
