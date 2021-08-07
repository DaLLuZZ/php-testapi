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
        $records = DB::table('PlayerTimingStages')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->groupBy(['StyleId', 'Level'])
                        ->orderBy('Time', 'asc')
                        ->get();

        $this->checkExists($records);

        return response()->json($records);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId)
    {
        $records = DB::table('PlayerTimingStages')
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
        $insight = DB::table('PlayerTimingStageInsight')
                        ->select('*')
                        ->where('PlayerTimingStageId', $record->Id)
                        ->first();

        $record = (array)$record;
        $insight = (array)$insight;

        array_push($record, $insight);
        array_push($newRecords, $record);
    }

        return response()->json($newRecords);
    }
}
