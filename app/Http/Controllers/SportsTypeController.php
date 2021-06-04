<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Models\SportsType;
class SportsTypeController extends Controller
{
    public function saveSportsType(Request $request){
        $params = (Object)$request->all();
        $query = new SportsType();
        $query->sports_name = $params->sportsTypeName;
       //$theBaseImg = explode(',', $params->baseImg);
        $query->field_picture = $params->baseImg;
        $query->save();
        return response()->json([
            "data" => $params,
            "saved_value" => $query,
            "status" => "okay", // php norada objektu of array
        ]);
    }
    public function getSportsTypes(Request $request){
        $params = (Object)$request->all(); 
        if(isset($params->id)){
            $query = SportsType::find($params->id);  
        }else{
            $query = SportsType::select('id','sports_name')->get();    
        }
        return response()->json([
            "data" => $query,
        ]);
    }
    public function deleteSportsTypes(Request $request){
        $params = (Object)$request->all();
        $query = SportsType::find($params->id)->delete();
        // return response()->json([
        //     "a" => $params,
        // ]);
        // alert("Deleted preset: $deletedSport");
    }
    // public function getSportsInfo(Request $request){
    //     $params = (Object)$request->all();
    //     if(isset($params->id)){
    //         $query = SportsType::find($params->id);   
    //     }else{
    //         //$query = SportsType::find($params->id);
    //         $query = SportsType::select('id','sports_name')->get();   
    //     }
    //     return response()->json([
    //         "data" => $query,
    //        //"params"=>$params,     
    //     ]);
    //}
    public function updateSportsType(Request $request){
        $params = (Object)$request->all();
        // $theBaseImg = explode(',', $params->baseImg);
        SportsType::where('id', $params->id)->update(['sports_name' => $params->sportsTypeName, 'field_picture' => $params->baseImg]);
        return response()->json([
            "data" => $params,

        ]);
    }
}
