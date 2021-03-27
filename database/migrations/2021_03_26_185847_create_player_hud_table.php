<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerHudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlayerHud', function (Blueprint $table) {
            $table->unsignedInteger('PlayerId');
            $table->enum('Side', ['Left', 'Right']);
            $table->unsignedTinyInteger('Line');
            $table->unsignedTinyInteger('Key');
            $table->dateTimeTz('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTimeTz('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unique(['PlayerId', 'Key']);
            $table->unique(['PlayerId', 'Side', 'Line']);
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
        Schema::dropIfExists('PlayerHud');
    }
}
