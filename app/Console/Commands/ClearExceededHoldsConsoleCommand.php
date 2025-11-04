<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Hold;
use App\Service\SlotService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class ClearExceededHoldsConsoleCommand extends Command
{
    protected $signature = 'holds:clear';
    protected $description = 'Очистка холдов неподтвержденных в течение 5 минут';

    public function __construct(private readonly SlotService $slotService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $exceededHolds = Hold::where('created_at', '<', Carbon::now()->modify('-5 minutes'))->get();

        foreach ($exceededHolds as $hold) {
            $this->slotService->delete($hold);
        }
    }
}
