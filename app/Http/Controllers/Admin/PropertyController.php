<?php

namespace GoProp\Http\Controllers\Admin;

use Carbon\Carbon;
use GoProp\Http\Controllers\Controller;
use GoProp\Http\Requests\Admin\PropertyFormRequest;
use GoProp\Models\Package;
use GoProp\Models\PackageCategory;
use GoProp\Models\Property;
use GoProp\Models\PropertyAttachment;
use GoProp\Models\User;
use GoProp\Models\ViewingSchedule;
use Illuminate\Http\Request;
use GoProp\Facades\AddressHelper;
use GoProp\Facades\AgentHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $qb = Property::with(['agentList'])->whereNotNull('checkout_at')->orderBy('checkout_at', 'DESC');
        AddressHelper::addAddressQueryScope($qb);

        if($user->is('agent')){
            $qb->where('properties.agent_list_id', $user->id);
            $agentOptionsQb = clone $qb;
        }

        if($request->has('search')){
            if($request->input('search.deleted', false)){
                $qb->onlyTrashed();
            }

            if($request->has('search.keyword')){
                $qb->where(function($query) use ($request){
                    $query
                        ->orWhere('listing_code', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('address', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('description', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('property_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('province_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('city_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                        ->orWhere('subdistrict_name', 'LIKE', '%'.$request->input('search.keyword').'%');
                });
            }

            if($request->has('search.for')){
                $qb->where('for_'.$request->input('search.for'), 1);
            }

            if($request->has('search.owner')){
                $qb->whereHas('user', function($query) use ($request){
                    $query->where('email', $request->input('search.owner'));
                });
            }

            if($request->has('search.upload_date')){
                $uploadDateFilter = Carbon::createFromFormat('d-m-Y', $request->input('search.upload_date'));
                $qb->where('checkout_at', '>=', $uploadDateFilter->format('Y-m-d'));
                $qb->where('checkout_at', '<', $uploadDateFilter->modify('+1 day')->format('Y-m-d'));
            }

            if($request->has('search.agentList')){
                if($request->input('search.agentList') == 'unassigned'){
                    $qb->whereNull('agent_list_id');
                }else{
                    $qb->whereHas('agentList', function($query) use ($request){
                        $query->where('id', $request->input('search.agentList'));
                    });
                }
            }

            if($request->has('search.agentSell')){
                if($request->input('search.agentSell') == 'unassigned'){
                    $qb->whereNull('agent_sell_id');
                }else{
                    $qb->whereHas('agentSell', function($query) use ($request){
                        $query->where('id', $request->input('search.agentSell'));
                    });
                }
            }

            if($request->has('search.referralList')){
                if($request->input('search.referralList') == 'unassigned'){
                    $qb->whereNull('referral_list_id');
                }else{
                    $qb->whereHas('referralList', function($query) use ($request){
                        $query->where('id', $request->input('search.referralList'));
                    });
                }
            }

            if($request->has('search.referralSell')){
                if($request->input('search.referralSell') == 'unassigned'){
                    $qb->whereNull('referral_sell_id');
                }else{
                    $qb->whereHas('referralSell', function($query) use ($request){
                        $query->where('id', $request->input('search.referralSell'));
                    });
                }
            }

            if($request->has('search.status')){
                $qb->where('status', $request->input('search.status'));
            }
        }

        if($request->has('export_xls')){
            $data = [
                'properties' => $qb->get()
            ];

            Excel::create('Property Export', function($excel) use ($data) {

                // Set the title
                $excel->setTitle('Property Export');

                $excel->sheet('Sheet 1', function($sheet) use ($data) {
                    $sheet->loadView('admin.property.export.property', $data);
                });
            })->download('xlsx');
        }

        $properties = $qb->paginate(50);
        $properties->appends(['search' => $request->input('search')]);

        $forOptions = [
            '' => 'For',
            'sell' => 'Sell',
            'rent' => 'Rent'
        ];

        $agentOptions = AgentHelper::getAgentOptions();
        $agentOptions = ['unassigned' => 'Unassigned'] + $agentOptions;
        $statusOptions = ['' => 'Status'] + Property::getStatusLabel();
        unset($statusOptions[Property::STATUS_DRAFT]);

        $ownerOptions = [];
        if($user->is('agent')){
            $agentOptionsQb->leftJoin('users AS U', 'U.id', '=', 'properties.user_id')
                ->leftJoin('profiles AS P', 'P.user_id', '=', 'U.id')
                ->selectRaw('properties.*, U.email, CONCAT(P.first_name, \' \', P.last_name) AS full_name')
                ->groupBy('properties.user_id');
            $ownerOptions = $agentOptionsQb->get()->pluck('full_name', 'email')->all();
        }

        return view('admin.property.index', [
            'properties' => $properties,
            'forOptions' => $forOptions,
            'statusOptions' => $statusOptions,
            'agentOptions' => $agentOptions,
            'ownerOptions' => $ownerOptions
        ]);
    }

    public function view($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $owner = $property->user?$property->user->email:'';

        $defaultLatitude = empty($property->latitude)?config('app.default_latitude'):$property->latitude;
        $defaultLongitude = empty($property->longitude)?config('app.default_longitude'):$property->longitude;

        if(empty($property->latitude) || empty($property->longitude)){
            $mapDefault = true;
        }else{
            $mapDefault = false;
        }

        $sellPackage = old('sell_package')?Package::findOrFail(old('sell_package')):null;
        $rentPackage = old('rent_package')?Package::findOrFail(old('rent_package')):null;

        $packages = $property->packages()->with('category')->get();
        foreach($packages as $package){
            if($package->category->slug == 'rent' && !$rentPackage){
                $rentPackage = $package;
            }elseif($package->category->slug == 'sell' && !$sellPackage){
                $sellPackage = $package;
            }
        }

        $viewData = [
            'owner' => $owner,
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'sellPackage' => $sellPackage,
            'rentPackage' => $rentPackage
        ];

        foreach(PackageCategory::all() as $packageCategory){
            ${$packageCategory->slug.'PackageOptions'} = $packageCategory->packages->pluck('name', 'id')->all();

            $viewData[$packageCategory->slug.'PackageOptions'] = ${$packageCategory->slug.'PackageOptions'};
        }

        return view('admin.property.view', $viewData);
    }

    public function create()
    {
        $property = new Property();

        $defaultLatitude = empty($property->latitude)?config('app.default_latitude'):$property->latitude;
        $defaultLongitude = empty($property->longitude)?config('app.default_longitude'):$property->longitude;

        if(empty($property->latitude) || empty($property->longitude)){
            $mapDefault = true;
        }else{
            $mapDefault = false;
        }

        $sellPackage = old('sell_package')?Package::findOrFail(old('sell_package')):null;
        $rentPackage = old('rent_package')?Package::findOrFail(old('rent_package')):null;

        $packages = $property->packages()->with('category')->get();
        foreach($packages as $package){
            if($package->category->slug == 'rent' && !$rentPackage){
                $rentPackage = $package;
            }elseif($package->category->slug == 'sell' && !$sellPackage){
                $sellPackage = $package;
            }
        }

        $viewData = [
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'sellPackage' => $sellPackage,
            'rentPackage' => $rentPackage
        ];

        foreach(PackageCategory::all() as $packageCategory){
            ${$packageCategory->slug.'PackageOptions'} = $packageCategory->packages->pluck('name', 'id')->all();

            $viewData[$packageCategory->slug.'PackageOptions'] = ${$packageCategory->slug.'PackageOptions'};
        }

        return view('admin.property.create', $viewData);
    }

    public function store(PropertyFormRequest $request)
    {
        $user = Auth::user();
        $property = new Property();

        $ownerEmail = $request->get('owner', $user->email);
        $owner = User::where('email', $ownerEmail)->firstOrFail();

        $property->user()->associate($owner);

        if($request->has('listing_referral')){
            $listingReferral = User::where('email', $request->input('listing_referral'))->firstOrFail();
            $property->referralList()->associate($listingReferral);
        }

        if($request->has('selling_agent')){
            $agentSelling = User::where('email', $request->input('selling_agent'))->firstOrFail();
            $property->agentSell()->associate($agentSelling);
        }

        if($request->has('selling_referral')){
            $agentReferral = User::where('email', $request->input('selling_referral'))->firstOrFail();
            $property->referralSell()->associate($agentReferral);
        }

        if($user->is('agent')){
            $property->agentList()->associate($owner);
            $property->status = Property::STATUS_INACTIVE;
        }

        $data = $request->all();
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);
        $property->checkout_at = Carbon::now();
        $property->generateListingCode();
        $property->processViewingSchedule($request->all());
        $property->save();

        $checkedPortals = [];
        foreach($request->input('property_portals', []) as $checkedPortal){
            $checkedPortals[$checkedPortal] = [
                'user_id' => $user->id
            ];
        }

        $property->propertyPortals()->sync($checkedPortals);

        if($request->has('sell_package')){
            $property->packages()->attach([
                $request->input('sell_package') => [
                    'addons' => implode('|', $request->input('features.sell', []))
                ]
            ]);
        }

        if($request->has('rent_package')){
            $property->packages()->attach([
                $request->input('rent_package') => [
                    'addons' => implode('|', $request->input('features.rent', []))
                ]
            ]);
        }

        return redirect()->route('admin.property.index')->with('messages', ['Property is successfully created.']);
    }

    public function edit($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $owner = $property->user?$property->user->email:'';

        $defaultLatitude = empty($property->latitude)?config('app.default_latitude'):$property->latitude;
        $defaultLongitude = empty($property->longitude)?config('app.default_longitude'):$property->longitude;

        if(empty($property->latitude) || empty($property->longitude)){
            $mapDefault = true;
        }else{
            $mapDefault = false;
        }

        $sellPackage = old('sell_package')?Package::findOrFail(old('sell_package')):null;
        $rentPackage = old('rent_package')?Package::findOrFail(old('rent_package')):null;

        $packages = $property->packages()->with('category')->get();
        foreach($packages as $package){
            if($package->category->slug == 'rent' && !$rentPackage){
                $rentPackage = $package;
            }elseif($package->category->slug == 'sell' && !$sellPackage){
                $sellPackage = $package;
            }
        }

        $viewData = [
            'owner' => $owner,
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'sellPackage' => $sellPackage,
            'rentPackage' => $rentPackage
        ];

        foreach(PackageCategory::all() as $packageCategory){
            ${$packageCategory->slug.'PackageOptions'} = $packageCategory->packages->pluck('name', 'id')->all();

            $viewData[$packageCategory->slug.'PackageOptions'] = ${$packageCategory->slug.'PackageOptions'};
        }

        return view('admin.property.edit', $viewData);
    }

    public function update(PropertyFormRequest $request, $id)
    {
        $user = Auth::user();
        $property = Property::withTrashed()->findOrFail($id);

        $ownerEmail = $request->get('owner', $user->email);
        $owner = User::where('email', $ownerEmail)->firstOrFail();

        $property->user()->associate($owner);

        if($request->has('listing_referral')){
            $listingReferral = User::where('email', $request->input('listing_referral'))->firstOrFail();
            $property->referralList()->associate($listingReferral);
        }

        if($request->has('selling_agent')){
            $agentSelling = User::where('email', $request->input('selling_agent'))->firstOrFail();
            $property->agentSell()->associate($agentSelling);
        }

        if($request->has('selling_referral')){
            $agentReferral = User::where('email', $request->input('selling_referral'))->firstOrFail();
            $property->referralSell()->associate($agentReferral);
        }

        $data = $request->all();
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);

        $property->processViewingSchedule($request->all());
        $property->save();

        $checkedPortals = [];
        foreach($request->input('property_portals', []) as $checkedPortal){
            $checkedPortals[$checkedPortal] = [
                'user_id' => $user->id
            ];
        }

        $property->propertyPortals()->sync($checkedPortals);

        //Clear all packages
        $property->packages()->detach();
        if($request->input('for_sell') && $request->has('sell_package')){
            $property->packages()->attach([
                $request->input('sell_package') => [
                    'addons' => implode('|', $request->input('features.sell', []))
                ]
            ]);
        }

        if($request->input('for_rent') && $request->has('rent_package')){
            $property->packages()->attach([
                $request->input('rent_package') => [
                    'addons' => implode('|', $request->input('features.rent', []))
                ]
            ]);
        }

        return redirect($request->input('backUrl'))->with('messages', ['Property is successfully saved.']);
    }

    public function delete(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->delete();
        return redirect()->back()->with('messages', ['Property is successfully deleted.']);
    }

    public function deleteForce(Request $request, $id)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $property->forceDelete();
        return redirect()->back()->with('messages', ['Property is successfully deleted from Trash.']);
    }

    public function restore(Request $request, $id)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $property->restore();
        return redirect()->back()->with('messages', ['Property is successfully restored.']);
    }

    public function media($id)
    {
        $property = Property::withTrashed()->findOrFail($id);

        return view('admin.property.media', [
            'property' => $property
        ]);
    }

    public function photosUpload(Request $request, $id, $type)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $max = 5096;
        if($type == 'floorplan'){
            $max = 2048;
        }

        $rules = [
            'files' => 'required'
        ];

        foreach($request->file('files') as $idx=>$file){
            $rules['files.'.$idx] = 'image|max:'.$max;
        }

        $this->validate($request, $rules);

        $uploadedPhotos = [];

        foreach($request->file('files') as $idx=>$file){
            $uploadedPhoto = $property->savePhoto($file, $type, $idx);
            $uploadedPhotos[] = view('admin.property.upload_photo', ['property' => $property, 'photo' => $uploadedPhoto])->render();
        }

        return response()->json($uploadedPhotos);
    }

    public function photosDownload($id, $type)
    {
        $property = Property::withTrashed()->findOrFail($id);

        if($file = $property->downloadPhoto($type)){
            return response()->download($file);
        }else{
            return redirect()->back()->withErrors(['Not available for download']);
        }
    }

    public function photosDownloadClear($id, $type)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $property->deleteDownloadPhoto($type);

        return redirect()->back()->with('messages', ['Download material deletion is successful.']);
    }

    public function photosDelete(Request $request, $id, $attachment_id)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $this->attachmentBelongsToProperty($attachment_id, $property);

        $propertyAttachment = PropertyAttachment::findOrFail($attachment_id);
        $propertyAttachment->delete();

        if($propertyAttachment->type == 'photo'){
            return redirect()->back()->with('messages', ['Photo has been deleted']);
        }elseif($propertyAttachment->type == 'floorplan'){
            return redirect()->back()->with('messages', ['Floorplan has been deleted']);
        }
    }

    public function photosDeleteAll(Request $request, $id, $type)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $photos = [];

        if($type == 'photo'){
            $photos = $property->photos;
        }elseif($type == 'floorplan'){
            $photos = $property->floorplans;
        }

        foreach($photos as $photo){
            $photo->delete();
        }

        return redirect()->back()->with('messages', ['All '.$type.' are deleted.']);
    }

    public function photosReorder(Request $request, $id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $allowedAttachments = $property->attachments()->lists('id')->all();

        $count = 1;

        $ordered = [];

        foreach($request->input('photos', []) as $photo){
            if(in_array($photo, $allowedAttachments)){
                $attachment = PropertyAttachment::findOrFail($photo);
                $attachment->update([
                    'sort_order' => $count
                ]);

                $ordered[] = $attachment->id;

                $count += 1;
            }
        }

        return response()->json($ordered);
    }

    public function photosRotate(Request $request, $id, $dir='right', $attachment_id)
    {
        $property = Property::withTrashed()->findOrFail($id);

        $this->attachmentBelongsToProperty($attachment_id, $property);

        $propertyAttachment = PropertyAttachment::findOrFail($attachment_id);

        $propertyAttachment->rotate($dir);

        if($propertyAttachment->type == 'photo'){
            return redirect()->back()->with('messages', ['Photo has been rotated']);
        }elseif($propertyAttachment->type == 'floorplan'){
            return redirect()->back()->with('messages', ['Floorplan has been rotated']);
        }
    }

    public function assignToAgent(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $backUrl = $request->get('backUrl', route('admin.property.index'));

        if($request->isMethod('POST')){
            $backUrl = $request->input('backUrl', route('admin.property.index'));

            //Get remaining schedules for this property
            $viewingSchedules = $property->viewingSchedules()->where('viewing_from', '>', Carbon::now())->get();
            $conversations = $property->conversations;

            if($request->has('agent')){
                $agent = User::findOrFail($request->input('agent'));

                $property->agentList()->associate($agent);

                foreach($viewingSchedules as $viewingSchedule){
                    $viewingSchedule->agent()->associate($agent);
                    $viewingSchedule->save();
                }

                foreach($conversations as $conversation){
                    $conversation->recipient()->associate($agent);
                    $conversation->save();
                }

                $message = 'Property, Viewing Schedules and Conversation have been assigned to '.$agent->profile->singleName.'.';
            }else{
                $property->agentList()->dissociate();

                foreach($viewingSchedules as $viewingSchedule){
                    $viewingSchedule->agent()->dissociate();
                    $viewingSchedule->save();
                }

                foreach($conversations as $conversation){
                    $conversation->recipient()->dissociate();
                    $conversation->save();
                }

                $message = 'Property, Viewing Schedules and Conversation have been detached from Agent.';
            }

            $property->save();

            return redirect($backUrl)->with('messages', [$message]);
        }

        $agentOptions = AgentHelper::getAgentOptions();

        return view('admin.property.assign_to_agent', [
            'property' => $property,
            'agentOptions' => $agentOptions,
            'backUrl' => $backUrl
        ]);
    }

    public function attachmentBelongsToProperty($attachment_id, $property)
    {
        $allowedAttachments = $property->attachments()->lists('id')->all();

        if(!in_array($attachment_id, $allowedAttachments)){
            return redirect()->back()->with('messages', [trans('forms.property.messages.attachment_invalid_property')]);
        }
    }
}
