<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('status')->default(\GoProp\Models\Post::STATUS_PUBLISHED);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });

        Schema::create('post_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('image');
            $table->string('locale')->index();

            $table->unique(['post_id', 'locale']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        });

        Schema::create('categories', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('category_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');
        });

        Schema::create('tags', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('tag_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['tag_id', 'locale']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('CASCADE');
        });

        Schema::create('post_tag', function(Blueprint $table){
            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('CASCADE');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        });

        Schema::create('category_post', function(Blueprint $table){
            $table->integer('post_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_post');
        Schema::drop('post_tag');
        Schema::drop('tag_translations');
        Schema::drop('tags');
        Schema::drop('category_translations');
        Schema::drop('categories');
        Schema::drop('post_translations');
        Schema::drop('posts');
    }
}
