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

        foreach ($styles as $style) {
            $style->IsActive = (bool)$style->IsActive;
        }

        return response()->json($styles);
    }

    public function GetStyle(Request $request, $StyleName)
    {
        $style = DB::table('Style')->select('*')->where('Name', $StyleName)->first();

        $this->checkExists($style);

        $style->IsActive = (bool)$style->IsActive;

        return response()->json($style);
    }

    public function InsertStyle(Request $request)
    {
        $request['Id'] = DB::table('Style')->insertGetId(['Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json($request, 201);
    }

    public function UpdateStyle(Request $request, $StyleId)
    {
        DB::table('Style')->where('Id', $StyleId)->update(['Name' => $request->Name, 'IsActive' => $request->IsActive]);

        return response()->json('OK');
    }

    public function DeleteStyle(Request $request, $StyleId)
    {
        DB::table('Style')->where('Id', $StyleId)->delete();

        return response()->json('OK');
    }
}
