<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerTimingInsightController extends Controller
{
    public function GetInsight(Request $request, $TimingId)
    {
        $insight = DB::table('PlayerTimingInsight')->select('*')->where('Id', $TimingId)->first();

        $this->checkExists($insight);

        return response()->json($insight);
    }

    public function InsertInsight(Request $request)
    {
        try
        {
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
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json("Duplicate entry", 409);
        }

        return response()->json($request, 201);
    }

    public function DeleteInsightByInsightId(Request $request, $InsightId)
    {
        DB::table('PlayerTimingInsight')->where('Id', $InsightId)->delete();

        return response()->json('OK');
    }

    public function DeleteInsightByTimingId(Request $request, $TimingId)
    {
        DB::table('PlayerTimingInsight')->where('PlayerTimingId', $TimingId)->delete();

        return response()->json('OK');
    }
}
