<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePlayerTimingCheckpointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlayerTimingCheckpoint', function (Blueprint $table) {
            $table->id('Id')->autoIncrement();
            $table->foreignId('PlayerTimingId')->constrained('PlayerTiming', 'Id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('Checkpoint');
            $table->double('Time');
            $table->double('Sync');
            $table->unsignedInteger('Speed');
            $table->unsignedInteger('Jumps');
            $table->dateTimeTz('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTimeTz('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unique(['PlayerTimingId', 'Checkpoint']);
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
        Schema::dropIfExists('PlayerTimingCheckpoint');
    }
}
