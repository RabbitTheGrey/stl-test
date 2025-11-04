<?php

declare(strict_types=1);

namespace App\Commands\Hold\Handlers;

use App\Commands\Hold\ConfirmHoldCommand;
use App\Commands\Hold\Handlers\Traits\CascadeSaveTrait;
use App\Enum\HoldState;
use App\Models\Hold;
use App\Models\Slot;

final class ConfirmHoldCommandHandler
{
    use CascadeSaveTrait;

    private Hold $hold;
    private Slot $slot;

    /**
     * Handler to ConfirmHoldCommand
     * 
     * @return void
     */
    public function handle(ConfirmHoldCommand $command): void
    {
        $this->hold = $command->getHold();
        $this->slot = $this->hold->slot;

        /**
         * Выполняем запись только если холд еще не подтвержден
         */
        if (HoldState::tryFrom($this->hold->state) === HoldState::Held) {
            $this->hold->setState(HoldState::Confirmed);
            $this->slot->decreaseRemaining();

            $this->save();
        }
    }
}
