<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Commands\Command;

interface CommandBusContract
{
    /**
     * Выполнение команды и возврат результата
     * 
     * @param Command $command
     *
     * @return mixed|null
     */
    public function dispatch(Command $command): mixed;

    /**
     * Регистрация зависимостей команд от исполнителей
     * 
     * @param array<string, string> $map <Command::class, CommandHandler::class>
     * 
     * @return void
     */
    public function register(array $map): void;
}
