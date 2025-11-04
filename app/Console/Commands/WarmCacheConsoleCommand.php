<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Service\SlotServiceInterface;
use Illuminate\Console\Command;

final class WarmCacheConsoleCommand extends Command
{
    protected $signature = 'slots:warm';
    protected $description = 'Прогрев кеша';

    public function __construct(private readonly SlotServiceInterface $slotService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->slotService->warm();
    }
}
