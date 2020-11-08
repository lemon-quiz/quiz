<?php

namespace App\Listeners;

use App\Events\Apply\ItemWasCreated;
use App\Events\Apply\QuizWasCreated;
use App\Events\QuizCreate;
use App\Models\Item;
use App\Models\Quiz;
use LaravelCode\EventSourcing\Listeners\ApplyListener;

/**
 * Class QuizCreateListener.
 *
 * @property Quiz $entity
 */
class QuizCreateListener
{
    use ApplyListener;

    protected string $model = Quiz::class;

    /**
     * Handle the event.
     *
     * @param QuizCreate $event
     * @return void
     */
    public function handleCommand(QuizCreate $event)
    {
        $this->event(new QuizWasCreated(null,
            $event->getName(),
            $event->getLangA(),
            $event->getLangB(),
            $event->getItems(),
            $event->isActive()
        ));
    }

    /**
     * @param QuizWasCreated $event
     */
    public function applyQuizWasCreated(QuizWasCreated $event)
    {
        $this->entity->name = $event->getName();
        $this->entity->lang_a = $event->getLangA();
        $this->entity->lang_b = $event->getLangB();
        $this->entity->active = $event->isActive();

        /*
         * Runs after the entity is saved
         * Now we have the entity id available.
         * This will not get triggered on a replay event.
         *
         * @param QuizWasCreated $event
         */
        return function (QuizWasCreated $event) {
            foreach ($event->getItems() as $position => $item) {
                $this->event(new ItemWasCreated(
                    null,
                    $this->entity->id,
                    $item['item_a'],
                    $item['item_b'],
                    $item['group'],
                    $position,
                ));
            }
        };
    }
}
