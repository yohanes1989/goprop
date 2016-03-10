<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCurrentAgents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $qb = \GoProp\Models\User::orderBy('id', 'ASC');
        $qb->whereHas('roles', function($query){
            $query->where('slug', 'agent');
        });
        $agents = $qb->get();

        foreach($agents as $idx=>$agent){
            $agent->username = time()+$idx;
            $agent->save();

            $agent->username = \GoProp\Facades\AgentHelper::formatAgentCode($idx+1);
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
        //
    }
}
