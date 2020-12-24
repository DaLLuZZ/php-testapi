<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function Index(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $players = DB::table('Player')->select('Id', 'Name', 'IsActive')->get();

        return response()->json($players);
    }

    public function GetPlayer(Request $request, $PlayerID)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $player = DB::table('Player')->select('Id', 'Name', 'IsActive')->where('Id', $PlayerID)->first();

        return response()->json($player);
    }

    public function InsertPlayer(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('Player')->insert(['Id' => $request->Id, 'Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json('OK', 200);
    }

    public function UpdatePlayer(Request $request, $PlayerId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('Player')->where('Id', $PlayerId)->update(['Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json('OK', 200);
    }

    public function DeletePlayer(Request $request, $PlayerId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('Player')->where('Id', $PlayerId)->delete();

        return response()->json('OK', 200);
    }
}
