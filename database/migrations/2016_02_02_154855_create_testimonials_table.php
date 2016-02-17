<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function(Blueprint $table){
            $table->increments('id');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('testimonial_translations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('testimonial_id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->string('locale')->index();

            $table->unique(['testimonial_id', 'locale']);
            $table->foreign('testimonial_id')->references('id')->on('testimonials')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('testimonial_translations');
        Schema::drop('testimonials');
    }
}
