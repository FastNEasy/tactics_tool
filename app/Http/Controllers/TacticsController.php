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
            Schema::create($tableNameTactic, function($table){
                $table->increments('id');
                $table->integer("id_player");
                $table->foreignID("id_anim")->constrained('animation')->onUpdate('cascade')->onDelete('cascade');//nonemt sho
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

}