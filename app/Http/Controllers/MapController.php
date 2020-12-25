<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function Index(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $maps = DB::table('Map')->select('*')->get();

        if (empty($maps))
        {
            return response()->json('Not Found', 404);
        }

        return response()->json($maps);
    }

    public function GetMap(Request $request, $MapId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $map = DB::table('Map')->select('*')->where('Id', $MapId)->first();

        if (empty($map))
        {
            return response()->json('Not Found', 404);
        }

        return response()->json($map, 200);
    }

    public function InsertMap(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('Map')->insert(['Id' => $request->Id, 'Name' => $request->Name, 'Tier' => $request->Tier, 'IsActive' => $request->IsActive]);

        return response()->json('Created', 201);
    }

    public function UpdateMap(Request $request, $MapId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('Map')->where('Id', $MapId)->update(['Name' => $request->Name, 'Tier' => $request->Tier, 'IsActive' => $request->IsActive]);

        return response()->json('OK', 200);
    }

    public function DeleteMap(Request $request, $MapId)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        DB::table('Map')->where('Id', $MapId)->delete();

        return response()->json('OK', 200);
    }
}
