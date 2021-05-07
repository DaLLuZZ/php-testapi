<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTIckrateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->unsignedInteger('Tickrate')->after('ZoneOrdinal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('PlayerTiming')) {
            if (Schema::hasColumn('PlayerTiming', 'Tickrate')) {
                Schema::table('PlayerTiming', function (Blueprint $table) {
                    $table->dropColumn('Tickrate');
                });
            }
        }
    }
}
