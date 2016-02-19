<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Message;
use Illuminate\Http\Request;
use GoProp\Models\User;
use GoProp\Facades\AgentHelper;
use Illuminate\Support\Facades\Auth;

class CustomerInquiryController extends Controller
{
    public function index($type)
    {
        $user = Auth::user();

        $qb = Message::with(['referenced', 'sender', 'recipient'])
            ->has('replies')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'DESC');

        if($type == 'owner'){
            $qb->where('type', Message::TYPE_OWNER_MESSAGE);
        }elseif($type == 'user'){
            $qb->where('type', Message::TYPE_USER_MESSAGE);
        }

        if($user->is('agent')){
            $qb->where('recipient_id', $user->id);
        }

        $conversations = $qb->paginate(50);

        return view('admin.customer_inquiry.index', [
            'conversations' => $conversations
        ]);
    }

    public function assignToAgent(Request $request, $id)
    {
        $conversation = Message::findOrFail($id);

        if($request->isMethod('POST')){
            if($request->has('agent')){
                $agent = User::findOrFail($request->input('agent'));

                $conversation->recipient()->associate($agent);

                $message = 'Conversation has been assigned to '.$agent->profile->singleName.'.';
            }else{
                $conversation->recipient()->dissociate();

                $message = 'Conversation is detached from Agent.';
            }

            $conversation->save();

            return redirect($request->get('backUrl', route('admin.customer_inquiry.index', ['type' => str_replace('_message', '', $conversation->type)])))->with('messages', [$message]);
        }

        $agentOptions = AgentHelper::getAgentOptions();

        return view('admin.customer_inquiry.assign_to_agent', [
            'conversation' => $conversation,
            'agentOptions' => $agentOptions
        ]);
    }

    public function conversation(Request $request, $id)
    {
        $conversation = Message::findOrFail($id);

        $user = Auth::user();

        if(Auth::user()->is('agent')){
            if($user->id != $conversation->recipient_id){
                abort(403, 'Unauthorized action.');
            }
        }elseif(Auth::user()->is('administrator')){

        }

        if($request->isMethod('POST')){
            $rules = [
                'message' => 'required'
            ];

            $this->validate($request, $rules);

            $message = new Message([
                'message' => $request->input('message')
            ]);
            $message->sender()->associate($user);
            $message->recipient()->associate($conversation->sender);
            $message->referenced()->associate($conversation->referenced);
            $message->parentMessage()->associate($conversation);
            $message->save();

            return redirect()->back()->with('success', ['Message is successfully sent.']);
        }

        return view('admin.customer_inquiry.conversation', [
            'conversation' => $conversation
        ]);
    }
}
