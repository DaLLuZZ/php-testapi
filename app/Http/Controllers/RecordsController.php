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
                        ->get();

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord)
        {
            $mainInsight = DB::table('PlayerTimingInsight')
                            ->select('*')
                            ->where('PlayerTimingId', $mainRecord->Id)
                            ->first();

            $mainRecord = (array)$mainRecord;
            $mainInsight = (array)$mainInsight;

            array_push($mainRecord, $mainInsight);

            $type = $mainRecord['MapId'] % 2 == 0 ? "Stage" : "Checkpoint";

                $stageRecords = DB::table('PlayerTiming' . $type . 's')
                                    ->select('*')
                                    ->where('MapId', $mainRecord['MapId'])
                                    ->where('PlayerId', $mainRecord['PlayerId'])
                                    ->where('StyleId', $mainRecord['StyleId'])
                                    ->where('Level', $mainRecord['Level'])
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

                array_push($mainRecord, $detailedStageRecords);

            array_push($detailedRecords, $mainRecord);
        }

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
