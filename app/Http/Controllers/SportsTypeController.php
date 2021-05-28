<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportsType;
class SportsTypeController extends Controller
{
    public function saveSportsType(Request $request){
        $params = (Object)$request->all();
        $query = new sportsType();
        $query->sports_name = $params->sportsTypeName;
        $query->field_picture = "ASF";
        $query->save();
        return response()->json([
            "Data" => $params,
            "SavedValue" => $query,
            "Status" => "okay", // php norada objektu of array
        ]);
    }
}
