<?php

namespace GoProp\Http\Controllers\Admin\Agent;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\ViewingSchedule;
use Illuminate\Http\Request;
use GoProp\Models\User;
use Illuminate\Support\Facades\Auth;

class ViewingScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $qb = ViewingSchedule::with(['user', 'user.profile', 'property'])->where('agent_id', $user->id);

        $viewingSchedules = $qb->paginate(50);

        return view('agent.viewing_schedules.index', [
            'viewingSchedules' => $viewingSchedules
        ]);
    }

    public function quickEdit(Request $request, $id)
    {
        $viewingSchedule = ViewingSchedule::findOrFail($id);

        if($request->isMethod('POST')){
            $rules = [
                'viewing_from' => 'required|date_format:Y-m-d H:i|after:now',
                'viewing_until' => 'required|date_format:Y-m-d H:i|after:now',
                'status' => 'required|in:'.implode(',', array_keys(ViewingSchedule::getStatusLabel()))
            ];

            $this->validate($request, $rules);

            $viewingSchedule->update([
                'viewing_from' => \DateTime::createFromFormat('Y-m-d H:i', $request->input('viewing_from'))->format('Y-m-d H:i:s'),
                'viewing_until' => \DateTime::createFromFormat('Y-m-d H:i', $request->input('viewing_until'))->format('Y-m-d H:i:s'),
                'status' => $request->input('status')
            ]);

            return redirect($request->get('backUrl', route('agent.viewing_schedule.index')))->with('messages', ['Viewing schedule is updated.']);
        }

        return view('agent.viewing_schedules.quick_edit_form', [
            'viewingSchedule' => $viewingSchedule
        ]);
    }
}
