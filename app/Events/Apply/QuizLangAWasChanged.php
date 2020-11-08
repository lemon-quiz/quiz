<?php

namespace App\Events\Apply;

use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\ApplyEventInterface;
use LaravelCode\EventSourcing\Event\Apply\ApplyEvent;

class QuizLangAWasChanged extends ApplyEvent implements ApplyEventInterface
{
    private string $langA;

    public function __construct($id, $langA)
    {
        parent::__construct($id);
        $this->langA = $langA;
    }

    /**
     * @return string
     */
    public function getLangA(): string
    {
        return $this->langA;
    }

    public static function fromPayload($id, Collection $collection)
    {
        return new self(
            $id,
            $collection->get('lang_a')
        );
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->getId(),
            'lang_a' => $this->getLangA(),
        ];
    }
}
