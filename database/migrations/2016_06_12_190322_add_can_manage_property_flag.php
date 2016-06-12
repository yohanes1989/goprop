<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCanManagePropertyFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->boolean('manage_property')->default(FALSE)->nullable();
        });

        $qb = \GoProp\Models\User::with('profile');
        $qb->whereHas('roles', function($query){
            $query->where('slug', 'agent');
        });

        $agents = $qb->get();

        foreach($agents as $agent){
            $agent->manage_property = TRUE;
            $agent->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('manage_property');
        });
    }
}
