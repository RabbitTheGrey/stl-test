<?php

declare(strict_types=1);

namespace App\Buses;

use App\Contracts\QueryBusContract;
use App\Queries\Query;
use Illuminate\Contracts\Bus\Dispatcher;

final class QueryBus implements QueryBusContract
{
    public function __construct(private Dispatcher $queryBus)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(Query $query): mixed
    {
        return $this->queryBus->dispatch(command: $query);
    }

    /**
     * {@inheritDoc}
     */
    public function register(array $map): void
    {
        $this->queryBus->map(map: $map);
    }
}
