<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttemptsAndTimeInZoneColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->double('TimeInZone')->after('Duration');
            $table->unsignedInteger('Attempts')->after('TimeInZone');
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
            $table->dropColumn('TimeInZone');
            $table->dropColumn('Attempts');
        });
    }
}
