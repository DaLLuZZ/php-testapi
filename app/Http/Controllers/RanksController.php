<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RanksController extends Controller
{
    public function CalclatePlayerRanksByMapId(Request $request, $MapId) {
        $records = DB::table('PlayerTiming')
                    ->select(['Id', 'PlayerId', 'StyleId', 'Level', 'Time'])
                    ->orderBy('StyleId')
                    ->orderBy('Level')
                    ->orderBy('Time')
                    ->where('MapId', $MapId)
                    ->get();

        $this->checkExists($records);

        $styleid = 0;
        $level = 0;
        $rank = 0;

        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                if ($styleid == 0 && $level == 0) {
                    $rank = 1;

                    $styleid = $record->StyleId;
                    $level = $record->Level;
                }
                else if ($record->StyleId == $styleid && $record->Level == $level) {
                    $rank++;
                }
                else if ($record->StyleId != $styleid || $record->Level != $level) {
                    $rank = 1;

                    $styleid = $record->StyleId;
                    $level = $record->Level;
                }

                DB::table('PlayerTiming')
                    ->where('Id', '=', $record->Id)
                    ->update(['Rank' => $rank]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            response()->json('Conflict', 409)->send();
        }

        return response()->json('OK');
    }
}
