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
    public function up()
    {
        DB::statement('SET SESSION sql_require_primary_key=0');
        Schema::create('weathers', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code');
            $table->string('country_code');
            $table->json('data');
            $table->timestamps();

            $table->unsignedBigInteger('control_unit_id')->nullable();
            $table->foreign('control_unit_id')->references('id')->on('control_units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weathers');
    }
};
