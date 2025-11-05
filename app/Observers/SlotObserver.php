<?php

namespace App\Observers;

use App\Models\Slot;
use App\Service\SlotServiceInterface;

/**
 * Решил, что обсервер не нужен
 * Сохранил для истории
 */
class SlotObserver
{
    public function __construct(private readonly SlotServiceInterface $service)
    {

    }

    /**
     * Handle the Slot "created" event.
     */
    public function created(Slot $slot): void
    {
        // $this->service->warm();
    }

    /**
     * Handle the Slot "updated" event.
     */
    public function updated(Slot $slot): void
    {
        // $this->service->warm();
    }

    /**
     * Handle the Slot "deleted" event.
     */
    public function deleted(Slot $slot): void
    {
        // $this->service->warm();
    }
}
