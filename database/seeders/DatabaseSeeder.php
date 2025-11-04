<?php

namespace Database\Seeders;

use App\Models\Slot;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Slot::factory()->create([
            'capacity' => 10,
            'remaining' => 10,
        ]);

        Slot::factory()->create([
            'capacity' => 5,
            'remaining' => 5,
        ]);

        User::factory()->create([
            'name' => 'test_user',
            'email' => 'example@mail.ru',
        ]);
    }
}
