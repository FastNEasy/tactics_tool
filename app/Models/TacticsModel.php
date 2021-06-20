<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacticsModel extends Model
{
    use HasFactory;
    public $table = "table_tactics";
    public $timeStamps = true;
    protected $fillable = ["id_presets", "tactic_name","tactic_data","id_user"];
    public function sportsType(){//laravel ship
        return $this->belongsTo("App\Models\SportsType", 'id_presets', "id");
    }

}
