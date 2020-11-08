<?php

namespace App\Events\Apply;

use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\ApplyEventInterface;
use LaravelCode\EventSourcing\Event\Apply\ApplyEvent;
use phpDocumentor\Reflection\Types\Integer;

class ItemWasChanged extends ApplyEvent implements ApplyEventInterface
{
    private string $itemA;
    private string $itemB;
    private int $group;
    private int $position;

    /**
     * ItemWasChanged constructor.
     * @param $id
     * @param string $itemA
     * @param string $itemB
     * @param int $group
     * @param int $position
     */
    public function __construct($id, string $itemA, string $itemB, int $group, int $position)
    {
        parent::__construct($id);
        $this->itemA = $itemA;
        $this->itemB = $itemB;
        $this->group = $group;
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getItemA(): string
    {
        return $this->itemA;
    }

    /**
     * @return string
     */
    public function getItemB(): string
    {
        return $this->itemB;
    }

    /**
     * @return int
     */
    public function getGroup(): int
    {
        return $this->group;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    public static function fromPayload($id, Collection $collection)
    {
        return new self(
            $id,
            $collection->get('item_a'),
            $collection->get('item_b'),
            $collection->get('group'),
            $collection->get('position')
        );
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->getId(),
            'item_a' => $this->getItemA(),
            'item_b' => $this->getItemB(),
            'group' => $this->getGroup(),
            'position' => $this->getPosition(),
        ];
    }
}
