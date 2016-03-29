<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePropertiesAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->dropForeign('properties_agent_id_foreign');

            $table->renameColumn('agent_id', 'agent_list_id');
            $table->foreign('agent_list_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->integer('referral_list_id')->unsigned()->nullable();
            $table->foreign('referral_list_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->integer('agent_sell_id')->unsigned()->nullable();
            $table->foreign('agent_sell_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->integer('referral_sell_id')->unsigned()->nullable();
            $table->foreign('referral_sell_id')->references('id')->on('users')->onDelete('SET NULL');
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
            $table->renameColumn('agent_list_id', 'agent_id');

            $table->foreign('agent_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->dropForeign('properties_referral_list_id_foreign');
            $table->dropColumn('referral_list_id');

            $table->dropForeign('properties_agent_sell_id_foreign');
            $table->dropColumn('agent_sell_id');

            $table->dropForeign('properties_referral_sell_id_foreign');
            $table->dropColumn('referral_sell_id');
        });
    }
}
