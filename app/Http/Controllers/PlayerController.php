<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function Index()
    {
        $players = DB::table('Player')->select('Id', 'Name', 'IsActive')->get();

        return response()->json($players);
    }

    public function GetPlayer($playerid)
    {
        $player = DB::table('Player')->select('Id', 'Name', 'IsActive')->where('Id', $playerid)->first();

        return response()->json($player);
    }
}
