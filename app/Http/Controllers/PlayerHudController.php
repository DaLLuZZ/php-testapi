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
        try
        {
            DB::table('PlayerHud')
                ->where('PlayerId', $PlayerId)
                ->delete();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json("Duplicate entry", 409);
        }   

        $keys = $request->all();

        foreach ($keys as $key)
        {
            DB::table('PlayerHud')->insert([
                'PlayerId' => $key['PlayerId'],
                'Side' => $key['Side'],
                'Line' => $key['Line'],
                'Key' => $key['Key']
            ]);
        }

        return response()->json($keys, 201);
    }

    public function UpdateHud(Request $request, $PlayerId)
    {
        $keys = $request->all();

        foreach ($keys as $key)
        {
            DB::table('PlayerHud')
                ->where('PlayerID', $PlayerId)
                ->where('Side', $key['Side'])
                ->where('Line', $key['Line'])
                ->update(['Key' => $key['Key']]);
        }

        return response()->json('Success', 204);
    }

    public function DeleteHudByPlayerId(Request $request, $PlayerId)
    {
        DB::table('PlayerHud')
            ->where('PlayerId', $PlayerId)
            ->delete();

        return response()->json('OK');
    }

    public function DeleteHudByPlayerIdAndKey(Request $request, $PlayerId, $Key)
    {
        DB::table('PlayerHud')
            ->where('PlayerId', $PlayerId)
            ->where('Key', $Key)
            ->delete();

        return response()->json('OK');
    }
}
