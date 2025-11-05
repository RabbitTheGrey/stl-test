<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use App\Service\SlotServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

#[Prefix('slots')]
#[Middleware(['api', 'auth:api'])]
final class SlotApiController extends Controller
{
    public function __construct(private readonly SlotServiceInterface $slotService)
    {

    }

    #[Get('availability')]
    public function availability(): JsonResponse
    {
        $response = $this->slotService->availabilityCache();

        return new JsonResponse($response);
    }

    #[Post('{slot}/hold')]
    public function hold(Request $request, Slot $slot): JsonResponse
    {
        /**
         * UUID для резервирования ячейки генерирует клиентская сторона
         * для обработки случайного повторного клика
         * 
         * @var string $idempotencyKey
         */
        $idempotencyKey = $request->headers->get('Idempotency-Key');

        if (!$idempotencyKey) {
            throw new BadRequestException('header `Idempotency-Key` not found!');
        }

        $response = $this->slotService->hold($idempotencyKey, $request->user(), $slot);

        return new JsonResponse($response);
    }
}
