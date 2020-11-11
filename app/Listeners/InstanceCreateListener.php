<?php

namespace App\Listeners;

use App\Events;
use App\Model\User;
use App\Models\Instance;
use App\Models\Quiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Queue\InteractsWithQueue;
use LaravelCode\EventSourcing\Contracts\EventInterface;
use LaravelCode\EventSourcing\Listeners\ApplyListener;

/**
 * Class InstanceCreateListener.
 * @property Instance $entity
 */
class InstanceCreateListener
{
    use ApplyListener;

    /**
     * Set if the program is unable to guess the model class.
     */
    public $model = Instance::class;

    /**
     * Handle the event.
     *
     * @param Events\InstanceCreate $event
     * @return void
     */
    public function handleCommand(Events\InstanceCreate $event)
    {
        $data = $this->createInstance($event->getQuizId(), $event->getLang(), $event->getNumQuestions(), $event->getNumAnswers(), $event->getGroup());

        $this->event(new Events\Apply\InstanceWasCreated(
            $event->getId(),
            $data,
            $event->getQuizId(),
            $event->getLang(),
            $event->getNumQuestions(),
            $event->getNumAnswers(),
            $event->getGroup()
        ));
    }

    /**
     * @param Events\Apply\InstanceWasCreated $event
     */
    public function applyInstanceWasCreated(Events\Apply\InstanceWasCreated $event)
    {
        $this->entity->data = $event->getData();
        $this->entity->quiz_id = $event->getQuizId();
        $this->entity->lang = $event->getLang();
        $this->entity->num_questions = $event->getNumQuestions();
        $this->entity->num_answers = $event->getNumAnswers();
        $this->entity->group = $event->getGroup();
    }

    private function createInstance($quizId, $lang, $numQuestions, $numAnswers, $group = null)
    {
        $quiz = Quiz::with(['items' => function (HasMany $query) use ($group) {
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
