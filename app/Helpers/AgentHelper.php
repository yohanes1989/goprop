<?php

namespace GoProp\Helpers;

use GoProp\Models\User;

class AgentHelper
{
    public function getAgentOptions()
    {
        $qb = User::query();
        $qb->selectRaw($qb->getQuery()->from.'.id, CONCAT(first_name, " ", last_name) AS full_name')->leftJoin('profiles AS P', 'P.user_id', '=', $qb->getQuery()->from.'.id');
        $qb->whereHas('roles', function($query){
            $query->where('slug', 'agent');
        });

        $agentOptions = $qb->lists('full_name', 'id')->all();

        return $agentOptions;
    }

    public function inquiryStatusByMessage($message)
    {
        if($message){
            //If sender is the same as author, than it's sender
            if($message->sender_id == $message->parentMessage->sender_id){
                return 'Sender reply';
            }else{
                return 'Agent reply';
            }
        }else{
            return 'No Conversation';
        }
    }

    public function formatAgentCode($number)
    {
        $prefix = 'agent';

        return $prefix.str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function getNextAgentCode()
    {
        $prefix = 'agent';

        $qb = User::orderBy('username', 'DESC');
        $qb->whereHas('roles', function($query){
            $query->where('slug', 'agent');
        });

        $lastAgent = $qb->first();

        if(!$lastAgent){
            $lastAgentNumber = 0;
        }else{
            $lastAgentNumber = intval(str_replace($prefix,'', $lastAgent->username));
        }

        return $this->formatAgentCode($lastAgentNumber+1);
    }
}