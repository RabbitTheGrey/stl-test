<?php

namespace App\Providers;

use App\Buses\CommandBus;
use App\Buses\QueryBus;
use App\Contracts\CommandBusContract;
use App\Contracts\QueryBusContract;
use App\Service\SlotService;
use App\Service\SlotServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: CommandBusContract::class,
            concrete: CommandBus::class
        );

        $this->app->singleton(
            abstract: QueryBusContract::class,
            concrete: QueryBus::class
        );

        $this->app->bind(
            abstract: SlotServiceInterface::class,
            concrete: SlotService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
