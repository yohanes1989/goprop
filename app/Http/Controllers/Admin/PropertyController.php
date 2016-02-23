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
use Illuminate\Support\Facades\Session;

class PropertyController extends Controller
{
    public function index()
    {
        $qb = Property::with(['agent'])->whereNotNull('checkout_at')->orderBy('checkout_at', 'DESC');
        AddressHelper::addAddressQueryScope($qb);

        $properties = $qb->paginate(50);

        return view('admin.property.index', [
            'properties' => $properties
        ]);
    }

    public function create()
    {
        $property = new Property();

        $defaultLatitude = old('latitude', config('app.default_latitude'));
        $defaultLongitude = old('longitude', config('app.default_longitude'));

        $property->latitude = $defaultLatitude;
        $property->longitude = $defaultLongitude;

        if(empty($defaultLatitude) || empty($defaultLongitude)){
            $mapDefault = true;
        }else{
            $mapDefault = false;
        }

        $package = Session::hasOldInput('package')?Package::findOrFail(Session::getOldInput('package')):null;

        $packageOptions = [];
        foreach(PackageCategory::all() as $packageCategory){
            foreach($packageCategory->packages as $packageItem){
                $packageOptions[$packageCategory->name][$packageItem->id] = $packageItem->name;
            }
        }

        return view('admin.property.create', [
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'packageOptions' => $packageOptions,
            'package' => $package
        ]);
    }

    public function store(PropertyFormRequest $request)
    {
        $property = new Property();
        $owner = User::where('email', $request->get('owner'))->firstOrFail();

        $property->user()->associate($owner);

        $data = $request->all();
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);
        $property->checkout_at = Carbon::now();
        $property->processViewingSchedule($request->all());
        $property->save();

        if($request->has('package')){
            $property->packages()->sync([
                $request->input('package') => [
                    'addons' => $request->has('features')?implode('|', $request->input('features')):null
                ]
            ]);
        }

        return redirect()->route('admin.property.index')->with('messages', ['Property is successfully created.']);
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        $owner = $property->user->email;

        $defaultLatitude = empty($property->latitude)?config('app.default_latitude'):$property->latitude;
        $defaultLongitude = empty($property->longitude)?config('app.default_longitude'):$property->longitude;

        if(empty($property->latitude) || empty($property->longitude)){
            $mapDefault = true;
        }else{
            $mapDefault = false;
        }

        $package = $property->packages?$property->packages->first():(Session::hasOldInput('package')?Package::findOrFail(Session::getOldInput('package')):Package::whereSlug('basic')->first());

        $packageOptions = [];
        foreach(PackageCategory::all() as $packageCategory){
            foreach($packageCategory->packages as $packageItem){
                $packageOptions[$packageCategory->name][$packageItem->id] = $packageItem->name;
            }
        }

        return view('admin.property.edit', [
            'owner' => $owner,
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'packageOptions' => $packageOptions,
            'package' => $package
        ]);
    }

    public function update(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);

        $owner = User::where('email', $request->get('owner'))->firstOrFail();

        $property->user()->associate($owner);

        $data = $request->all();
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);

        $property->processViewingSchedule($request->all());
        $property->save();

        if($request->has('package')){
            $property->packages()->sync([
                $request->input('package') => [
                    'addons' => $request->has('features')?implode('|', $request->input('features')):null
                ]
            ]);
        }

        return redirect()->route('admin.property.index')->with('messages', ['Property is successfully saved.']);
    }

    public function delete(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->delete();
        return redirect()->route('admin.property.index')->with('messages', ['Property is successfully deleted.']);
    }

    public function media($id)
    {
        $property = Property::findOrFail($id);

        return view('admin.property.media', [
            'property' => $property
        ]);
    }

    public function photosUpload(Request $request, $id, $type)
    {
        $property = Property::findOrFail($id);

        $max = 500;
        if($type == 'floorplan'){
            $max = 1024;
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

    public function photosDelete(Request $request, $id, $attachment_id)
    {
        $property = Property::findOrFail($id);

        $allowedAttachments = $property->attachments()->lists('id')->all();

        if(!in_array($attachment_id, $allowedAttachments)){
            return redirect()->route('frontend.property.photos', ['id' => $id])->with('messages', [trans('forms.property.messages.attachment_invalid_property')]);
        }

        $propertyAttachment = PropertyAttachment::findOrFail($attachment_id);
        $propertyAttachment->delete();

        if($propertyAttachment->type == 'photo'){
            return redirect()->back()->with('messages', ['Photo has been deleted']);
        }elseif($propertyAttachment->type == 'floorplan'){
            return redirect()->back()->with('messages', ['Floorplan has been deleted']);
        }
    }

    public function photosReorder(Request $request, $id)
    {
        $property = Property::findOrFail($id);
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

    public function assignToAgent(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        if($request->isMethod('POST')){
            //Get remaining schedules for this property
            $viewingSchedules = $property->viewingSchedules()->where('viewing_from', '>', Carbon::now())->get();
            $conversations = $property->conversations;

            if($request->has('agent')){
                $agent = User::findOrFail($request->input('agent'));

                $property->agent()->associate($agent);

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
                $property->agent()->dissociate();

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

            return redirect($request->get('backUrl', route('admin.property.index')))->with('messages', [$message]);
        }

        $agentOptions = AgentHelper::getAgentOptions();

        return view('admin.property.assign_to_agent', [
            'property' => $property,
            'agentOptions' => $agentOptions
        ]);
    }
}
