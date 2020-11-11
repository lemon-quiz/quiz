<?php

namespace App\Providers;

use App\Listeners\InstanceCreateListener;
use App\Listeners\ItemCreateListener;
use App\Listeners\QuizChangeListener;
use App\Listeners\QuizCreateListener;
use App\Listeners\QuizDeleteListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
    protected $subscribe = [
        QuizCreateListener::class,
        QuizChangeListener::class,
        QuizDeleteListener::class,
        ItemCreateListener::class,
        InstanceCreateListener::class,
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
