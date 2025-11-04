<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Hold;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * Сервисная прослойка с кешированием
 */
interface SlotServiceInterface
{
    /**
     * Получение списка доступных слотов
     * 
     * @return Collection of Slot
     */
    public function availabilityCache(): Collection;

    /**
     * Создание холда
     *
     * @param string $idempotencyKey <UUID>
     * @param User $user
     * @param Slot $slot
     *
     * @return bool
     */
    public function hold(string $idempotencyKey, User $user, Slot $slot): bool;

    /**
     * Подтверждение холда
     *
     * @param Hold $hold
     *
     * @return bool
     * @throws BadRequestException
     * @throws ConflictHttpException
     */
    public function confirm(Hold $hold): bool;

    /**
     * Отмена холда
     * 
     * @param Hold $hold
     * 
     * @return bool
     * @throws ConflictHttpException
     */
    public function delete(Hold $hold): bool;

    /**
     * Прогрев кеша
     */
    public function warm(): void;
}
