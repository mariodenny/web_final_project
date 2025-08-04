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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->references('id')->on('devices');
            $table->string('name'); // wajib isi nama sensor i.e Suhu, Kelembapan Tanah, Lux
            $table->string('type'); // wajib isi tipe sensor i.e DHT22, Resistive Soil Sensor, BH1750
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
