<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusViewingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viewing_schedules', function(Blueprint $table){
            $table->increments('id')->first();
            $table->string('status', 100)->default(\GoProp\Models\ViewingSchedule::STATUS_PENDING);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viewing_schedules', function(Blueprint $table){
            $table->dropColumn('id');
            $table->dropColumn('status');
        });
    }
}
