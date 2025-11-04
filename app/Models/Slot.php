<?php

declare(strict_types=1);

namespace App\Models;

use App\Exception\OversellException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model
 * 
 * @property int $id
 * @property int $capacity
 * @property int $remaining
 */
class Slot extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'capacity',
        'remaining',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    public function holds(): HasMany
    {
        return $this->hasMany(Hold::class);
    }

    /**
     * Увеличение остатка мест в слоте (при отмене бронирования)
     *
     * @return Slot
     * @throws OversellException
     */
    public function increaseRemaining(): static
    {
        if ($this->capacity < $this->remaining + 1) {
            throw new OversellException('Все места в слоте уже свободны');
        }

        $this->remaining++;

        return $this;
    }

    /**
     * Уменьшение остатка мест в слоте (при подтверждении бронирования)
     *
     * @return Slot
     * @throws OversellException
     */
    public function decreaseRemaining(): static
    {
        if (!$this->remaining) {
            throw new OversellException('Места в слоте исчерпаны');
        }

        $this->remaining--;

        return $this;
    }
}
