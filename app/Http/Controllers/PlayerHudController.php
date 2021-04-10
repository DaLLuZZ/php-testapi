<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerHudController extends Controller
{
    public function GetHud(Request $request, $PlayerId)
    {
        $hud = DB::table('PlayerHud')
                ->select('*')
                ->where('PlayerId', $PlayerId)
                ->get();

        $this->checkExists($hud);

        return response()->json($hud);
    }

    public function InsertHud(Request $request, $PlayerId)
    {
        DB::table('PlayerHud')
            ->where('PlayerId', $PlayerId)
            ->delete();

        $settings = $request->all();

        foreach ($settings as $setting)
        {
            DB::table('PlayerHud')->insert([
                'PlayerId' => $setting['PlayerId'],
                'Side' => $setting['Side'],
                'Line' => $setting['Line'],
                'Key' => $setting['Key']
            ]);
        }

        return response()->json($settings, 201);
    }

    public function UpdateHud(Request $request, $PlayerId, $Side, $Line)
    {
        DB::table('PlayerHud')
            ->where('PlayerID', $PlayerId)
            ->where('Side', $Side)
            ->where('Line', $Line)
            ->update(['Key' => $request->Key]);

        return response()->json('Success', 204);
    }

    public function DeleteHudByPlayerId(Request $request, $PlayerId)
    {
        DB::table('PlayerHud')
            ->where('PlayerId', $PlayerId)
            ->delete();

        return response()->json('OK');
    }
}
