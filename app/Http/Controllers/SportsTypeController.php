<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportsType;
class SportsTypeController extends Controller
{
    public function saveSportsType(Request $request){
        $params = (Object)$request->all();
        $query = new SportsType();
        $query->sports_name = $params->sportsTypeName;
        $query->field_picture = $params->baseImg;
        $query->save();
        return response()->json([
            "data" => $params,
            "saved_value" => $query,
            "status" => "okay", // php norada objektu of array
        ]);
    }
    
    public function getSportsInfo(Request $request){
        $params = (Object)$request->all();
        $query = SportsType::find($params->id);
        return response()->json([
           "data" => $query,
           //"params"=>$params,     
        ]);
    }
    public function updateSportsType(Request $request){
        $params = (Object)$request->all();
        SportsType::where('id', $params->id)->update(['sports_name' => $params->sportsTypeName, 'field_picture' => $params->baseImg]);
        return response()->json([
            "data" => $params,

        ]);
    }
}
