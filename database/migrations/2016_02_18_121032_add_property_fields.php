<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->integer('maid_rooms')->nullable()->after('bathrooms');
            $table->integer('maid_bathrooms')->nullable()->after('maid_rooms');
            $table->string('land_dimension')->nullable()->after('land_size');
            $table->string('building_dimension')->nullable()->after('building_size');
            $table->integer('carport_size')->nullable()->after('garage_size');
            $table->integer('phone_lines')->nullable()->after('floors');
            $table->integer('electricity')->nullable()->after('phone_lines');
            $table->string('orientation')->nullable()->after('floors');
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
            $table->dropColumn('maid_rooms');
            $table->dropColumn('maid_bathrooms');
            $table->dropColumn('land_dimension');
            $table->dropColumn('building_dimension');
            $table->dropColumn('carport_size');
            $table->dropColumn('phone_lines');
            $table->dropColumn('electricity');
            $table->dropColumn('orientation');
        });
    }
}
