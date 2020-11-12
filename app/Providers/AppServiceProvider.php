<?php

namespace App\Providers;

use App\Factory\Generator;
use App\Generators\QuizGenerator;
use App\Models\Quiz;
use DB;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug')) {
            DB::listen(function ($query) {
                Log::channel('debug')->info(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
            });
        }

        app()->bind(Generator::class, function () {
            return new Generator(new QuizGenerator(new Quiz()));
        });
    }
}
