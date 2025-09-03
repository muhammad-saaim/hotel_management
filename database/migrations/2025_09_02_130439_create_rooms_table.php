<?php

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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Room name
            $table->string('type');               // Room type (e.g., Single, Double, Suite)
            $table->decimal('price', 8, 2);      // Room price per night
            $table->integer('capacity');          // Number of people the room can accommodate
            $table->boolean('is_available')->default(true); // Availability status
            $table->timestamps();                 // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
