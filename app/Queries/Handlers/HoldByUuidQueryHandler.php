<?php

declare(strict_types=1);

namespace App\Queries\Handlers;

use App\Models\Hold;
use App\Queries\HoldByUuidQuery;

final class HoldByUuidQueryHandler
{
    /**
     * Handler to HoldByUuidQuery
     * 
     * @param HoldByUuidQuery $query
     * 
     * @return Hold|null
     */
    public function handle(HoldByUuidQuery $query): ?Hold
    {
        return Hold::where('uuid', '=', $query->getUuid())->first();
    }
}
