<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageSeoFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_translations', function(Blueprint $table){
            $table->string('meta_title');
            $table->text('meta_description');
        });

        Schema::table('post_translations', function(Blueprint $table){
            $table->string('meta_title');
            $table->text('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_translations', function(Blueprint $table){
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

        Schema::table('post_translations', function(Blueprint $table){
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
}
