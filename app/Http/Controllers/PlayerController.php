<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function Index(Request $request)
    {
        $players = DB::table('Player')->select('*')->get();

        if (empty($players))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($players as $player) {
            $player->IsActive = boolval($player->IsActive);
        }

        return response()->json($players, 200);
    }

    public function GetPlayer(Request $request, $PlayerId)
    {
        $player = DB::table('Player')->select('*')->where('Id', $PlayerId)->first();

        if (empty($player))
        {
            return response()->json('Not Found', 404);
        }

        $player->IsActive = boolval($player->IsActive);

        return response()->json($player, 200);
    }

    public function InsertPlayer(Request $request)
    {
        DB::table('Player')->insert(['Id' => $request->Id, 'Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json('Created', 201);
    }

    public function UpdatePlayer(Request $request, $PlayerId)
    {
        DB::table('Player')->where('Id', $PlayerId)->update(['Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json('OK', 200);
    }

    public function DeletePlayer(Request $request, $PlayerId)
    {
        DB::table('Player')->where('Id', $PlayerId)->delete();

        return response()->json('OK', 200);
    }
}
