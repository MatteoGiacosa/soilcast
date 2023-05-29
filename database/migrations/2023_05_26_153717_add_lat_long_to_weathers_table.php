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
        Schema::table('weathers', function (Blueprint $table) {
            $table->decimal('lat', 10, 8)->nullable()->after('data');
            $table->decimal('long', 11, 8)->nullable()->after('lat');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weathers', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
        });
    }
};

