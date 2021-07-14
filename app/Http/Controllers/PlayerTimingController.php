<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerTimingController extends Controller
{
    public function Index(Request $request)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByTimingId(Request $request, $TimingId)
    {
        $timing = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('Id', $TimingId)
                        ->first();

        $this->checkExists($timing);

        $timing->IsRanked = (bool)$timing->IsRanked;

        return response()->json($timing);
    }

    public function GetByMapId(Request $request, $MapId)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByPlayerId(Request $request, $PlayerId)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('PlayerId', $PlayerId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByStyleId(Request $request, $StyleId)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('StyleId', $StyleId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByMapPlayerId(Request $request, $MapId, $PlayerId)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByMapStyleId(Request $request, $MapId, $StyleId)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('StyleId', $StyleId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByPlayerStyleId(Request $request, $PlayerId, $StyleId)
    {
        $timings = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('PlayerId', $PlayerId)
                        ->where('StyleId', $StyleId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->IsRanked = (bool)$timing->IsRanked;
        }

        return response()->json($timings);
    }

    public function GetByAll(Request $request, $MapId, $PlayerId, $StyleId)
    {
        $timing = DB::table('PlayerTiming')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->where('StyleId', $StyleId)
                        ->first();

        $this->checkExists($timing);

        $timing->IsRanked = (bool)$timing->IsRanked;

        return response()->json($timing);
    }

    public function InsertPlayer(Request $request)
    {
        try
        {
            $request['Id'] = DB::table('PlayerTiming')->insertGetId([
                'MapId' => $request->MapId,
                'PlayerId' => $request->PlayerId,
                'StyleId' => $request->StyleId,
                'ZoneNormal' => $request->ZoneNormal,
                'ZoneType' => $request->ZoneType,
                'ZoneOrdinal' => $request->ZoneOrdinal,
                'Tickrate' => $request->Tickrate,
                'Duration' => $request->Duration,
                'TimeInZone' => $request->TimeInZone,
                'Attempts' => $request->Attempts,
                'IsRanked' => $request->IsRanked
            ]);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json("Duplicate entry", 409);
        }   

        return response()->json($request, 201);
    }

    public function DeleteByTimingId(Request $request, $TimingId)
    {
        DB::table('PlayerTiming')
            ->where('Id', $TimingId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByMapId(Request $request, $MapId)
    {
        DB::table('PlayerTiming')
            ->where('MapId', $MapId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByPlayerId(Request $request, $PlayerId)
    {
        DB::table('PlayerTiming')
            ->where('PlayerId', $PlayerId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByStyleId(Request $request, $StyleId)
    {
        DB::table('PlayerTiming')
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByMapPlayerId(Request $request, $MapId, $PlayerId)
    {
        DB::table('PlayerTiming')
            ->where('MapId', $MapId)
            ->where('PlayerId', $PlayerId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByMapStyleId(Request $request, $MapId, $StyleId)
    {
        DB::table('PlayerTiming')
            ->where('MapId', $MapId)
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByPlayerStyleId(Request $request, $PlayerId, $StyleId)
    {
        DB::table('PlayerTiming')
            ->where('PlayerId', $PlayerId)
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByAll(Request $request, $PlayerId, $MapId, $StyleId)
    {
        DB::table('PlayerTiming')
            ->where('PlayerId', $PlayerId)
            ->where('MapId', $MapId)
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }
}
