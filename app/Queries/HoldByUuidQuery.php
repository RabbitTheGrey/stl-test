<?php

declare(strict_types=1);

namespace App\Queries;

final class HoldByUuidQuery extends Query
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}