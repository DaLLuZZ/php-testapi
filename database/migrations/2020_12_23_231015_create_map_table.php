<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Map', function (Blueprint $table) {
            $table->unsignedInteger('Id')->autoIncrement();
            $table->string('Name', 32);
            $table->unsignedTinyInteger('Tier');
            $table->boolean('IsActive')->default(1);
            $table->timestamp('CreatedDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('LastModifiedDate')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unique('Name');
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
        Schema::dropIfExists('Map');
    }
}
