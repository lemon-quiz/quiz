<?php

namespace App\Events\Apply;

use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\ApplyEventInterface;
use LaravelCode\EventSourcing\Event\Apply\ApplyEvent;

class QuizLangBWasChanged extends ApplyEvent implements ApplyEventInterface
{
    private string $langB;

    public function __construct($id, $langB)
    {
        parent::__construct($id);
        $this->langB = $langB;
    }

    /**
     * @return string
     */
    public function getLangB(): string
    {
        return $this->langB;
    }

    public static function fromPayload($id, Collection $collection)
    {
        return new self(
            $id,
            $collection->get('lang_b')
        );
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->getId(),
            'lang_b' => $this->getLangB(),
        ];
    }
}
