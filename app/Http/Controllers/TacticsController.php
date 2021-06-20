<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TacticsModel;
use Illuminate\Support\Facades\Auth;
class TacticsController extends Controller
{
     public function saveTactic(Request $request){
        // $tacticTableN = "_tactic_table";
        // $secondSideAnim = "animation_";
        $params = (Object)$request->all();
        $query = new tacticsModel();
        $userId = $params->loginId;
        $query->id_presets = $params->presetChoice;
        $query->tactic_name = $params->nameTactic;
        $query->tactic_data = "";
        // $query->id_tactic_table = "a";
        $query->id_user = $userId['id'];
        $query->save();
        // $tableNameTactic = "$query->id"."$tacticTableN";
        // $animTableName = "$secondSideAnim"."$query->id";
        // $query->id_tactic_table = $tableNameTactic;
        $query->save();
        return response()->json([
            "data" => $params,
            "saved_value" => $query,
            "status" => "okay",
        ]);

        }
        public function getTacticName(Request $request){
            $params = (Object)$request->all(); 
            if(isset($params->id)){
                $query = tacticsModel::with("sportsType")->find($params->id);
            }
            else{
                $query = tacticsModel::with("sportsType")->where('id_user', $params->id_user)->select('id','tactic_name')->get();
            }
            return response()->json([
                "data" => $query,
            ]);
    }

    public function deleteTacticName(Request $request){
        $params = (Object)$request->all();
        $query = tacticsModel::find($params->id)->delete();
        // return response()->json([
        //     "a" => $params,
        // ]);
        // alert("Deleted preset: $deletedSport");
    }
    public function updateTactics(Request $request){
        $params = (Object)$request->all();
        //$theBaseImg = explode(',', $params->baseImg);
        tacticsModel::where('id', $params->id)->update(['tactic_data' => $params->tacticData]);
        return response()->json([
            "data" => $params,

        ]);
    }
}
// public function showSportsImage(Request $request){
//     $params = (Object)$request->all();
//     //$query = tacticsModel::find($params->id)->delete();
// }
//}