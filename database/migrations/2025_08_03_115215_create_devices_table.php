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

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->references('id')->on('plants');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('last_active_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
