<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerLocationInsightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlayerLocationInsight', function (Blueprint $table) {
            $table->unsignedInteger('Id')->autoIncrement();
            $table->unsignedInteger('PlayerLocationId')->unique();
            $table->double('PositionX');
            $table->double('PositionY');
            $table->double('PositionZ');
            $table->double('AngleX');
            $table->double('AngleY');
            $table->double('AngleZ');
            $table->double('VelocityX');
            $table->double('VelocityY');
            $table->double('VelocityZ');
            $table->dateTimeTz('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTimeTz('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreignId('PlayerLocationId')->constrained('PlayerLocation', 'Id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('PlayerLocationInsight');
    }
}
