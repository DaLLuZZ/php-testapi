<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlayerLocations', function (Blueprint $table) {
            $table->id('Id')->autoIncrement();
            $table->foreignId('MapId')->constrained('Map', 'Id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('PlayerId')->constrained('Player', 'Id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('StyleId')->constrained('Style', 'Id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('Level');
            $table->enum('Type', ['Linear', 'Stage', 'Checkpoint']);
            $table->float('Tickrate');
            $table->double('Time')->nullable(true);
            $table->double('Sync');
            $table->unsignedInteger('Speed');
            $table->unsignedInteger('Jumps');
            $table->unsignedInteger('CSLevel');
            $table->double('CSTime')->nullable(true);
            $table->tinyInteger('Status')->default(1);
            $table->dateTimeTz('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTimeTz('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('PlayerLocations');
    }
}
