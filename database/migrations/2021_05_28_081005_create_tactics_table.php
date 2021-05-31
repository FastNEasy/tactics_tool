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
                $table->foreignID('id_presets')->constrained('table_preset')->onDelete('cascade')->onUpdate('cascade');
                $table->string("tactic_name");
                $table->string("id_tactic_table");
                $table->foreignID('id_user')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamps();
            });
        } catch (\Throwable $th) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schema::dropIfExists('table_preset');
            Schema::dropIfExists('table_tactics');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw $th;
        }
        //theses tables go into the request
        // Schema::create('id_table_tactic', function (Blueprint $table) {
        //     $table->id();
            // $table->integer("id_player");
            // $table->foreignID("id_anim")->onUpdate('cascade')->onDelete('cascade')->constrained('animation');
            // $table->float("player_pos_x");
            // $table->float("player_pos_y");
            // $table->timestamps();
        // });
        // Schema::create('nimation', function (Blueprint $table) {
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('table_preset');
        Schema::dropIfExists('table_tactics');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
