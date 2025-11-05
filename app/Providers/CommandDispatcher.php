<?php

declare(strict_types=1);

namespace App\Providers;

use App\Commands\Hold\ConfirmHoldCommand;
use App\Commands\Hold\CreateHoldCommand;
use App\Commands\Hold\DeleteHoldCommand;
use App\Commands\Hold\Handlers\ConfirmHoldCommandHandler;
use App\Commands\Hold\Handlers\CreateHoldCommandHandler;
use App\Commands\Hold\Handlers\DeleteHoldCommandHandler;
use App\Contracts\CommandBusContract;
use Carbon\Laravel\ServiceProvider;

final class CommandDispatcher extends ServiceProvider
{
    public function boot(): void
    {
        $commandBus = $this->app->make(CommandBusContract::class);

        $commandBus->register(map: [
            CreateHoldCommand::class => CreateHoldCommandHandler::class,
            ConfirmHoldCommand::class => ConfirmHoldCommandHandler::class,
            DeleteHoldCommand::class => DeleteHoldCommandHandler::class,
        ]);
    }
}
