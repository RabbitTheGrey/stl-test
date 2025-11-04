<?php

declare(strict_types=1);

namespace App\Commands\Hold;

use App\Commands\Command;
use App\Models\Hold;

/**
 * Подтверждение холда - перевод в статус `confirmed`
 */
final class ConfirmHoldCommand extends Command
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
