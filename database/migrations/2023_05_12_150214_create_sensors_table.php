<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('mac')->nullable();
            $table->double('minHumidity')->nullable();
            $table->double('maxHumidity')->nullable();
            $table->string('DataCollection')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('control_unit_id');
            $table->foreign('control_unit_id')->references('id')->on('control_units')->onDelete('cascade');

            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');

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
