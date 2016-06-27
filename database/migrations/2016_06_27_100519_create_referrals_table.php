<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_informations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('property_type_id')->unsigned();
            $table->string('name');
            $table->string('contact_number')->nullable();
            $table->string('other_contact_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->integer('province')->nullable();
            $table->integer('city')->nullable();
            $table->integer('subdistrict')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->string('status')->default(\GoProp\Models\ReferralInformation::STATUS_MAYBE);
            $table->boolean('followed_up')->default(FALSE);
            $table->timestamps();

            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('referral_informations');
    }
}
