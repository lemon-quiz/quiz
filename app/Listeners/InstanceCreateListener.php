<?php

namespace App\Listeners;

use App\Events;
use App\Factory\Generator;
use App\Generators\QuizGenerator;
use App\Models\Instance;
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

    private Generator $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Handle the event.
     *
     * @param Events\InstanceCreate $event
     * @return void
     */
    public function handleCommand(Events\InstanceCreate $event)
    {
        $data = $this->generator->get($event->getQuizId(), [
            'lang' => $event->getLang(),
            'numQuestions' => $event->getNumQuestions(),
            'numAnswers' => $event->getNumAnswers(),
            'group' => $event->getGroup(),
        ]);

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
}
