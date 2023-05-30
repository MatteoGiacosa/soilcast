<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHumidityLogsTable extends Migration
{
    public function up()
    {
        DB::statement('SET SESSION sql_require_primary_key=0');
        Schema::create('humidity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mac');
            $table->integer('humidity');
            $table->integer('battery');
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->unsignedBigInteger('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
    }

    public function down()
    {
        Schema::dropIfExists('humidity_logs');
    }
}
