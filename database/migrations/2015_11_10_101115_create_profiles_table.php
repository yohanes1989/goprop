<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('title', 10)->nullable();
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('mobile_phone_number', 255)->nullable();
            $table->string('home_phone_number', 255)->nullable();
            $table->text('address')->nullable();
            $table->integer('province')->nullable();
            $table->integer('city')->nullable();
            $table->integer('subdistrict')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('profile_picture', 255)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::create('extended_profiles', function(Blueprint $table){
            $table->increments('id');
            $table->integer('profile_id')->nullable()->unsigned();
            $table->decimal('property_sell_price', 17, 2)->nullable();
            $table->decimal('property_buy_price', 17, 2)->nullable();
            $table->integer('property_to_sell')->nullable();
            $table->integer('property_to_let')->nullable();
            $table->string('referral_source')->nullable();

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('CASCADE');
        });

        Schema::create('subscriptions', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255)->nullable();
            $table->text('question_text')->nullable();
        });

        Schema::create('subscription_user', function(Blueprint $table){
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('subscription_id')->nullable()->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_user', function(Blueprint $table){
            $table->dropForeign('subscription_user_user_id_foreign');
            $table->dropForeign('subscription_user_subscription_id_foreign');
        });
        Schema::drop('subscription_user');
        Schema::drop('subscriptions');

        Schema::table('extended_profiles', function(Blueprint $table){
            $table->dropForeign('extended_profiles_profile_id_foreign');
        });
        Schema::drop('extended_profiles');

        Schema::table('profiles', function(Blueprint $table){
            $table->dropForeign('profiles_user_id_foreign');
        });
        Schema::drop('profiles');
    }
}
