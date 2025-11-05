<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hold;
use App\Models\User;
use App\Service\SlotServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

#[Prefix('holds')]
#[Middleware(['api', 'auth:api'])]
final class HoldApicontroller extends Controller
{
    public function __construct(private readonly SlotServiceInterface $slotService)
    {

    }
    
    #[Post('{hold}/confirm')]
    public function confirm(Hold $hold, Request $request): JsonResponse
    {
        $this->checkAccess($hold, $request->user());
        $result = $this->slotService->confirm($hold);

        return new JsonResponse($result);
    }

    #[Delete('{hold}')]
    public function delete(Hold $hold, Request $request): JsonResponse
    {
        $this->checkAccess($hold, $request->user());
        $result = $this->slotService->delete($hold);

        return new JsonResponse($result);
    }

    /**
     * Проверка доступа пользователя к резервированию
     * Выбрасывает исключение - ошибку доступа в случае несоответствия
     *
     * @param Hold $hold
     * @param User $user
     *
     * @return void
     * @throws AccessDeniedHttpException
     */
    private function checkAccess(Hold $hold, User $user): void
    {
        if ($hold->user_id !== $user->id) {
            throw new AccessDeniedHttpException('Резервирование не принадлежит данному пользователю');
        }
    }
}
