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
        $records = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('ZoneType', 'Main')
                        ->where('StyleId', '0')
                        ->groupBy('ZoneNormal')
                        ->orderBy('Time', 'asc')
                        ->get();

        $this->checkExists($records);

        foreach ($records as $record) {
            $record->Status = (bool)$record->Status;
        }

        return response()->json($records);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId)
    {
        $records = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->where('ZoneNormal', 0)
                        ->where('ZoneType', 'Main')
                        ->where('ZoneOrdinal', 0)
                        ->orderBy('Time', 'asc')
                        ->get();

        $this->checkExists($records);

        foreach ($records as $record) {
            $record->Status = (bool)$record->Status;
        }

        return response()->json($records);
    }
}
