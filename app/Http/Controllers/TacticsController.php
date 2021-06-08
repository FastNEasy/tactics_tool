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
        $tacticTableN = "_tactic_table";
        $secondSideAnim = "animation_";
        $params = (Object)$request->all();
        $query = new tacticsModel();
        $userId = $params->loginId;
        $query->id_presets = $params->presetChoice;
        $query->tactic_name = $params->nameTactic;
        $query->id_tactic_table = "a";
        $query->id_user = $userId['id'];
        $query->save();
        $tableNameTactic = "$query->id"."$tacticTableN";
        $animTableName = "$secondSideAnim"."$query->id";
        $query->id_tactic_table = $tableNameTactic;
        $query->save();
        if (!Schema::hasTable($animTableName)) {
            Schema::create($animTableName, function (Blueprint $table) {
                $table->id();
                $table->bigInteger("time");
                $table->text("comment");
                $table->timestamps();
                //papildus lauks- id no id_tactic_table, lai katrai animacijai butu savs table(piesaistiitu animaciju tabulai)
            });
        }
        if (!Schema::hasTable($tableNameTactic)) {
            Schema::create($tableNameTactic, function($table) use($animTableName){
                $table->increments('id');
                $table->integer("id_player");
                $table->foreignID("id_anim")->constrained($animTableName)->onUpdate('cascade')->onDelete('cascade');//nonemt sho
                $table->float("player_pos_x");
                $table->float("player_pos_y");
                $table->timestamps();
            });
        }
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
                $query = tacticsModel::with("sportsType")->select('id','tactic_name')->get();
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
        tacticsModel::where('id', $params->id)->update(['tactic_name' => $params->tacticName]);
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