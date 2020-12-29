<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerTimingController extends Controller
{
    public function Index(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->get();

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByTimingId(Request $request, $TimingId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timing = DB::table('PlayerTiming')->select('*')->where('Id', $TimingId)->first();

        if (empty($timing))
        {
            return response()->json('Not Found', 404);
        }

        $timing->IsRanked = boolval($timing->IsRanked);

        return response()->json($timing, 200);
    }

    public function GetByMapId(Request $request, $MapId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->where('MapId', $MapId);

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByPlayerId(Request $request, $PlayerId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->where('PlayerId', $PlayerId);

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByStyleId(Request $request, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->where('StyleId', $StyleId);

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByMapPlayerId(Request $request, $MapId, $PlayerId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->where('MapId', $MapId)->where('PlayerId', $PlayerId);

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByMapStyleId(Request $request, $MapId, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->where('MapId', $MapId)->where('StyleId', $StyleId);

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByPlayerStyleId(Request $request, $PlayerId, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timings = DB::table('PlayerTiming')->select('*')->where('PlayerId', $PlayerId)->where('StyleId', $StyleId);

        if (empty($timings))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($timings as $timing) {
            $timing->IsRanked = boolval($timing->IsRanked);
        }

        return response()->json($timings, 200);
    }

    public function GetByAll(Request $request, $MapId, $PlayerId, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $timing = DB::table('PlayerTiming')->select('*')->where('MapId', $MapId)->where('PlayerId', $PlayerId)->where('StyleId', $StyleId)->first();

        if (empty($timing))
        {
            return response()->json('Not Found', 404);
        }

        $timing->IsRanked = boolval($timing->IsRanked);

        return response()->json($timing, 200);
    }

    public function InsertPlayer(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $request['Id'] = DB::table('PlayerTiming')->insertGetId([
                'PlayerId' => $request->PlayerId,
                'MapId' => $request->MapId,
                'StyleId' => $request->StyleId,
                'ZoneType' => $request->ZoneType,
                'ZoneOrdinal' => $request->ZoneOrdinal,
                'Duration' => $request->Duration,
                'IsRanked' => $request->IsRanked
            ]);

        return response()->json('Created', 201);
    }

    public function DeleteByTimingId(Request $request, $TimingId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('Id', $TimingId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByMapId(Request $request, $MapId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('MapId', $MapId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByPlayerId(Request $request, $PlayerId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('PlayerId', $PlayerId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByStyleId(Request $request, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('StyleId', $StyleId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByMapPlayerId(Request $request, $MapId, $PlayerId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('MapId', $MapId)->where('PlayerId', $PlayerId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByMapStyleId(Request $request, $MapId, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('MapId', $MapId)->where('StyleId', $StyleId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByPlayerStyleId(Request $request, $PlayerId, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('PlayerId', $PlayerId)->where('StyleId', $StyleId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteByAll(Request $request, $PlayerId, $MapId, $StyleId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTiming')->where('PlayerId', $PlayerId)->where('MapId', $MapId)->where('StyleId', $StyleId)->delete();

        return response()->json('OK', 200);
    }
}
