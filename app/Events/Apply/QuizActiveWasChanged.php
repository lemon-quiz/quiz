<?php

namespace App\Events\Apply;

use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\ApplyEventInterface;
use LaravelCode\EventSourcing\Event\Apply\ApplyEvent;

class QuizActiveWasChanged extends ApplyEvent implements ApplyEventInterface
{
    private bool $active;

    public function __construct($id, bool $active)
    {
        parent::__construct($id);
        $this->active = $active;
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
            $collection->get('active')
        );
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->getId(),
            'active' => $this->isActive(),
        ];
    }
}
