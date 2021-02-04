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

        foreach ($maps as $map) {
            $map->IsActive = boolval($map->IsActive);
        }

        return response()->json($maps, 200);
    }

    public function GetMapById(Request $request, $MapId)
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

        $map->IsActive = boolval($map->IsActive);

        return response()->json($map, 200);
    }

    public function GetMapByName(Request $request, $MapName)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $map = DB::table('Map')->select('*')->where('Name', $MapName)->first();

        if (empty($map))
        {
            return response()->json('Not Found', 404);
        }

        $map->IsActive = boolval($map->IsActive);

        return response()->json($map, 200);
    }

    public function InsertMap(Request $request)
    {
        if ($request->API_KEY != env('API_KEY'))
        {
            return response()->json('Unauthorized', 401);
        }

        $request['Id'] = DB::table('Map')->insertGetId(['Name' => $request->Name, 'Tier' => $request->Tier, 'IsActive' => $request->IsActive]);

        return response()->json($request, 201);
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
