<?php

namespace App\Generators;

use App\Factory\GeneratorInterface;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizGenerator implements GeneratorInterface
{
    private Quiz $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function get($id, array $data)
    {
        return $this->createInstance($id, $data['lang'], $data['numQuestions'], $data['numAnswers'], $data['group']);
    }

    private function createInstance($quizId, $lang, $numQuestions, $numAnswers, $group = null)
    {
        $quiz = $this->quiz->with(['items' => function (HasMany $query) use ($group) {
            if ($group ?? null) {
                $query->where('group', $group);
            }
        }])->findOrFail($quizId);

        $questions = [];
        $answers = [];

        foreach ($quiz['items'] as $item) {
            if (! isset($questions[$item['group']])) {
                $questions[$item['group']] = [];
            }

            if (! isset($answers[$item['group']])) {
                $answers[$item['group']] = [];
            }
            $questions[$item['group']][] = [
                'id' => $item['id'],
                'group' => $item['group'],
                'question' => $item['item_'.$lang],
                'answers' => [[
                    'correct' => true,
                    'value' => $item['item_'.($lang === 'a' ? 'b' : 'a')],
                ]],
            ];
            $answers[$item['group']][] = $item['item_'.($lang === 'a' ? 'b' : 'a')];
        }

        if (($numQuestions ?? 'all') === 'all') {
            return $this->randomizeQuestionsAndAnswers($questions, $answers, $numAnswers);
        }

        return array_slice($this->randomizeQuestionsAndAnswers($questions, $answers, $numAnswers), 0, (int) $numQuestions);
    }

    private function randomizeQuestionsAndAnswers($groups, $answers, $num_answers)
    {
        $instance = [];

        $allAnswers = array_merge(...$answers);

        foreach ($groups as $group => $questions) {
            foreach ($questions as $questionIndex => $questionInstance) {
                $possibleAnswers = count($answers[$group]) > $num_answers ? $answers[$group] : $allAnswers;
                shuffle($possibleAnswers);

                foreach ($possibleAnswers as $answer) {
                    if ($questionInstance['answers'][0]['value'] !== $answer) {
                        $questionInstance['answers'][] = [
                            'correct' => false,
                            'value' => $answer,
                        ];
                    }
                    if (count($questionInstance['answers']) >= $num_answers) {
                        break;
                    }
                }

                $questionAnswers = $questionInstance['answers'];
                shuffle($questionAnswers);
                $questionInstance['answers'] = $questionAnswers;
                $instance[] = $questionInstance;
            }
        }
        shuffle($instance);

        return $instance;
    }
}
