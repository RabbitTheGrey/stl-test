<?php

declare(strict_types=1);

namespace App\Commands\Hold;

use App\Commands\Command;
use App\Models\Hold;

/**
 * Мягкое удаление холда - перевод в статус `cancelled`
 */
final class DeleteHoldCommand extends Command
{
    private ?Hold $hold = null;

    public function __construct(Hold $hold)
    {
        $this->hold = $hold;
    }

    public function getHold(): ?Hold
    {
        return $this->hold;
    }
}
