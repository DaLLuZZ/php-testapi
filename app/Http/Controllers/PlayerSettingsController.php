<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerSettingsController extends Controller
{
    public function GetValue(Request $request, $PlayerId, $SettingName)
    {
        $setting = DB::table('PlayerSettings')
                        ->select('*')
                        ->where('PlayerId', '=', $PlayerId)
                        ->where('Setting', '=', $SettingName)
                        ->first();

        $this->checkExists($setting);

        return response()->json($setting);
    }

    public function GetValueByPlayerId(Request $request, $PlayerId)
    {
        $settings = DB::table('PlayerSettings')
                        ->select('*')
                        ->where('PlayerId', '=', $PlayerId)
                        ->get();

        $this->checkExists($settings);

        return response()->json($settings);
    }

    public function GetValueBySettingName(Request $request, $SettingName)
    {
        $settings = DB::table('PlayerSettings')
                        ->select('*')
                        ->where('Setting', '=', $SettingName)
                        ->get();

        $this->checkExists($settings);

        return response()->json($settings);
    }

    public function InsertSetting(Request $request)
    {
        try
        {
            DB::table('PlayerSettings')->insertGetId([
                'PlayerId' => $request->PlayerId,
                'Setting' => $request->Setting,
                'Value' => $request->Value
            ]);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json("Duplicate entry", 409);
        }   

        return response()->json($request, 201);
    }

    public function UpdateSetting(Request $request, $PlayerId, $SettingName)
    {
        DB::table('PlayerSettings')
            ->where('PlayerID', '=', $PlayerId)
            ->where('Setting', '=', $SettingName)
            ->update(['Value' => $request->Value]);

        return response()->json('Success', 204);
    }

    public function DeleteSettingsByPlayerId(Request $request, $PlayerId)
    {
        DB::table('PlayerSettings')
            ->where('PlayerId', '=', $PlayerId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteSettingsBySettingName(Request $request, $SettingName)
    {
        DB::table('PlayerSettings')
            ->where('Setting', '=', $SettingName)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteSettingsByIdAndName(Request $request, $PlayerId, $SettingName)
    {
        DB::table('PlayerSettings')
            ->where('PlayerId', '=', $PlayerId)
            ->where('Setting', '=', $SettingName)
            ->delete();

        return response()->json('OK');
    }
}
