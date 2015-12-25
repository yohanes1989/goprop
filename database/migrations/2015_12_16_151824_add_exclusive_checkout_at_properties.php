<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExclusiveCheckoutAtProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->string('level_rent')->default(\GoProp\Models\Property::LEVEL_STANDARD)->after('status');
            $table->string('level_sell')->default(\GoProp\Models\Property::LEVEL_STANDARD)->after('status');
            $table->timestamp('checkout_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->dropColumn('level_sell');
            $table->dropColumn('level_rent');
            $table->dropColumn('checkout_at');
        });
    }
}
