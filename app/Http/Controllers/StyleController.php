<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StyleController extends Controller
{
    public function Index(Request $request)
    {
        $styles = DB::table('Style')->select('*')->get();

        $this->checkExists($styles);

        return response()->json($styles);
    }

    public function GetStyleById(Request $request, $StyleId)
    {
        $style = DB::table('Style')->select('*')->where('Id', '=', $StyleId)->first();

        $this->checkExists($style);

        return response()->json($style);
    }

    public function GetStyleByName(Request $request, $StyleName)
    {
        $style = DB::table('Style')->select('*')->where('Name', '=', $StyleName)->first();

        $this->checkExists($style);

        return response()->json($style);
    }

    public function InsertStyle(Request $request)
    {
        try
        {
            $request['Id'] = DB::table('Style')->insertGetId([
                'Name' => $request->Name,
                'Status' => $request->Status
            ]);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json("Duplicate entry", 409);
        }

        return response()->json($request, 201);
    }

    public function UpdateStyle(Request $request, $StyleId)
    {
        DB::table('Style')->where('Id', '=', $StyleId)->update([
            'Name' => $request->Name,
            'Status' => $request->Status
        ]);

        return response()->json('OK');
    }

    public function DeleteStyle(Request $request, $StyleId)
    {
        DB::table('Style')->where('Id', '=', $StyleId)->delete();

        return response()->json('OK');
    }
}
