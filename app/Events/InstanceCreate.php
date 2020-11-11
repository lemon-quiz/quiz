<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\EventInterface;
use LaravelCode\EventSourcing\EventSourcing\StoreEvent;
use phpDocumentor\Reflection\Types\Integer;

class InstanceCreate implements EventInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels, StoreEvent;

    private string $quizId;
    private string $lang;
    private int $numQuestions;
    private int $numAnswers;
    private $group;

    /**
     * InstanceCreate constructor.
     * @param $id
     * @param string $quizId
     * @param string $lang
     * @param int $numQuestions
     * @param int $numAnswers
     * @param int|null $group
     */
    public function __construct($id, string $quizId, string $lang, int $numQuestions, int $numAnswers, int $group = null)
    {
        $this->id = $id;
        $this->quizId = $quizId;
        $this->lang = $lang;
        $this->numQuestions = $numQuestions;
        $this->numAnswers = $numAnswers;
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getQuizId(): string
    {
        return $this->quizId;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getNumQuestions(): int
    {
        return $this->numQuestions;
    }

    /**
     * @return int
     */
    public function getNumAnswers(): int
    {
        return $this->numAnswers;
    }

    /**
     * @return int|null
     */
    public function getGroup(): ?int
    {
        return $this->group;
    }

    public static function fromPayload($id, Collection $collection)
    {
        return new self(
            $id,
            $collection->get('quiz_id'),
            $collection->get('lang'),
            $collection->get('num_questions'),
            $collection->get('num_answers'),
            $collection->get('group')
        );
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->getId(),
            'quiz_id' => $this->getQuizId(),
            'lang' => $this->getLang(),
            'num_questions' => $this->getNumQuestions(),
            'num_answers' => $this->getNumAnswers(),
            'group' => $this->getGroup(),
        ];
    }
}
