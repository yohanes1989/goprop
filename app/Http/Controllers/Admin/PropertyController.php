<?php

namespace GoProp\Http\Controllers\Admin;

use Carbon\Carbon;
use GoProp\Http\Controllers\Controller;
use GoProp\Http\Requests\Admin\PropertyFormRequest;
use GoProp\Models\PackageCategory;
use GoProp\Models\Property;
use GoProp\Models\PropertyAttachment;
use GoProp\Models\User;
use Illuminate\Http\Request;
use GoProp\Facades\AddressHelper;

class PropertyController extends Controller
{
    public function index()
    {
        $qb = Property::whereNotNull('checkout_at')->orderBy('checkout_at', 'DESC');
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

        $packageOptions = [];
        foreach(PackageCategory::all() as $packageCategory){
            foreach($packageCategory->packages as $package){
                $packageOptions[$packageCategory->name][$package->id] = $package->name;
            }
        }

        return view('admin.property.create', [
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'packageOptions' => $packageOptions
        ]);
    }

    public function store(PropertyFormRequest $request)
    {
        $property = new Property();
        $owner = User::where('email', $request->get('owner'))->firstOrFail();

        $property->user()->associate($owner);
        $property->fill($request->all());
        $property->checkout_at = Carbon::now();
        $property->processViewingSchedule($request->all());
        $property->save();

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

        $packageOptions = [];
        foreach(PackageCategory::all() as $packageCategory){
            foreach($packageCategory->packages as $package){
                $packageOptions[$packageCategory->name][$package->id] = $package->name;
            }
        }

        return view('admin.property.edit', [
            'owner' => $owner,
            'property' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'packageOptions' => $packageOptions
        ]);
    }

    public function update(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);

        $owner = User::where('email', $request->get('owner'))->firstOrFail();

        $property->user()->associate($owner);
        $property->fill($request->all());
        $property->processViewingSchedule($request->all());
        $property->save();

        if($request->has('package')){
            $property->packages()->sync([
                $request->input('package') => [
                    'addons' => implode('|', $request->input('features'))
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
}
