<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 100000; $i++) {
            DB::table('Player')->insert([
                'Id' => random_int(100000, 999999999),
                'CommunityId' => random_int(100000, 999999999),
                'Name' => Str::random(32),
                'Status' => random_int(0, 1)
            ]);
        }
    }
}
