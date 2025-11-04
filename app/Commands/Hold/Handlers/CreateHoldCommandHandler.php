<?php

declare(strict_types=1);

namespace App\Commands\Hold\Handlers;

use App\Commands\Hold\CreateHoldCommand;
use App\Enum\HoldState;
use App\Models\Hold;

final class CreateHoldCommandHandler
{
    /**
     * Handler to CreateHoldCommand
     *
     * @return void
     */
    public function handle(CreateHoldCommand $command): void
    {
        if ($command->getSlot()->remaining) {
            $hold = new Hold([
                'user_id' => $command->getUser()->id,
                'slot_id' => $command->getSlot()->id,
            ]);

            $hold->setState(HoldState::Held);
            $hold->save();
        }
    }
}