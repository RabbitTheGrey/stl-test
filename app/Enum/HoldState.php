<?php

declare(strict_types=1);

namespace App\Enum;

enum HoldState: string
{
    case Held = 'held'; // Зарезервирован
    case Confirmed = 'confirmed'; // Подтвержден
    case Cancelled = 'cancelled'; // Отменен
}