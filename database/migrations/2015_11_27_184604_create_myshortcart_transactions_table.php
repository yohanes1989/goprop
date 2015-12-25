<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyshortcartTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myshortcart_transactions', function(Blueprint $table){
            $table->string('ip_address', 16);
            $table->string('process_type', 15);
            $table->dateTime('process_datetime')->nullable();
            $table->dateTime('payment_datetime')->nullable();
            $table->string('transaction_id', 30);
            $table->string('msc_transaction_id', 30);
            $table->decimal('amount', 20, 2);
            $table->string('status_code', 4)->nullable();
            $table->string('result_message', 20)->nullable();
            $table->integer('check_flag')->nullable();
            $table->integer('reversal')->nullable();
            $table->string('payment_channel', 15)->nullable();
            $table->string('payment_code', 20)->nullable();
            $table->string('words')->nullable();
            $table->text('extra_info')->nullable();
            $table->text('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('myshortcart_transactions');
    }
}
