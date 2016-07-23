<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Facades\AddressHelper;
use GoProp\Facades\AgentHelper;
use GoProp\Models\ReferralInformation;
use Illuminate\Http\Request;
use GoProp\Http\Requests\Admin\ReferralInformationFormRequest;
use GoProp\Http\Requests;
use GoProp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $qb = ReferralInformation::orderBy('created_at', 'DESC');
        AddressHelper::addAddressQueryScope($qb);

        if($request->has('search')){

            if($request->has('search.keyword')){
                $qb->where(function($query) use ($request){
                    $query
                        ->orWhere('name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('contact_number', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('other_contact_number', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('email', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('address', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('province_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('city_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('subdistrict_name', 'LIKE', '%'.$request->input('search.keyword').'%');
                });
            }

            if($request->has('search.agent')){
                $qb->whereHas('user', function($query) use ($request){
                    $query->where('id', $request->input('search.agent'));
                });
            }

            if($request->input('search.status', 'all') != 'all'){
                $qb->where('status', $request->input('search.status'));
            }

            if($request->input('search.followed_up', 'all') != 'all'){
                $followedUp = $request->input('search.followed_up') == 'yes';
                $qb->where('followed_up', $followedUp);
            }
        }

        if($user->is('agent')){
            $qb->where('user_id', $user->id);
            $agentOptions = [];
        }else{
            $agentOptions = AgentHelper::getAgentOptions();
        }

        $referrals = $qb->paginate(50);
        $referrals->appends(['search' => $request->input('search')]);

        $statusOptions = ['all' => 'Status'] + ReferralInformation::getStatusOptions();
        $followedUpOptions = ['all' => 'Follow Up Status', 'yes' => 'Followed Up', 'no' => 'Unfollowed Up'];

        return view('admin.referrals.index', [
            'referrals' => $referrals,
            'statusOptions' => $statusOptions,
            'followedUpOptions' => $followedUpOptions,
            'agentOptions' => $agentOptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $referralInformation = new ReferralInformation();

        $statusOptions = ReferralInformation::getStatusOptions();

        return view('admin.referrals.create', [
            'referralInformation' => $referralInformation,
            'statusOptions' => $statusOptions,
            'isAdmin' => Auth::user()->is('administrator')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReferralInformationFormRequest $request)
    {
        $user = Auth::user();

        $referralInformation = new ReferralInformation();
        $referralInformation->fill($request->all());
        $referralInformation->user()->associate($user);
        $referralInformation->save();

        $messageVars = [
            'referralInformation' => $referralInformation,
        ];

        Mail::send('frontend.emails.new_referral_information', $messageVars, function ($m){
            $m->from(config('app.contact_from_email'), config('app.contact_from_name'));
            $m->to(config('app.contact_destination'))->subject('New Referral Listing Information');
        });

        return redirect()->route($user->backendAccess.'.referrals.index')->with('messages', ['Terima kasih untuk referensi properti kamu. Kami akan segera melakukan follow-up kepada Owner properti ini.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $referralInformation = ReferralInformation::findOrFail($id);

        if(!$this->isEditable($referralInformation)){
            return redirect()->route($user->backendAccess.'.referrals.index')->withErrors(['Your referral can\'t be edited because it has been followed up.']);
        }

        $statusOptions = ReferralInformation::getStatusOptions();

        return view('admin.referrals.edit', [
            'referralInformation' => $referralInformation,
            'statusOptions' => $statusOptions,
            'isAdmin' => Auth::user()->is('administrator')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReferralInformationFormRequest $request, $id)
    {
        $user = Auth::user();

        $referralInformation = ReferralInformation::findOrFail($id);

        if(!$this->isEditable($referralInformation)){
            return redirect()->route($user->backendAccess.'.referrals.index')->withErrors(['Your referral can\'t be updated because it has been followed up.']);
        }

        $referralInformation->fill($request->all());
        $referralInformation->save();

        return redirect()->route($user->backendAccess.'.referrals.index')->with('messages', ['Informasi referral berhasil dirubah.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = Auth::user();
        $referralInformation = ReferralInformation::findOrFail($id);

        if(!$this->isEditable($referralInformation)){
            return redirect()->route($user->backendAccess.'.referrals.index')->withErrors(['Your referral can\'t be deleted because it has been followed up.']);
        }

        $referralInformation->delete();

        return redirect()->route($user->backendAccess.'.referrals.index')->with('messages', ['Informasi referral dihapus.']);
    }

    protected function isEditable($referralInformation)
    {
        $user = Auth::user();
        return $user->is('administrator') || !$referralInformation->followed_up;
    }
}
