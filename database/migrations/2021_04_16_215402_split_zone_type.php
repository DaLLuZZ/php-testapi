<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SplitZoneType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->dropUnique('UniqueTiming');
            $table->dropColumn('ZoneType');
        });

        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->unsignedInteger('ZoneNormal')->after('StyleId');
            $table->enum('ZoneType', ['Main', 'Checkpoint', 'Stage'])->after('ZoneNormal');
            $table->unique(['MapId', 'PlayerId', 'StyleId', 'ZoneNormal', 'ZoneType', 'ZoneOrdinal'], 'UniqueTiming');
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
            $table->dropUnique('UniqueTiming');
            $table->dropColumn('ZoneNormal');
            $table->dropColumn('ZoneType');
        });

        Schema::table('PlayerTiming', function (Blueprint $table) {
            $table->enum('ZoneType', ['Normal', 'Bonus', 'Checkpoint', 'Stage'])->after('StyleId');
            $table->unique(['MapId', 'PlayerId', 'StyleId', 'ZoneType', 'ZoneOrdinal'], 'UniqueTiming');
        });
    }
}
