<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function Index(Request $request)
    {
        $maps = DB::table('Map')->select('*')->get();

        $this->checkExists($maps);

        foreach ($maps as $map) {
            $map->IsActive = (bool)$map->IsActive;
        }

        return response()->json($maps);
    }

    public function GetMapById(Request $request, $MapId)
    {
        $map = DB::table('Map')->select('*')->where('Id', $MapId)->first();

        $this->checkExists($map);

        $map->IsActive = (bool)$map->IsActive;

        return response()->json($map);
    }

    public function GetMapByName(Request $request, $MapName)
    {
        $map = DB::table('Map')->select('*')->where('Name', $MapName)->first();

        $this->checkExists($map);

        $map->IsActive = (bool)$map->IsActive;

        return response()->json($map);
    }

    public function InsertMap(Request $request)
    {
        $request['Id'] = DB::table('Map')->insertGetId([
            'Name' => $request->Name,
            'Tier' => $request->Tier,
            'IsActive' => $request->IsActive
        ]);

        return response()->json($request, 201);
    }

    public function UpdateMap(Request $request, $MapId)
    {
        DB::table('Map')->where('Id', $MapId)->update([
            'Name' => $request->Name,
            'Tier' => $request->Tier,
            'IsActive' => $request->IsActive
        ]);

        return response()->json('OK');
    }

    public function DeleteMap(Request $request, $MapId)
    {
        DB::table('Map')->where('Id', $MapId)->delete();

        return response()->json('OK');
    }
}
