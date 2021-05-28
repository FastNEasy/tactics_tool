<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsType extends Model
{
    use HasFactory;
    public $table = "table_preset";
    public $timeStamps = true;
    protected $fillable = ["sports_name", "field_picture"];
}
