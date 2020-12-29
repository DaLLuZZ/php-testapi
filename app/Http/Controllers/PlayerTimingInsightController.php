<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerTimingInsightController extends Controller
{
    public function GetInsight(Request $request, $TimingId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $insight = DB::table('PlayerTimingInsight')->select('*')->where('Id', $TimingId)->first();

        if (empty($insight))
        {
            return response()->json('Not Found', 404);
        }

        return response()->json($insight, 200);
    }

    public function InsertInsight(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $request['Id'] = DB::table('PlayerTimingInsight')->insertGetId([
                'PlayerInsightId' => $request->PlayerInsightId,
                'StartPositionX' => $request->StartPositionX,
                'StartPositionY' => $request->StartPositionY,
                'StartPositionZ' => $request->StartPositionZ,
                'EndPositionX' => $request->EndPositionX,
                'EndPositionY' => $request->EndPositionY,
                'EndPositionZ' => $request->EndPositionZ,
                'StartAngleX' => $request->StartAngleX,
                'StartAngleY' => $request->StartAngleY,
                'StartAngleZ' => $request->StartAngleZ,
                'EndAngleX' => $request->EndAngleX,
                'EndAngleY' => $request->EndAngleY,
                'EndAngleZ' => $request->EndAngleZ,
                'StartVelocityX' => $request->StartVelocityX,
                'StartVelocityY' => $request->StartVelocityY,
                'StartVelocityZ' => $request->StartVelocityZ,
                'EndVelocityX' => $request->EndVelocityX,
                'EndVelocityY' => $request->EndVelocityY,
                'EndVelocityZ' => $request->EndVelocityZ
            ]);

        return response()->json($request, 201);
    }

    public function DeleteInsightByInsightId(Request $request, $InsightId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTimingInsight')->where('Id', $InsightId)->delete();

        return response()->json('OK', 200);
    }

    public function DeleteInsightByTimingId(Request $request, $TimingId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('PlayerTimingInsight')->where('PlayerTimingId', $TimingId)->delete();

        return response()->json('OK', 200);
    }
}
