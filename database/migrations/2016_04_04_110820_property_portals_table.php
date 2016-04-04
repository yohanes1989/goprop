<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PropertyPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_portals', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->integer('sort_order')->default(0);
        });

        Schema::create('property_property_portal', function(Blueprint $table){
            $table->integer('property_id')->unsigned();
            $table->integer('property_portal_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('CASCADE');
            $table->foreign('property_portal_id')->references('id')->on('property_portals')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });

        \GoProp\Models\PropertyPortal::create([
            'name' => 'Rumah 123',
        ]);

        \GoProp\Models\PropertyPortal::create([
            'name' => 'Rumah.com',
        ]);

        \GoProp\Models\PropertyPortal::create([
            'name' => 'Rumah Dijual',
        ]);

        \GoProp\Models\PropertyPortal::create([
            'name' => 'Lamudi',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('property_property_portal');
        Schema::drop('property_portals');
    }
}
