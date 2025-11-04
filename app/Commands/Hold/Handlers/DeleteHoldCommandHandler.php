<?php

declare(strict_types=1);

namespace App\Commands\Hold\Handlers;

use App\Commands\Hold\DeleteHoldCommand;
use App\Commands\Hold\Handlers\Traits\CascadeSaveTrait;
use App\Enum\HoldState;
use App\Models\Hold;
use App\Models\Slot;

final class DeleteHoldCommandHandler
{
    use CascadeSaveTrait;

    private Hold $hold;
    private Slot $slot;

    /**
     * Handler to DeleteHoldCommand
     * 
     * @return void
     */
    public function handle(DeleteHoldCommand $command): void
    {
        $this->hold = $command->getHold();
        $this->slot = $this->hold->slot;

        /**
         * Не выполняем запись если холд уже отменен
         */
        match(HoldState::tryFrom($this->hold->state)) {
            HoldState::Held => $this->hold->setState(HoldState::Cancelled),
            HoldState::Confirmed => $this->hold->setState(HoldState::Cancelled) && $this->slot->increaseRemaining(),
            HoldState::Cancelled => null,
        };

        $this->save();
    }
}
