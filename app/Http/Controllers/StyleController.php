<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StyleController extends Controller
{
    public function Index(Request $request)
    {
        $styles = DB::table('Style')->select('*')->get();

        if (empty($styles))
        {
            return response()->json('Not Found', 404);
        }

        foreach ($styles as $style) {
            $style->IsActive = boolval($style->IsActive);
        }

        return response()->json($styles);
    }

    public function GetStyle(Request $request, $StyleName)
    {
        $style = DB::table('Style')->select('*')->where('Name', $StyleName)->first();

        if (empty($style))
        {
            return response()->json('Not Found', 404);
        }

        $style->IsActive = boolval($style->IsActive);

        return response()->json($style, 200);
    }

    public function InsertStyle(Request $request)
    {
        $request['Id'] = DB::table('Style')->insertGetId(['Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json($request, 201);
    }

    public function UpdateStyle(Request $request, $StyleId)
    {
        DB::table('Style')->where('Id', $StyleId)->update(['Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json('OK', 200);
    }

    public function DeleteStyle(Request $request, $StyleId)
    {
        DB::table('Style')->where('Id', $StyleId)->delete();

        return response()->json('OK', 200);
    }
}
