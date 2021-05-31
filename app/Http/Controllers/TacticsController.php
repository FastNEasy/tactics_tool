<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TacticsModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $tactTableName = "$query->id"."$tacticTableN";
        $query->id_tactic_table = $tactTableName;
        $query->save();
        if (!Schema::hasTable($tactTableName)) {
            Schema::create($tactTableName, function($table){
                $table->increments('id');
                $table->integer('playerID');
                $table->integer('animID');
                $table->float('playerPosX');
                $table->float('playerPosY');
        });
    }
//         if (!Schema::hasTable('Animation')) {
//             Schema::create('Animation', function($table){
//                 $table->increments('id');
//                 $table-> integer('time');
//                 $table->text('comment');
//     });
// }

        $query->save();    
        return response()->json([
            "Data" => $params,
            "SavedValue" => $query,
            "Status" => "okay", // php norada objektu of array
        ]);
    
}
}