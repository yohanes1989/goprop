<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignPropertyAnAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->integer('agent_id')->unsigned()->nullable();

            $table->foreign('agent_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->dropForeign('properties_agent_id_foreign');

            $table->dropColumn('agent_id');
        });
    }
}
