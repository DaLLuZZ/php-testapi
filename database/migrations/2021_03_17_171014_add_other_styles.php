<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherStyles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('Style')) {
            DB::table('Style')->insert(['Id' => '2', 'Name' => 'Sideways']);
            DB::table('Style')->insert(['Id' => '3', 'Name' => 'Half-Sideways']);
            DB::table('Style')->insert(['Id' => '4', 'Name' => 'Backwards']);
            DB::table('Style')->insert(['Id' => '5', 'Name' => 'Low-Gravity']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('Style')->where('Id', '2')->delete();
        DB::table('Style')->where('Id', '3')->delete();
        DB::table('Style')->where('Id', '4')->delete();
        DB::table('Style')->where('Id', '5')->delete();
    }
}