<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table){
            $table->increments('id');
            $table->integer('sender_id')->nullable()->unsigned();
            $table->integer('recipient_id')->nullable()->unsigned();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->morphs('referenced');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('parent_id')->references('id')->on('messages')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table){
            $table->dropForeign('messages_sender_id_foreign');
            $table->dropForeign('messages_recipient_id_foreign');
            $table->dropForeign('messages_parent_id_foreign');
        });

        Schema::drop('messages');
    }
}
