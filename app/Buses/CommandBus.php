<?php

declare(strict_types=1);

namespace App\Buses;

use App\Contracts\CommandBusContract;
use App\Commands\Command;
use Illuminate\Contracts\Bus\Dispatcher;

final class CommandBus implements CommandBusContract
{
    public function __construct(private Dispatcher $commandBus)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(Command $command): mixed
    {
        return $this->commandBus->dispatch(
            command: $command
        );
    }

    /**
     * {@inheritDoc}
     */
    public function register(array $map): void
    {
        $this->commandBus->map(map: $map);
    }
}
