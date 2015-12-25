<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterestedFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liked_properties', function(Blueprint $table){
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('property_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::table('liked_properties', function(Blueprint $table){
            $table->dropForeign('liked_properties_user_id_foreign');
            $table->dropForeign('liked_properties_property_id_foreign');
        });

        Schema::drop('liked_properties');
    }
}
