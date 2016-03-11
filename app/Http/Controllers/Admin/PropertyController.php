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

class PropertyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $qb = Property::with(['agent'])->whereNotNull('checkout_at')->orderBy('checkout_at', 'DESC');
        AddressHelper::addAddressQueryScope($qb);

        if($user->is('agent')){
            $qb->where('user_id', $user->id);
        }

        $properties = $qb->paginate(50);

        return view('admin.property.index', [
            'properties' => $properties
        ]);
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

        if($user->is('agent')){
            $property->agent()->associate($owner);
            $property->status = Property::STATUS_INACTIVE;
        }

        $data = $request->all();
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);
        $property->checkout_at = Carbon::now();
        $property->processViewingSchedule($request->all());
        $property->save();

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
        $property = Property::findOrFail($id);
        $owner = $property->user->email;

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
        $property = Property::findOrFail($id);

        $ownerEmail = $request->get('owner', $user->email);
        $owner = User::where('email', $ownerEmail)->firstOrFail();

        $property->user()->associate($owner);

        $data = $request->all();
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);

        $property->processViewingSchedule($request->all());
        $property->save();

        //Clear all packages
        $property->packages()->detach();
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

    public function photosDelete(Request $request, $id, $attachment_id)
    {
        $property = Property::findOrFail($id);

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
        $property = Property::findOrFail($id);

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

    public function photosRotate(Request $request, $id, $dir='right', $attachment_id)
    {
        $property = Property::findOrFail($id);

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

    public function attachmentBelongsToProperty($attachment_id, $property)
    {
        $allowedAttachments = $property->attachments()->lists('id')->all();

        if(!in_array($attachment_id, $allowedAttachments)){
            return redirect()->back()->with('messages', [trans('forms.property.messages.attachment_invalid_property')]);
        }
    }
}
