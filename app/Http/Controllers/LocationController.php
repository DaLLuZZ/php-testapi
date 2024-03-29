<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function GetSharedRecords(Request $request, $MapId)
    {
        $locations = DB::table('PlayerLocations')
                        ->join('Player', 'Player.Id', '=', 'PlayerLocations.PlayerId')
                        ->join('PlayerLocationInsight', 'PlayerLocations.Id', '=', 'PlayerLocationInsight.PlayerLocationId')
                        ->select('PlayerLocations.Id', 'PlayerLocations.MapId', 'PlayerLocations.PlayerId', 'Player.Name', 'PlayerLocations.StyleId', 'PlayerLocations.Level', 'PlayerLocations.Type',
                                'PlayerLocations.Tickrate', 'PlayerLocations.Time', 'PlayerLocations.Sync', 'PlayerLocations.Speed', 'PlayerLocations.Jumps', 'PlayerLocations.CSLevel', 'PlayerLocations.CSTime', 'PlayerLocations.Status',
                                'PlayerLocationInsight.PositionX', 'PlayerLocationInsight.PositionY', 'PlayerLocationInsight.PositionZ',
                                'PlayerLocationInsight.AngleX', 'PlayerLocationInsight.AngleY', 'PlayerLocationInsight.AngleZ',
                                'PlayerLocationInsight.VelocityX', 'PlayerLocationInsight.VelocityY', 'PlayerLocationInsight.VelocityZ')
                        ->where('PlayerLocations.MapId', '=', $MapId)
                        ->where('PlayerLocations.Status', '=', '2')
                        ->orderBy('PlayerLocations.Level', 'asc')
                        ->orderBy('PlayerLocations.CSLevel', 'asc')
                        ->get();

        $this->checkExists($locations);

        return response()->json($locations);
    }

    public function GetPlayerLocations(Request $request, $MapId, $PlayerId)
    {
        $locations = DB::table('PlayerLocations')
                        ->join('PlayerLocationInsight', 'PlayerLocations.Id', '=', 'PlayerLocationInsight.PlayerLocationId')
                        ->select('PlayerLocations.Id', 'PlayerLocations.MapId', 'PlayerLocations.PlayerId', 'PlayerLocations.StyleId', 'PlayerLocations.Level', 'PlayerLocations.Type',
                                'PlayerLocations.Tickrate', 'PlayerLocations.Time', 'PlayerLocations.Sync', 'PlayerLocations.Speed', 'PlayerLocations.Jumps', 'PlayerLocations.CSLevel', 'PlayerLocations.CSTime', 'PlayerLocations.Status',
                                'PlayerLocationInsight.PositionX', 'PlayerLocationInsight.PositionY', 'PlayerLocationInsight.PositionZ',
                                'PlayerLocationInsight.AngleX', 'PlayerLocationInsight.AngleY', 'PlayerLocationInsight.AngleZ',
                                'PlayerLocationInsight.VelocityX', 'PlayerLocationInsight.VelocityY', 'PlayerLocationInsight.VelocityZ')
                        ->where('PlayerLocations.MapId', '=', $MapId)
                        ->where('PlayerLocations.PlayerId', '=', $PlayerId)
                        ->where('PlayerLocations.Status', '>', '0')
                        ->orderBy('PlayerLocations.Level', 'asc')
                        ->orderBy('PlayerLocations.CSLevel', 'asc')
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
                'CSTime' => $request->CSTime,
                'Status' => $request->Status
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

        $request->request->set('Id', $PlayerLocationId);

        return response()->json($request, 201);
    }

    public function UpdateLocation(Request $request, $LocationId)
    {
        DB::table('PlayerLocations')->where('Id', '=', $LocationId)->update([
            'Status' => $request->Status
        ]);

        return response()->json('OK');
    }

    public function DeleteLocation(Request $request, $LocationId)
    {
        DB::table('PlayerLocations')->where('Id', '=', $LocationId)->delete();

        return response()->json('OK');
    }
}
