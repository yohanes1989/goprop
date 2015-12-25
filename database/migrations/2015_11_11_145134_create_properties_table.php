<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_types', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('sort_order')->default(0)->nullable();

            $table->foreign('parent_id')->references('id')->on('property_types')->onDelete('SET NULL');
        });

        Schema::create('properties', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('property_name', 255)->nullable();
            $table->text('description')->nullable();

            $table->text('address')->nullable();
            $table->integer('province')->nullable();
            $table->integer('city')->nullable();
            $table->integer('subdistrict')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('latitude', 100)->nullable();

            $table->integer('property_type_id')->nullable()->unsigned();
            $table->string('parking')->nullable();
            $table->integer('garage_size')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('furnishing')->nullable();

            $table->decimal('land_size', 10, 2)->nullable();
            $table->decimal('building_size', 10, 2)->nullable();
            $table->decimal('floors', 8, 1)->nullable();
            $table->string('certificate')->nullable();

            $table->text('virtual_tour_url')->nullable();

            $table->integer('for_sell')->default(0);
            $table->decimal('sell_price', 17,2)->nullable();
            $table->string('sell_viewing_schedule', 255)->nullable();

            $table->integer('for_rent')->default(0);
            $table->decimal('rent_price', 17,2)->nullable();
            $table->string('rent_price_type', 10)->nullable();
            $table->string('rent_viewing_schedule', 255)->nullable();

            $table->string('status', 12)->default(\GoProp\Models\Property::STATUS_DRAFT);
            $table->integer('state')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });

        Schema::create('property_attachments', function(Blueprint $table){
            $table->increments('id');
            $table->string('title', 255);
            $table->string('filename', 255);
            $table->string('type');
            $table->integer('sort_order');
            $table->integer('property_id')->nullable()->unsigned();
            $table->timestamps();

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
        Schema::table('property_attachments', function(Blueprint $table){
            $table->dropForeign('property_attachments_property_id_foreign');
        });

        Schema::table('properties', function(Blueprint $table){
            $table->dropForeign('properties_property_type_id_foreign');
            $table->dropForeign('properties_user_id_foreign');
        });

        Schema::table('property_types', function(Blueprint $table){
            $table->dropForeign('property_types_parent_id_foreign');
        });

        Schema::drop('property_attachments');
        Schema::drop('property_types');
        Schema::drop('properties');
    }
}
