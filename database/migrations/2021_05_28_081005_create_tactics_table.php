<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('table_preset', function (Blueprint $table) {
                $table->id();
                $table->string("sports_name");
                $table->text("field_picture");
                $table->timestamps();
            });
            Schema::create('table_tactics', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger("id_presets");
                $table->string("tactic_name");
                $table->string("id_tactic_table");
                $table->unsignedInteger("id_user");
                $table->timestamps();
            });
        } catch (\Throwable $th) {
            Schema::dropIfExists('table_preset');
            Schema::dropIfExists('table_tactics');
            throw $th;
        }
        //theses tables go into the request
        // Schema::create('id_table_tactic', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer("id_player");
        //     $table->unsignedInteger("id_anim");
        //     $table->float("player_pos_x");
        //     $table->float("player_pos_y");
        //     $table->timestamps();
        // });
        // Schema::create('table_animation', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger("time");
        //     $table->text("comment");
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_preset');
        Schema::dropIfExists('table_tactics');
    }
}
