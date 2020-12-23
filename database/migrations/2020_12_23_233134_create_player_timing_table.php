<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerTimingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlayerTiming', function (Blueprint $table) {
            $table->unsignedInteger('Id')->autoIncrement();
            $table->unsignedInteger('PlayerId');
            $table->unsignedInteger('MapId');
            $table->unsignedInteger('StyleId');
            $table->enum('ZoneType', ['Normal', 'Bonus', 'Checkpoint', 'Stage']);
            $table->unsignedInteger('ZoneOrdinal');
            $table->time('Duration');
            $table->boolean('IsRanked')->default(1);
            $table->timestamp('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unique(array('PlayerId', 'MapId', 'StyleId', 'ZoneType', 'ZoneOrdinal'));
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PlayerTiming');
    }
}
