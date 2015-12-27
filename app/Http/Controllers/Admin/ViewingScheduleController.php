<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\ViewingSchedule;
use Illuminate\Http\Request;
use GoProp\Models\User;

class ViewingScheduleController extends Controller
{
    public function index()
    {
        $qb = ViewingSchedule::with(['user', 'user.profile', 'agent', 'agent.profile']);

        $viewingSchedules = $qb->paginate(50);

        return view('admin.viewing_schedules.index', [
            'viewingSchedules' => $viewingSchedules
        ]);
    }

    public function assignToAgent(Request $request, $id)
    {
        $viewingSchedule = ViewingSchedule::findOrFail($id);

        if($request->isMethod('POST')){
            if($request->has('agent')){
                $agent = User::findOrFail($request->input('agent'));

                $viewingSchedule->agent()->associate($agent);
                $message = 'Viewing Schedule has been assigned to '.$agent->profile->singleName.'.';
            }else{
                $viewingSchedule->agent_id = NULL;
                $message = 'Viewing Schedule is detached from Agent.';
            }

            $viewingSchedule->save();

            return redirect($request->get('backUrl', route('admin.viewing_schedule.index')))->with('messages', [$message]);
        }

        $agentOptions = $this->getAgentOptions();

        return view('admin.viewing_schedules.assign_to_agent', [
            'viewingSchedule' => $viewingSchedule,
            'agentOptions' => $agentOptions
        ]);
    }

    public function quickEdit(Request $request, $id)
    {
        $viewingSchedule = ViewingSchedule::findOrFail($id);

        if($request->isMethod('POST')){
            $rules = [
                'viewing_from' => 'required|date_format:Y-m-d H:i',
                'viewing_until' => 'required|date_format:Y-m-d H:i',
                'status' => 'required|in:'.implode(',', array_keys(ViewingSchedule::getStatusLabel()))
            ];

            $this->validate($request, $rules);

            $viewingSchedule->update([
                'viewing_from' => \DateTime::createFromFormat('Y-m-d H:i', $request->input('viewing_from'))->format('Y-m-d H:i:s'),
                'viewing_until' => \DateTime::createFromFormat('Y-m-d H:i', $request->input('viewing_until'))->format('Y-m-d H:i:s'),
                'status' => $request->input('status')
            ]);

            return redirect($request->get('backUrl', route('admin.viewing_schedule.index')))->with('messages', ['Viewing schedule is updated.']);
        }

        return view('admin.viewing_schedules.quick_edit_form', [
            'viewingSchedule' => $viewingSchedule
        ]);
    }

    public function delete(Request $request, $id)
    {
        $viewingSchedule = ViewingSchedule::findOrFail($id);
        $viewingSchedule->delete();

        return redirect($request->get('backUrl', route('admin.viewing_schedule.index')))->with('messages', ['Viewing Schedule has been deleted.']);
    }

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
}
