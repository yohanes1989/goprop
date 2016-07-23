<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainBannerLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_banner_translations', function(Blueprint $table){
            $table->string('link_path')->nullable()->after('locale');
            $table->string('link_target')->nullable()->after('link_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_banner_translations', function(Blueprint $table){
            $table->dropColumn('link_path');
            $table->dropColumn('link_target');
        });
    }
}
