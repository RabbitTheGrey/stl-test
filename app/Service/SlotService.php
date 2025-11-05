<?php

declare(strict_types=1);

namespace App\Service;

use App\Commands\Hold\ConfirmHoldCommand;
use App\Commands\Hold\CreateHoldCommand;
use App\Commands\Hold\DeleteHoldCommand;
use App\Contracts\CommandBusContract;
use App\Contracts\QueryBusContract;
use App\DTO\AvailabilityDTO;
use App\Enum\HoldState;
use App\Exception\OversellException;
use App\Models\Hold;
use App\Models\Slot;
use App\Models\User;
use App\Queries\AvailableSlotsQuery;
use Illuminate\Log\Logger;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Throwable;

/**
 * Принял решение сохранять uuid в redis для избежания лишних обращений в бд,
 * тк редис работает быстрее, а uuid не пригодится нам в дальнейшем,
 * и дольше 5 минут его хранить смысла не имеет
 */
final class SlotService implements SlotServiceInterface
{
    private const CACHE_KEY = 'available_slots';

    /**
     * @var string
     * 
     * @example "uuid_1" uuid_{user_id}
     */
    private const CACHE_IDEMPOTENCY_PREFIX = 'uuid_';
    private const CACHE_IDEMPOTENCY_TIMEOUT = 300;

    public function __construct(
        private readonly CommandBusContract $commandBus,
        private readonly Logger $logger,
        private readonly QueryBusContract $queryBus,
    ) {}

    public function warm(): void
    {
        // Видит Бог, не хотел я использовать фасад таким образом, но Laravel оказался категорически против DI
        Cache::forever(static::CACHE_KEY, $this->availability());
    }

    public function availabilityCache(): Collection
    {
        $cache = Cache::get(static::CACHE_KEY);

        return $cache ?? $this->availability(); 
    }

    /**
     * {@inheritDoc}
     */
    public function hold(string $idempotencyKey, User $user, Slot $slot): bool
    {
        try {
            $uuid = $this->getIdempotencyKey($user);

            /**
             * Проверка повторного резервирования
             */
            if ($uuid !== $idempotencyKey) {
                $this->commandBus->dispatch(new CreateHoldCommand(
                    user: $user,
                    slot: $slot,
                ));

                /**
                 * Устанавливаем временную защиту от повторного резервирования
                 */
                $this->setIdempotencyKey($user, $idempotencyKey);
            }
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function confirm(Hold $hold): bool
    {
        if (HoldState::tryFrom($hold->state) === HoldState::Cancelled) {
            throw new BadRequestException('Нельзя подтвердить отмененный холд');
        }

        try {
            $this->commandBus->dispatch(new ConfirmHoldCommand($hold));
        } catch (OversellException $e) {
            $message = $e->getMessage();
            $this->logger->error($message);
            throw new ConflictHttpException($message);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Hold $hold): bool
    {
        try {
            $this->commandBus->dispatch(new DeleteHoldCommand($hold));
        } catch (OversellException $e) {
            $message = $e->getMessage();
            $this->logger->error($message);
            throw new ConflictHttpException($message);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    private function availability(): Collection
    {
        $result = $this->queryBus->dispatch(new AvailableSlotsQuery());

        $dtoCollection = AvailabilityDTO::fromCollection($result);

        return $dtoCollection->map(fn (AvailabilityDTO $dto) => $dto->toArray());
    }

    private function getIdempotencyKey(User $user): ?string
    {
        return Cache::get(self::CACHE_IDEMPOTENCY_PREFIX . $user->id);
    }

    private function setIdempotencyKey(User $user, string $key): void
    {
        Cache::put(self::CACHE_IDEMPOTENCY_PREFIX . $user->id, $key, self::CACHE_IDEMPOTENCY_TIMEOUT);
    }
}
