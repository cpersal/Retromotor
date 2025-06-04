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
        Schema::table('piezas', function (Blueprint $table) {
            $table->string('foto_original')->nullable()->after('foto');
        });
    }

    public function down()
    {
        Schema::table('piezas', function (Blueprint $table) {
            $table->dropColumn('foto_original');
        });
    }
};
