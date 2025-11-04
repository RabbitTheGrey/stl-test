<?php

declare(strict_types=1);

namespace App\DTO;

use App\Models\Slot;
use Illuminate\Support\Collection;

final class AvailabilityDTO
{
    public ?int $id = null;

    public ?int $capacity = null;

    public ?int $remaining = null;

    public static function fromEntity(Slot $slot): static
    {
        $dto = new static();
        $dto->id = $slot->id;
        $dto->capacity = $slot->capacity;
        $dto->remaining = $slot->remaining;

        return $dto;
    } 

    public static function fromCollection(Collection $collection): Collection
    {
        return $collection->map(
            fn (Slot $slot): static => self::fromEntity($slot)
        );
    }

    public function toArray()
    {
        return [
            'slot_id' => $this->id,
            'capacity' => $this->capacity,
            'remaining' => $this->remaining,
        ];
    }
}