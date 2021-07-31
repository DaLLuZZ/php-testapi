<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function Index(Request $request)
    {
        $maps = DB::table('Map')
                    ->select('*')
                    ->get();

        $this->checkExists($maps);

        foreach ($maps as $map) {
            $map->Status = (bool)$map->Status;
        }

        return response()->json($maps);
    }

    public function GetMapById(Request $request, $MapId)
    {
        $map = DB::table('Map')
                    ->select('*')
                    ->where('Id', $MapId)
                    ->first();

        $this->checkExists($map);

        $map->Status = (bool)$map->Status;

        return response()->json($map);
    }

    public function GetMapByName(Request $request, $MapName)
    {
        $map = DB::table('Map')
                    ->select('*')
                    ->where('Name', $MapName)
                    ->first();

        $this->checkExists($map);

        $map->Status = (bool)$map->Status;

        return response()->json($map);
    }

    public function GetMapsByName(Request $request, $MapName)
    {
        $MapName = addslashes($MapName);

        $maps = DB::table('Map')
                    ->select('*')
                    ->where('Name', 'LIKE', '%' . $MapName . '%')
                    ->get();

        $this->checkExists($maps);

        foreach ($maps as $map) {
            $map->Status = (bool)$map->Status;
        }

        return response()->json($maps);
    }

    public function InsertMaps(Request $request)
    {
        $maps = $request->all();

        foreach ($maps as $map)
        {
            DB::table('Map')->insertOrIgnore([
                'Name' => $map['Name'],
                'Tier' => $map['Tier'],
                'Status' => $map['Status'],
                'MapAuthor' => $map['MapAuthor'],
                'ZoneAuthor' => $map['ZoneAuthor']
            ]);
        }

        return response()->json($maps, 201);
    }

    public function UpdateMap(Request $request, $MapId)
    {
        DB::table('Map')->where('Id', $MapId)->update([
            'Name' => $request->Name,
            'Tier' => $request->Tier,
            'Status' => $request->Status,
            'MapAuthor' => $request->MapAuthor,
            'ZoneAuthor' => $request->ZoneAuthor
        ]);

        return response()->json('OK');
    }

    public function UpdateMapAuthor(Request $request, $MapId)
    {
        DB::table('Map')->where('Id', $MapId)->update([
            'MapAuthor' => $request->MapAuthor,
            'ZoneAuthor' => $request->ZoneAuthor
        ]);

        return response()->json('OK');
    }

    public function DeleteMap(Request $request, $MapId)
    {
        DB::table('Map')->where('Id', $MapId)->delete();

        return response()->json('OK');
    }
}
