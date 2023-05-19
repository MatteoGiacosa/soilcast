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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('zoneName');
            $table->boolean('connected')->nullable();
            $table->binary('image');
            $table->time('nextWatering', $precision = 0)->nullable();
            $table->time('lastWatering', $precision = 0)->nullable();
            $table->time('latWateringStart', $precision = 0)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('control_unit_id');
            $table->foreign('control_unit_id')->references('id')->on('control_units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
