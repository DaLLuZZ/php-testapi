<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 100000; $i++) {
            DB::table('Player')->insertGetId([
                'Id' => $i,
                'CommunityId' => random_int(100000, 999999999),
                'Name' => 'Player' . $i,
                'Status' => random_int(0, 1)
            ]);

            for ($j=0; $j < 8; $j++) {
                DB::table('PlayerHud')->insert([
                    'PlayerId' => $i,
                    'Side' => $j > 3 ? 'Right' : 'Left',
                    'Line' => $j+1,
                    'Key' => $j
                ]);
            }

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUD',
                'Value' => 1
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDLength',
                'Value' => 16
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDScale',
                'Value' => 'm'
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDSeparator',
                'Value' => 0
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDShowSpeedUni',
                'Value' => 0
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDShowTime0Hou',
                'Value' => 0
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDSpeed',
                'Value' => 'm'
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'HUDTime',
                'Value' => 0
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'InvalidKeyPref',
                'Value' => 1
            ]);

            DB::table('PlayerSettings')->insert([
                'PlayerId' => $i,
                'Setting' => 'Style',
                'Value' => 1
            ]);
        }
    }
}
