<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main times
        for ($main=0; $main < 100000; $main++) {
            $map = random_int(1, 500);
            $style = random_int(1, 10);
            $level = random_int(0, 10);

            $id = DB::table('PlayerTiming')->insertGetId([
                'MapId' => $map,
                'PlayerId' => $main,
                'StyleId' => $style,
                'Level' => $level,
                'Tickrate' => 100,
                'Time' => random_int(10, 200) / M_PI,
                'TimeInZone' => random_int(1, 10) / M_PI,
                'Attempts' => random_int(1, 20),
                'Status' => 0
            ]);

            DB::table('PlayerTimingInsight')->insert([
                'PlayerTimingId' => $id,
                'StartPositionX' => random_int(0, 255),
                'StartPositionY' => random_int(0, 255),
                'StartPositionZ' => random_int(0, 255),
                'EndPositionX' => random_int(0, 255),
                'EndPositionY' => random_int(0, 255),
                'EndPositionZ' => random_int(0, 255),
                'StartAngleX' => random_int(0, 255),
                'StartAngleY' => random_int(0, 255),
                'StartAngleZ' => random_int(0, 255),
                'EndAngleX' => random_int(0, 255),
                'EndAngleY' => random_int(0, 255),
                'EndAngleZ' => random_int(0, 255),
                'StartVelocityX' => random_int(0, 255),
                'StartVelocityY' => random_int(0, 255),
                'StartVelocityZ' => random_int(0, 255),
                'EndVelocityX' => random_int(0, 255),
                'EndVelocityY' => random_int(0, 255),
                'EndVelocityZ' => random_int(0, 255),
            ]);

            if ($main % 2 == 0) {
                // Stage times
                for ($stage=0; $stage < 100; $stage++) {
                    $id = DB::table('PlayerTimingStages')->insertGetId([
                        'MapId' => $map,
                        'PlayerId' => $main,
                        'StyleId' => $style,
                        'Level' => $level,
                        'Stage' => $stage,
                        'Tickrate' => 100,
                        'Time' => random_int(10, 200) / M_PI,
                        'TimeInZone' => random_int(5, 10) / M_PI,
                        'Attempts' => random_int(1, 20),
                        'Status' => 0
                    ]);

                    DB::table('PlayerTimingStageInsight')->insert([
                        'PlayerTimingStageId' => $id,
                        'StartPositionX' => random_int(0, 255),
                        'StartPositionY' => random_int(0, 255),
                        'StartPositionZ' => random_int(0, 255),
                        'EndPositionX' => random_int(0, 255),
                        'EndPositionY' => random_int(0, 255),
                        'EndPositionZ' => random_int(0, 255),
                        'StartAngleX' => random_int(0, 255),
                        'StartAngleY' => random_int(0, 255),
                        'StartAngleZ' => random_int(0, 255),
                        'EndAngleX' => random_int(0, 255),
                        'EndAngleY' => random_int(0, 255),
                        'EndAngleZ' => random_int(0, 255),
                        'StartVelocityX' => random_int(0, 255),
                        'StartVelocityY' => random_int(0, 255),
                        'StartVelocityZ' => random_int(0, 255),
                        'EndVelocityX' => random_int(0, 255),
                        'EndVelocityY' => random_int(0, 255),
                        'EndVelocityZ' => random_int(0, 255),
                    ]);
                }
            }
            else {
                // Checkpoint times
                for ($checkpoint=0; $checkpoint < 100; $checkpoint++) {
                    $id = DB::table('PlayerTimingCheckpoints')->insertGetId([
                        'MapId' => $map,
                        'PlayerId' => $main,
                        'StyleId' => $style,
                        'Level' => $level,
                        'Checkpoint' => $checkpoint,
                        'Tickrate' => 100,
                        'Time' => random_int(10, 200) / M_PI,
                        'Status' => 0
                    ]);

                    DB::table('PlayerTimingCheckpointInsight')->insert([
                        'PlayerTimingCheckpointId' => $id,
                        'PositionX' => random_int(0, 255),
                        'PositionY' => random_int(0, 255),
                        'PositionZ' => random_int(0, 255),
                        'AngleX' => random_int(0, 255),
                        'AngleY' => random_int(0, 255),
                        'AngleZ' => random_int(0, 255),
                        'VelocityX' => random_int(0, 255),
                        'VelocityY' => random_int(0, 255),
                        'VelocityZ' => random_int(0, 255),
                    ]);
                }
            }
        }
    }
}
