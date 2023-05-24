<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumidityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('humidity_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('humidity');
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('humidity_logs');
    }
}
