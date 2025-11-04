<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Queries\Query;

interface QueryBusContract
{
    /**
     * Выполнение запроса и возврат результата
     * 
     * @param Query $query
     *
     * @return mixed|null
     */
    public function dispatch(Query $query): mixed;

    /**
     * Регистрация зависимостей запросов от исполнителей
     * 
     * @param array<string, string> $map <Query::class, QueryHandler::class>
     * 
     * @return void
     */
    public function register(array $map): void;
}
