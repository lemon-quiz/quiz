<?php

namespace App\Listeners;

use App\Events;
use App\Models\Item;
use LaravelCode\EventSourcing\Listeners\ApplyListener;

/**
 * Class ItemCreateListener.
 *
 * @property Item $entity
 */
class ItemCreateListener
{
    use ApplyListener;

    /**
     * Set if the program is unable to guess the model class.
     */
    public $model = Item::class;

    /**
     * @param Events\Apply\ItemWasCreated $event
     */
    public function applyItemWasCreated(Events\Apply\ItemWasCreated $event)
    {
        $this->entity->item_a = $event->getItemA();
        $this->entity->item_b = $event->getItemB();
        $this->entity->group = $event->getGroup();
        $this->entity->position = $event->getPosition();
        $this->entity->quiz_id = $event->getQuizId();
    }

    /**
     * @param Events\Apply\ItemWasChanged $event
     */
    public function applyItemWasChanged(Events\Apply\ItemWasChanged $event)
    {
        $this->entity->item_a = $event->getItemA();
        $this->entity->item_b = $event->getItemB();
        $this->entity->group = $event->getGroup();
        $this->entity->position = $event->getPosition();
    }

    /**
     * @param Events\Apply\ItemWasDeleted $event
     */
    public function applyItemWasDeleted(Events\Apply\ItemWasDeleted $event)
    {
        $this->delete();
    }
}
