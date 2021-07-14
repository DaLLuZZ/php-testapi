<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTickrateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->double('Tickrate')->after('ZoneOrdinal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->dropColumn('Tickrate');
        });
    }
}
