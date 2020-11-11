<?php

namespace App\Listeners;

use App\Events;
use App\Events\Apply\ItemWasCreated;
use App\Events\Apply\QuizWasCreated;
use App\Events\QuizChange;
use App\Model\User;
use App\Models\Quiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaravelCode\EventSourcing\Contracts\EventInterface;
use LaravelCode\EventSourcing\Listeners\ApplyListener;

/**
 * Class QuizChangeListener.
 *
 * @property Quiz $entity
 */
class QuizChangeListener
{
    use ApplyListener;

    /**
     * Set if the program is unable to guess the model class.
     */
    public $model = Quiz::class;

    /**
     * Handle the event.
     *
     * @param QuizChange $event
     * @return void
     */
    public function handleCommand(QuizChange $event)
    {
        if ($this->entity->name !== $event->getName()) {
            $this->event(new Events\Apply\QuizNameWasChanged($event->getId(), $event->getName()));
        }

        if ($this->entity->active !== $event->isActive()) {
            $this->event(new Events\Apply\QuizActiveWasChanged($event->getId(), $event->isActive()));
        }

        if ($this->entity->lang_a !== $event->getLangA()) {
            $this->event(new Events\Apply\QuizLangAWasChanged($event->getId(), $event->getLangA()));
        }

        if ($this->entity->lang_b !== $event->getLangB()) {
            $this->event(new Events\Apply\QuizLangBWasChanged($event->getId(), $event->getLangB()));
        }

        $items = $event->getItems();

        /*
         * Remove all that are not present in items
         */
        $this->entity->items()->whereNotIn('id', array_filter(collect($items)->pluck('id')->toArray()))->each(function ($item) {
            $this->event(new Events\Apply\ItemWasDeleted($item->id));
        });

        $existingItems = $this->entity->items()->get();
        foreach ($items as $position => $item) {
            if ($item['id'] ?? null) {
                $found = $existingItems->firstWhere('id', $item['id']);
                // Check for change
                if (
                    $found->item_a !== $item['item_a']
                    || $found->item_b !== $item['item_b']
                    || $found->position !== $position
                    || $found->group !== $item['group']
                ) {
                    $this->event(new Events\Apply\ItemWasChanged(
                        $found->id,
                        $item['item_a'],
                        $item['item_b'],
                        $item['group'],
                        $position
                    ));
                }

                continue;
            }

            $this->event(new ItemWasCreated(
                null,
                $this->entity->id,
                $item['item_a'],
                $item['item_b'],
                $item['group'],
                $position,
            ));
        }
    }

    public function applyQuizNameWasChanged(Events\Apply\QuizNameWasChanged $event)
    {
        $this->entity->name = $event->getName();
    }

    public function applyQuizActiveWasChanged(Events\Apply\QuizActiveWasChanged $event)
    {
        $this->entity->active = $event->isActive();
    }

    public function applyQuizLangAWasChanged(Events\Apply\QuizLangAWasChanged $event)
    {
        $this->entity->lang_a = $event->getLangA();
    }

    public function applyQuizLangBWasChanged(Events\Apply\QuizLangBWasChanged $event)
    {
        $this->entity->lang_b = $event->getLangB();
    }
}
