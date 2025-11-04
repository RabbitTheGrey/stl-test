<?php

use App\Models\Slot;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->string('state', 10); // Состояние брони
            $table->foreignIdFor(Slot::class, 'slot_id'); // Забронированный слот
            $table->foreignIdFor(User::class, column: 'user_id'); // Пользователь, забронировавший слот
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holds');
    }
};
