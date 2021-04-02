<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerHudSettingsController extends Controller
{
    public function GetHudSettings(Request $request, $PlayerId)
    {
        $hud = DB::table('PlayerHudSettings')
                ->select('*')
                ->where('PlayerId', $PlayerId)
                ->get();

        $this->checkExists($hud);

        return response()->json($hud);
    }

    public function InsertHudSetting(Request $request)
    {
        DB::table('PlayerHudSettings')->insertGetId([
            'PlayerId' => $request->PlayerId,
            'Side' => $request->Side,
            'Line' => $request->Line,
            'Key' => $request->Key
        ]);

        return response()->json($request, 201);
    }

    public function InsertHudPreset(Request $request)
    {
        DB::table('PlayerHudSettings')->where('PlayerId', $request->PlayerId)->delete();

        DB::table('PlayerHudSettings')->insertGetId([
            'PlayerId' => $request->PlayerId,
            'Side' => $request->Side,
            'Line' => $request->Line,
            'Key' => $request->Key
        ]);

        return response()->json($request, 201);
    }

    public function UpdateHudSetting(Request $request, $PlayerId, $Side, $Line)
    {
        DB::table('PlayerHudSettings')
            ->where('PlayerID', $PlayerId)
            ->where('Side', $Side)
            ->where('Line', $Line)
            ->update(['Key' => $request->Key]);

        return response()->json('Success', 204);
    }

    public function DeleteHudSettingsByPlayerId(Request $request, $PlayerId)
    {
        DB::table('PlayerHudSettings')->where('PlayerId', $PlayerId)->delete();

        return response()->json('OK');
    }
}
