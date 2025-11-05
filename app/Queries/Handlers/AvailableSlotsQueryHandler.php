<?php

declare(strict_types=1);

namespace App\Queries\Handlers;

use App\Models\Slot;
use App\Queries\AvailableSlotsQuery;
use Illuminate\Support\Collection;

final class AvailableSlotsQueryHandler
{
    /**
     * Handler to AvailableSlotsQuery
     * 
     * @param AvailableSlotsQuery $query
     * 
     * @return array
     */
    public function handle(AvailableSlotsQuery $query): Collection
    {
        return Slot::where('remaining', '>',  0)
            ->get();
    }
}
