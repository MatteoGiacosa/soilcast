<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET SESSION sql_require_primary_key=0');
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->boolean('connected')->nullable();
            $table->double('battery')->nullable();
            $table->double('humidityPercentage')->nullable();
            $table->time('latestDataCollection')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('control_unit_id');
            $table->foreign('control_unit_id')->references('id')->on('control_units');

            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');

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
