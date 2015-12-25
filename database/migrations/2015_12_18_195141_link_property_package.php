<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkPropertyPackage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_property', function(Blueprint $table){
            $table->integer('package_id')->nullable()->unsigned();
            $table->integer('property_id')->nullable()->unsigned();
            $table->text('addons')->nullable();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_property', function(Blueprint $table){
            $table->dropForeign('package_property_package_id_foreign');
            $table->dropForeign('package_property_property_id_foreign');
        });

        Schema::drop('package_property');
    }
}
