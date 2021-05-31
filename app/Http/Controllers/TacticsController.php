<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TacticsModel;
class TacticsController extends Controller
{
     public function saveTactic(Request $request){
        $tacticTableN = "_tactic_table";
        $params = (Object)$request->all();
        $query = new tacticsModel();
        $userID = $params->loginID;
        $query->id_presets = $params->presetChoice;
        $query->tactic_name = $params->nameTactic;
        $query->id_tactic_table ="";
        $query->id_user = $userID['id'];//$params->Auth::user()->id\
        $query->save();
        $query->id_tactic_table = "$query->id"."$tacticTableN";
        $query->save();
        return response()->json([
            "Data" => $params,
            "SavedValue" => $query,
            "Status" => "okay",
        ]);
    }
}