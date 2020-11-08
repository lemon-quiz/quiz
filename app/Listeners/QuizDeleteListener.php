<?php

namespace App\Listeners;

use App\Events;
use App\Events\Apply\QuizWasDeleted;
use App\Model\User;
use App\Models\Quiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaravelCode\EventSourcing\Contracts\EventInterface;
use LaravelCode\EventSourcing\Listeners\ApplyListener;

class QuizDeleteListener
{
    use ApplyListener;

    /**
     * Set if the program is unable to guess the model class.
     */
    public $model = Quiz::class;

    /**
     * Handle the event.
     *
     * @param Events\QuizDelete $event
     * @return void
     */
    public function handleCommand(Events\QuizDelete $event)
    {
        $this->event(new Events\Apply\QuizWasDeleted($event->getId()));
    }

    /**
     * @param Events\Apply\QuizWasDeleted $event
     */
    public function applyQuizWasDeleted(QuizWasDeleted $event)
    {
        $this->delete();
    }
}
