<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RanksController extends Controller
{
    public function CalclatePlayerRanksByMapId(Request $request, $MapId) {
        DB::table('PlayerRanks')->truncate();

        $records = DB::table('PlayerTiming')
                    ->select(['PlayerId', 'StyleId', 'Level', 'Time'])
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

                DB::table('PlayerRanks')->insert([
                    'PlayerId' => $record->PlayerId,
                    'StyleId' => $record->StyleId,
                    'Level' => $record->Level,
                    'Rank' => $rank
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            response()->json('Conflict', 409)->send();
        }

        return response()->json('OK');
    }

    public function GetPlayerRanks(Request $request, $PlayerId) {
        $ranks = DB::table('PlayerRanks')
                    ->select(['StyleId', 'Level', 'Rank'])
                    ->where('PlayerId', $PlayerId)
                    ->get();

        $this->checkExists($ranks);
        
        return response()->json($ranks);
    }
}
