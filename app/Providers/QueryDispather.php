<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\QueryBusContract;
use App\Queries\AvailableSlotsQuery;
use App\Queries\Handlers\AvailableSlotsQueryHandler;
use Carbon\Laravel\ServiceProvider;

final class QueryDispather extends ServiceProvider
{
    public function boot(): void
    {
        $queryBus = $this->app->make(QueryBusContract::class);

        $queryBus->register(map: [
            AvailableSlotsQuery::class => AvailableSlotsQueryHandler::class,
        ]);
    }
}