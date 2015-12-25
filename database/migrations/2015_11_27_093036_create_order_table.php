<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table){
            $table->increments('id');
            $table->string('order_number', 100)->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('property_id')->nullable()->unsigned();
            $table->integer('package_id')->nullable()->unsigned();
            $table->integer('total_quantity');
            $table->decimal('total_amount', 14, 2);
            $table->text('notes')->nullable();
            $table->string('status', 10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('SET NULL');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('SET NULL');
        });

        Schema::create('order_items', function(Blueprint $table){
            $table->integer('order_id')->nullable()->unsigned();
            $table->string('item', 255);
            $table->string('item_type', 255);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 14, 2);
            $table->decimal('net_price', 14, 2);
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE');
        });

        Schema::create('payments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('order_id')->nullable()->unsigned();
            $table->string('payment_method');
            $table->decimal('amount', 14, 2);
            $table->decimal('total_amount', 14, 2);
            $table->text('notes')->nullable();
            $table->string('status', 10);
            $table->timestamps();
            $table->timestamp('received_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function(Blueprint $table){
            $table->dropForeign('payments_user_id_foreign');
            $table->dropForeign('payments_order_id_foreign');
        });

        Schema::table('order_items', function(Blueprint $table){
            $table->dropForeign('order_items_order_id_foreign');
        });

        Schema::table('orders', function(Blueprint $table){
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('orders_property_id_foreign');
            $table->dropForeign('orders_package_id_foreign');
        });

        Schema::drop('payments');
        Schema::drop('order_items');
        Schema::drop('orders');
    }
}
