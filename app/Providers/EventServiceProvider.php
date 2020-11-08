<?php

namespace App\Providers;

use App\Listeners\ItemCreateListener;
use App\Listeners\QuizChangeListener;
use App\Listeners\QuizCreateListener;
use App\Listeners\QuizDeleteListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
//    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
//    ];

    /**
     * Subscribe the Event listeners.
     *
     * @var string[]
     */
    protected array $subscribe = [
        QuizCreateListener::class,
        QuizChangeListener::class,
        QuizDeleteListener::class,
        ItemCreateListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
