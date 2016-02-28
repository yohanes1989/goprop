<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubdistrictSortOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rajaongkir_indonesia_subdistricts', function(Blueprint $table){
            $table->increments('subdistrict_id')->change();
            $table->integer('sort_order')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rajaongkir_indonesia_subdistricts', function(Blueprint $table){
            $table->dropColumn('sort_order');
        });
    }
}
