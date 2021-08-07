<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordsController extends Controller
{
    public function GetMapRecord(Request $request, $MapId)
    {
        /*

            Select fatest main/bonus run per map
            get the player id
            select the other runs like checkpoints/stages
        */
        $mainRecords = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->groupBy(['StyleId', 'Level'])
                        ->orderBy('Time', 'asc')
                        ->first();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        // foreach ($mainRecords as $mainRecord)
        // {
        $mainInsight = DB::table('PlayerTimingInsight')
                        ->select('*')
                        ->where('PlayerTimingId', $mainRecords->Id) // TODO: mainRecord -> mainRecords
                        ->first();

        $mainRecords = (array)$mainRecords; // TODO: mainRecord -> mainRecords
        $mainInsight = (array)$mainInsight;

        array_push($mainRecords, $mainInsight); // TODO: mainRecord -> mainRecords

        $type = $mainRecords['MapId'] % 2 == 0 ? "Stage" : "Checkpoint";
        echo $type;

            $stageRecords = DB::table('PlayerTiming' . $type . 's')
                                ->select('*')
                                ->where('MapId', $mainRecords['MapId']) // TODO: mainRecord -> mainRecords
                                ->where('PlayerId', $mainRecords['PlayerId']) // TODO: mainRecord -> mainRecords
                                ->where('StyleId', $mainRecords['StyleId']) // TODO: mainRecord -> mainRecords
                                ->where('Level', $mainRecords['Level']) // TODO: mainRecord -> mainRecords
                                ->get();

            $this->checkExists($stageRecords);


            $detailedStageRecords = [];
            foreach ($stageRecords as $stageRecord)
            {
                $stageInsight = DB::table('PlayerTiming' . $type . 'Insight')
                                    ->select('*')
                                    ->where('PlayerTiming' . $type . 'Id', $stageRecord->Id)
                                    ->first();
                
                $stageRecord = (array)$stageRecord;
                $stageInsight = (array)$stageInsight;

                array_push($stageRecord, $stageInsight);
                array_push($detailedStageRecords, $stageRecord);
            }

            array_push($mainRecords, $detailedStageRecords);

        array_push($detailedRecords, $mainRecords); // TODO: mainRecord -> mainRecords
        //}

        return response()->json($detailedRecords);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId)
    {
        $records = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->groupBy(['StyleId', 'Level'])
                        ->orderBy('Time', 'asc')
                        ->get();

        $this->checkExists($records);

        $newRecords = [];

        foreach ($records as $record)
        {
            $insight = DB::table('PlayerTimingInsight')
                            ->select('*')
                            ->where('PlayerTimingId', $record->Id)
                            ->first();

            $record = (array)$record;
            $insight = (array)$insight;

            array_push($record, $insight);
            array_push($newRecords, $record);
        }

        return response()->json($newRecords);
    }
}
