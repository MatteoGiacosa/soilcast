<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('weather_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weather_id');
            $table->foreign('weather_id')->references('id')->on('weathers')->onDelete('cascade');
            $table->float('temperature');
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_histories');
    }
};
