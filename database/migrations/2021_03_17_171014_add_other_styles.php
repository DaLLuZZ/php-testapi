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
            DB::table('Style')->insert(['Name' => 'Sideways']);
            DB::table('Style')->insert(['Name' => 'Half-Sideways']);
            DB::table('Style')->insert(['Name' => 'Backwards']);
            DB::table('Style')->insert(['Name' => 'Low-Gravity']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('Style')->where('Normal', 'Sideways')->delete();
        DB::table('Style')->where('Normal', 'Half-Sideways')->delete();
        DB::table('Style')->where('Normal', 'Backwards')->delete();
        DB::table('Style')->where('Normal', 'Low-Gravity')->delete();
    }
}
