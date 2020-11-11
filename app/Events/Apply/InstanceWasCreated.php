<?php

namespace App\Events\Apply;

use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\ApplyEventInterface;
use LaravelCode\EventSourcing\Event\Apply\ApplyEvent;

class InstanceWasCreated extends ApplyEvent implements ApplyEventInterface
{
    private string $quizId;
    private string $lang;
    private int $numQuestions;
    private int $numAnswers;
    private ?int $group;
    private array $data;

    /**
     * InstanceCreate constructor.
     * @param $id
     * @param array $data
     * @param string $quizId
     * @param string $lang
     * @param int $numQuestions
     * @param int $numAnswers
     * @param int|null $group
     */
    public function __construct($id, array $data, string $quizId, string $lang, int $numQuestions, int $numAnswers, int $group = null)
    {
        parent::__construct($id);
        $this->data = $data;
        $this->quizId = $quizId;
        $this->lang = $lang;
        $this->numQuestions = $numQuestions;
        $this->numAnswers = $numAnswers;
        $this->group = $group;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
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
            $collection->get('data'),
            $collection->get('quiz_id'),
            $collection->get('lang'),
            $collection->get('num_question'),
            $collection->get('num_answer'),
            $collection->get('group')
        );
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->getId(),
            'data' => $this->getData(),
            'quiz_id' => $this->getQuizId(),
            'lang' => $this->getLang(),
            'num_question' => $this->getNumQuestions(),
            'num_answer' => $this->getNumAnswers(),
            'group' => $this->getGroup(),
        ];
    }
}
