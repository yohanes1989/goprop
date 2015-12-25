<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewing_schedules', function(Blueprint $table){
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('property_id')->unsigned()->nullable();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->timestamp('viewing_from')->nullable();
            $table->timestamp('viewing_until')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viewing_schedules', function(Blueprint $table){
            $table->dropForeign('viewing_schedules_user_id_foreign');
            $table->dropForeign('viewing_schedules_property_id_foreign');
            $table->dropForeign('viewing_schedules_agent_id_foreign');
        });

        Schema::drop('viewing_schedules');
    }
}
