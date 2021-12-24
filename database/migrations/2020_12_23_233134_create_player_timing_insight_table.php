<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePlayerTimingInsightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlayerTimingInsight', function (Blueprint $table) {
            $table->unsignedInteger('Id')->autoIncrement();
            $table->unsignedInteger('PlayerTimingId')->unique();
            $table->double('StartPositionX');
            $table->double('StartPositionY');
            $table->double('StartPositionZ');
            $table->double('EndPositionX');
            $table->double('EndPositionY');
            $table->double('EndPositionZ');
            $table->double('StartAngleX');
            $table->double('StartAngleY');
            $table->double('StartAngleZ');
            $table->double('EndAngleX');
            $table->double('EndAngleY');
            $table->double('EndAngleZ');
            $table->double('StartVelocityX');
            $table->double('StartVelocityY');
            $table->double('StartVelocityZ');
            $table->double('EndVelocityX');
            $table->double('EndVelocityY');
            $table->double('EndVelocityZ');
            $table->dateTimeTz('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTimeTz('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreignId('PlayerTimingId')->constrained('PlayerTiming', 'Id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('PlayerTimingInsight');
    }
}
