<?php

namespace App\Events;

use Illuminate\Support\Collection;

trait QuizTrait
{
    private string $name;
    private string $lang_a;
    private string $lang_b;
    private array $items;
    private bool $active;

    /**
     * QuizCreateEvent constructor.
     * @param $id
     * @param string $name
     * @param string $lang_a
     * @param string $lang_b
     * @param array $items
     * @param bool $active
     */
    public function __construct($id, string $name, string $lang_a, string $lang_b, array $items, bool $active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lang_a = $lang_a;
        $this->lang_b = $lang_b;
        $this->items = $items;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLangA(): string
    {
        return $this->lang_a;
    }

    /**
     * @return string
     */
    public function getLangB(): string
    {
        return $this->lang_b;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    public static function fromPayload($id, Collection $collection)
    {
        return new self(
            $id,
            $collection->get('name'),
            $collection->get('lang_a'),
            $collection->get('lang_b'),
            $collection->get('items', []),
            $collection->get('active', false),
        );
    }

    public function toPayload(): array
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
            'lang_a' => $this->getLangA(),
            'lang_b' => $this->getLangB(),
            'items' => $this->getItems(),
            'active' => $this->isActive(),
        ];
    }
}
