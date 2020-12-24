<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function Index()
    {
        $players = DB::table('Player')->select('Id', 'Name', 'IsActive')->get();

        foreach ($players as $player) {
            echo "Id: " . $player->Id . " - Name: " . $player->Name . " - Active: " . $player->IsActive . "<br/>";
        }
    }

    public function GetPlayer($playerid)
    {
        $player = DB::table('Player')->select('Id', 'Name', 'IsActive')->where('Id', $playerid)->first();

        echo "Id: " . $player->Id . " - Name: " . $player->Name . " - Active: " . $player->IsActive . "<br/>";
    }
}
