<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordSeederOneMap extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main times
        for ($main=0; $main < 10000000; $main++) {
            $map = random_int(291, 291);
            $style = random_int(1, 10);
            $level = random_int(0, 10);

            $mainid = DB::table('PlayerTiming')->insertGetId([
                'MapId' => $map,
                'PlayerId' => $main,
                'StyleId' => $style,
                'Level' => $level,
                'Type' => ($map % 2 == 0) ? "Stage" : "Checkpoint",
                'Tickrate' => 85.01,
                'Time' => random_int(30, 200) / M_PI,
                'TimeInZone' => random_int(4, 10) / M_PI,
                'Attempts' => random_int(1, 20),
                'Status' => 0
            ]);

            DB::table('PlayerTimingInsight')->insert([
                'PlayerTimingId' => $mainid,
                'StartPositionX' => random_int(60, 764) / 3.586,
                'StartPositionY' => random_int(60, 764) / 3.586,
                'StartPositionZ' => random_int(60, 764) / 3.586,
                'EndPositionX' => random_int(60, 764) / 3.586,
                'EndPositionY' => random_int(60, 764) / 3.586,
                'EndPositionZ' => random_int(60, 764) / 3.586,
                'StartAngleX' => random_int(60, 764) / 3.586,
                'StartAngleY' => random_int(60, 764) / 3.586,
                'StartAngleZ' => random_int(60, 764) / 3.586,
                'EndAngleX' => random_int(60, 764) / 3.586,
                'EndAngleY' => random_int(60, 764) / 3.586,
                'EndAngleZ' => random_int(60, 764) / 3.586,
                'StartVelocityX' => random_int(60, 764) / 3.586,
                'StartVelocityY' => random_int(60, 764) / 3.586,
                'StartVelocityZ' => random_int(60, 764) / 3.586,
                'EndVelocityX' => random_int(60, 764) / 3.586,
                'EndVelocityY' => random_int(60, 764) / 3.586,
                'EndVelocityZ' => random_int(60, 764) / 3.586,
            ]);

            if ($map % 2 == 0) {
                // Stage times
                for ($stage=1; $stage < 11; $stage++) {
                    $stageid = DB::table('PlayerTimingStage')->insertGetId([
                        'PlayerTimingId' => $mainid,
                        'Stage' => $stage,
                        'Time' => random_int(30, 200) / M_PI,
                        'TimeInZone' => random_int(5, 10) / M_PI,
                        'Attempts' => random_int(1, 20),
                    ]);

                    DB::table('PlayerTimingStageInsight')->insert([
                        'PlayerTimingStageId' => $stageid,
                        'StartPositionX' => random_int(60, 764) / 3.586,
                        'StartPositionY' => random_int(60, 764) / 3.586,
                        'StartPositionZ' => random_int(60, 764) / 3.586,
                        'EndPositionX' => random_int(60, 764) / 3.586,
                        'EndPositionY' => random_int(60, 764) / 3.586,
                        'EndPositionZ' => random_int(60, 764) / 3.586,
                        'StartAngleX' => random_int(60, 764) / 3.586,
                        'StartAngleY' => random_int(60, 764) / 3.586,
                        'StartAngleZ' => random_int(60, 764) / 3.586,
                        'EndAngleX' => random_int(60, 764) / 3.586,
                        'EndAngleY' => random_int(60, 764) / 3.586,
                        'EndAngleZ' => random_int(60, 764) / 3.586,
                        'StartVelocityX' => random_int(60, 764) / 3.586,
                        'StartVelocityY' => random_int(60, 764) / 3.586,
                        'StartVelocityZ' => random_int(60, 764) / 3.586,
                        'EndVelocityX' => random_int(60, 764) / 3.586,
                        'EndVelocityY' => random_int(60, 764) / 3.586,
                        'EndVelocityZ' => random_int(60, 764) / 3.586,
                    ]);
                }
            }
            else {
                // Checkpoint times
                for ($checkpoint=1; $checkpoint < 11; $checkpoint++) {
                    $stageid = DB::table('PlayerTimingCheckpoint')->insertGetId([
                        'PlayerTimingId' => $mainid,
                        'Checkpoint' => $checkpoint,
                        'Time' => random_int(30, 200) / M_PI,
                    ]);

                    DB::table('PlayerTimingCheckpointInsight')->insert([
                        'PlayerTimingCheckpointId' => $stageid,
                        'PositionX' => random_int(60, 764) / 3.586,
                        'PositionY' => random_int(60, 764) / 3.586,
                        'PositionZ' => random_int(60, 764) / 3.586,
                        'AngleX' => random_int(60, 764) / 3.586,
                        'AngleY' => random_int(60, 764) / 3.586,
                        'AngleZ' => random_int(60, 764) / 3.586,
                        'VelocityX' => random_int(60, 764) / 3.586,
                        'VelocityY' => random_int(60, 764) / 3.586,
                        'VelocityZ' => random_int(60, 764) / 3.586,
                    ]);
                }
            }
        }
    }
}
