<?php

declare(strict_types=1);

namespace App\Commands\Hold;

use App\Commands\Command;
use App\Models\Slot;
use App\Models\User;

/**
 * Создание холда
 */
final class CreateHoldCommand extends Command
{
    private User $user;

    private Slot $slot;

    public function __construct(User $user, Slot $slot)
    {
        $this->user = $user;
        $this->slot = $slot;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getSlot(): Slot
    {
        return $this->slot;
    }
}
