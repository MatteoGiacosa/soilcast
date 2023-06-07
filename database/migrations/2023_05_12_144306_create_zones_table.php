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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('zoneName');
            $table->boolean('connected')->nullable();
            $table->string('image');
            $table->time('nextWatering', $precision = 0)->nullable();
            $table->time('lastWatering', $precision = 0)->nullable();
            $table->time('latWateringStart', $precision = 0)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('control_unit_id');
            $table->foreign('control_unit_id')->references('id')->on('control_units')->onDelete('cascade');
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
