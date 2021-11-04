<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function GetPlayerLocations(Request $request, $MapId, $PlayerId)
    {
        $locations = DB::table('PlayerLocations')
                    ->select('*')
                    ->where('MapId', $MapId)
                    ->where('PlayerId', $PlayerId)
                    ->get();

        $this->checkExists($locations);

        return response()->json($locations);
    }

    public function InsertLocation(Request $request)
    {
        try {
            $PlayerLocationId = DB::table('PlayerLocations')->insertGetId([
                'MapId' => $request->MapId,
                'PlayerId' => $request->PlayerId,
                'StyleId' => $request->StyleId,
                'Level' => $request->Level,
                'Type' => $request->Type,
                'Tickrate' => $request->Tickrate,
                'Time' => $request->Time,
                'Sync' => $request->Sync,
                'Speed' => $request->Speed,
                'Jumps' => $request->Jumps,
                'CSLevel' => $request->CSLevel,
                'CSTime' => $request->CSTime
            ]);

            DB::table('PlayerLocationInsight')->insert([
                'PlayerLocationId' => $PlayerLocationId,
                'PositionX' => $request->PositionX,
                'PositionY' => $request->PositionY,
                'PositionZ' => $request->PositionZ,
                'AngleX' => $request->AngleX,
                'AngleY' => $request->AngleY,
                'AngleZ' => $request->AngleZ,
                'VelocityX' => $request->VelocityX,
                'VelocityY' => $request->VelocityY,
                'VelocityZ' => $request->VelocityZ,
            ]);
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json("Duplicate entry", 409);
        }

        return response()->json($request, 201);
    }

    public function DeleteLocation(Request $request, $LocationId)
    {
        DB::table('PlayerLocations')->where('Id', $LocationId)->delete();
        DB::table('PlayerLocationInsight')->where('PlayerLocationId', $LocationId)->delete();

        return response()->json('OK');
    }
}
