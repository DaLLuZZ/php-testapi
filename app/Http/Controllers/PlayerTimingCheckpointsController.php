<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerTimingCheckpointsController extends Controller
{
    public function Index(Request $request)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByTimingId(Request $request, $TimingId)
    {
        $timing = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('Id', $TimingId)
                        ->first();

        $this->checkExists($timing);

        $timing->Status = (bool)$timing->Status;

        return response()->json($timing);
    }

    public function GetByMapId(Request $request, $MapId)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByPlayerId(Request $request, $PlayerId)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('PlayerId', $PlayerId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByStyleId(Request $request, $StyleId)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('StyleId', $StyleId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByMapPlayerId(Request $request, $MapId, $PlayerId)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByMapStyleId(Request $request, $MapId, $StyleId)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('StyleId', $StyleId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByPlayerStyleId(Request $request, $PlayerId, $StyleId)
    {
        $timings = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('PlayerId', $PlayerId)
                        ->where('StyleId', $StyleId)
                        ->get();

        $this->checkExists($timings);

        foreach ($timings as $timing) {
            $timing->Status = (bool)$timing->Status;
        }

        return response()->json($timings);
    }

    public function GetByAll(Request $request, $MapId, $PlayerId, $StyleId)
    {
        $timing = DB::table('PlayerTimingCheckpoints')
                        ->select('*')
                        ->where('MapId', $MapId)
                        ->where('PlayerId', $PlayerId)
                        ->where('StyleId', $StyleId)
                        ->first();

        $this->checkExists($timing);

        $timing->Status = (bool)$timing->Status;

        return response()->json($timing);
    }

    public function InsertPlayer(Request $request)
    {
        try
        {
            $request['Id'] = DB::table('PlayerTimingCheckpoints')->insertGetId([
                'MapId' => $request->MapId,
                'PlayerId' => $request->PlayerId,
                'StyleId' => $request->StyleId,
                'Level' => $request->Level,
                'Tickrate' => $request->Tickrate,
                'Time' => $request->Time,
                'Status' => $request->Status
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
        DB::table('PlayerTimingCheckpoints')
            ->where('Id', $TimingId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByMapId(Request $request, $MapId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('MapId', $MapId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByPlayerId(Request $request, $PlayerId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('PlayerId', $PlayerId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByStyleId(Request $request, $StyleId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByMapPlayerId(Request $request, $MapId, $PlayerId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('MapId', $MapId)
            ->where('PlayerId', $PlayerId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByMapStyleId(Request $request, $MapId, $StyleId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('MapId', $MapId)
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByPlayerStyleId(Request $request, $PlayerId, $StyleId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('PlayerId', $PlayerId)
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteByAll(Request $request, $PlayerId, $MapId, $StyleId)
    {
        DB::table('PlayerTimingCheckpoints')
            ->where('PlayerId', $PlayerId)
            ->where('MapId', $MapId)
            ->where('StyleId', $StyleId)
            ->delete();

        return response()->json('OK');
    }
}