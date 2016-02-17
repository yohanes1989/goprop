<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_banners', function(Blueprint $table){
            $table->increments('id');
            $table->string('url');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('main_banner_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('main_banner_id')->unsigned();
            $table->string('title');
            $table->string('image');
            $table->string('locale')->index();

            $table->unique(['main_banner_id', 'locale']);
            $table->foreign('main_banner_id')->references('id')->on('main_banners')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('main_banner_translations');
        Schema::drop('main_banners');
    }
}
