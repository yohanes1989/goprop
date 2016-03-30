<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddListingCodeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->string('listing_code')->after('property_name')->nullable();
        });

        $properties = \GoProp\Models\Property::hasCheckout()->orderBy('checkout_at', 'ASC')->get();
        foreach($properties as $property){
            $property->generateListingCode();
            $property->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function(Blueprint $table){
            $table->dropColumn('listing_code');
        });
    }
}
