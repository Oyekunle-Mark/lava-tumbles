<?php

namespace App\Providers;

use App\Contracts\CounterContract;
use App\Services\Counter;
use App\Services\DummyCounter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\Comment as CommentResource;

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
        Schema::defaultStringLength(191);

        $this->app->singleton(Counter::class, function ($app) {
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT'),
            );
        });

        $this->app->bind(
            CounterContract::class,
            Counter::class,
        );

        // $this->app->bind(
        //     CounterContract::class,
        //     DummyCounter::class,
        // );

        // $this->app->when(Counter::class)
        //     ->needs('$timeout')
        //     ->give(env('COUNTER_TIMEOUT'));

        CommentResource::withoutWrapping();
    }
}
