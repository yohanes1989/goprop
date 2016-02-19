<?php

namespace GoProp\Http\Controllers\Frontend;

use Carbon\Carbon;
use GoProp\Facades\AddressHelper;
use GoProp\Facades\ProjectHelper;
use GoProp\Facades\PropertyCompareHelper;
use GoProp\Http\Controllers\Controller;
use GoProp\Http\Requests\PropertyFormRequest;
use GoProp\Models\Order;
use GoProp\Models\OrderItem;
use GoProp\Models\Package;
use GoProp\Models\PackageCategory;
use GoProp\Models\Page;
use GoProp\Models\Payment;
use GoProp\Models\Property;
use GoProp\Models\PropertyAttachment;
use GoProp\Models\ViewingSchedule;
use GoProp\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Webpresso\MyShortCart\Facades\MyShortCart;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['postAddToCart', 'getCompare', 'getAddToComparison', 'getRemoveFromComparison', 'getLikeProperty', 'getUnlikeProperty', 'getToggleLikeProperty', 'getSearch', 'getSimpleSearch', 'getView']]);
        $this->middleware('property_owner', ['except' => ['index', 'getCompare', 'getAddToComparison', 'getRemoveFromComparison', 'getScheduleViewing', 'postScheduleViewing', 'getLikeProperty', 'getUnlikeProperty', 'getToggleLikeProperty', 'getSearch', 'getSimpleSearch', 'getView', 'getCreate', 'postCreate', 'postAddToCart']]);
        $this->middleware('likeable', ['only' => ['getLikeProperty', 'getUnlikeProperty', 'getToggleLikeProperty']]);
        $this->middleware('property_editable', ['only' => [
            'getEdit', 'postEdit',
            'getPropertyDetails', 'postPropertyDetails',
            'getPropertyMap', 'postPropertyMap',
            'getPropertyPhotos', 'postPropertyPhotos',
            'getPropertyFloorplans', 'postPropertyFloorplans',
            'postPropertyPhotosUpload', 'postPropertyPhotosDelete', 'postPropertyPhotosReorder']]);
        $this->middleware('property_cart_order', ['only' => ['getPropertyOrderReview', 'postPropertyOrderReview']]);
    }

    public function index($for = 'sell')
    {
        $user = Auth::user();

        if(in_array($for, ['sell', 'lease'])){
            $qb = $user->properties();
            if($for == 'sell'){
                $qb->where('for_sell', 1);
            }elseif($for == 'lease'){
                $for = 'rent';
                $qb->where('for_rent', 1);
            }

            $properties = $qb->paginate(10);
        }elseif($for == 'liked'){
            $properties = $user->likedProperties()->paginate(10);
        }

        return view('frontend.property.index', [
            'properties' => $properties,
            'for' => $for,
        ]);
    }

    public function getSimpleSearch()
    {
        return view('frontend.property.public.simple_search');
    }

    public function getSearch(Request $request)
    {
        $for = $request->input('search.for', 'sell');

        $priceDefaultFrom = 10000000;
        $priceDefaultTo = 100000000000;

        $qb = Property::active();
        AddressHelper::addAddressQueryScope($qb);

        if($request->input('search.for') == 'sell'){
            $qb->where('for_sell', 1);
        }elseif($request->input('search.for') == 'rent'){
            $qb->where('for_rent', 1);
        }

        if($request->has('search.keyword')){
            $qb->where(function($query) use ($request){
                $query
                    ->orWhere('address', 'LIKE', '%'.$request->input('search.keyword').'%')
                    ->orWhere('description', 'LIKE', '%'.$request->input('search.keyword').'%')
                    ->orWhere('property_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                    ->orWhere('province_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                    ->orWhere('city_name', 'LIKE', '%'.$request->input('search.keyword').'%')
                    ->orWhere('subdistrict_name', 'LIKE', '%'.$request->input('search.keyword').'%');
            });
        }

        $citySearch = '';
        if($request->has('search.subdistrict')){
            $qb->where('subdistrict', $request->input('search.subdistrict'));

            $citySearch = AddressHelper::getAddressLabel($request->input('search.subdistrict'), 'subdistrict');
        }

        if($request->has('search.city')){
            $qb->where('city', $request->input('search.city'));

            if(!empty($citySearch)){
                $citySearch .= ', ';
            }
            $citySearch .= AddressHelper::getAddressLabel($request->input('search.city'), 'city');
        }

        if($request->has('search.province')){
            $qb->where('province', $request->input('search.province'));

            if(empty($citySearch)){
                $citySearch = AddressHelper::getAddressLabel($request->input('search.province'), 'province');
            }
        }

        if($request->has('search.rooms')){
            $qb->where('rooms', '>=', $request->input('search.rooms'));
        }

        if($request->has('search.type')){
            $qb->where('property_type_id', $request->input('search.type'));
        }

        if($request->has('search.price')){
            $price = explode(',', $request->input('search.price'));

            if(isset($price[0])){
                $priceDefaultFrom = $price[0];

                if($for == 'sell'){
                    $qb->where('sell_price', '>=', $priceDefaultFrom);
                }elseif($for == 'rent'){
                    $qb->where('rent_price', '>=', $priceDefaultFrom);
                }else{
                    $qb->where(function($query) use ($priceDefaultFrom){
                        $query->where('sell_price', '>=', $priceDefaultFrom)
                            ->orWhere('rent_price', '>=', $priceDefaultFrom);
                    });
                }
            }

            if(isset($price[1])){
                $priceDefaultTo = $price[1];

                if($for == 'sell'){
                    $qb->where('sell_price', '<=', $priceDefaultTo);
                }elseif($for == 'rent'){
                    $qb->where('rent_price', '<=', $priceDefaultTo);
                }else{
                    $qb->where(function($query) use ($priceDefaultTo){
                        $query->where('sell_price', '<=', $priceDefaultTo)
                            ->orWhere('rent_price', '<=', $priceDefaultTo);
                    });
                }
            }
        }

        $resultCount = $qb->count();

        //Sorts
        if($request->has('sort')){
            $sortKeys = explode('_', $request->input('sort'));

            if($sortKeys[0] == 'price'){
                if($for != 'all'){
                    $sortColumn = $for.'_'.$sortKeys[0];
                }
            }else{
                //By exclusive if newest or oldest
                $qb->selectRaw('properties.*, IF(Pac.slug = \'exclusive\', 1, 0) as is_exclusive');
                $qb->leftJoin('package_property AS PP', 'PP.property_id', '=', 'properties.id')
                    ->leftJoin('packages AS Pac', 'PP.package_id', '=', 'Pac.id');

                $qb->orderBy('is_exclusive', 'DESC');

                $sortColumn = 'checkout_at';
            }

            $sortOrder = isset($sortKeys[1])?$sortKeys[1]:'desc';

            $qb->orderBy($sortColumn, $sortOrder);
        }

        $properties = $qb->paginate(16);
        $properties->appends(['sort' => $request->input('sort'), 'search' => $request->input('search')]);

        $sorts = [
            'date_desc' => trans('property.index.sort_by.date_desc'),
            'date_asc' => trans('property.index.sort_by.date_asc'),
        ];
        if($for != 'all') {
            $sorts['price_asc'] = trans('property.index.sort_by.price_asc');
            $sorts['price_desc'] = trans('property.index.sort_by.price_desc');
        }

        return view('frontend.property.public.search', [
            'for' => $for,
            'paginator' => $properties,
            'citySearch' => $citySearch,
            'resultCount' => $resultCount,
            'priceDefaultFrom' => $priceDefaultFrom,
            'priceDefaultTo' => $priceDefaultTo,
            'sorts' => $sorts,
        ]);
    }

    public function getView($for, $id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);
        $province = AddressHelper::getAddressLabel($property->province, 'province');
        $city = AddressHelper::getAddressLabel($property->city, 'city');
        $subdistrict = AddressHelper::getAddressLabel($property->subdistrict, 'subdistrict');

        $liked = ($user)?$user->likesAProperty($property):FALSE;

        return view('frontend.property.public.view', [
            'property' => $property,
            'for' => $for,
            'province' => $province,
            'city' => $city,
            'subdistrict' => $subdistrict,
            'liked' => $liked
        ]);
    }

    public function postAddToCart(Request $request)
    {
        $allowedPackages = implode(',', Package::lists('id')->toArray());

        $rules = [
            'action' => 'required|in:'.$allowedPackages
        ];

        $package = Package::findOrFail($request->input('action'));

        $allowedFeatures = implode(',', $package->features->lists('id')->toArray());

        $features = $request->input('features.'.$package->id, []);
        foreach($features as $idx=>$feature){
            $rules['features.'.$idx] = 'in:'.$allowedFeatures;
        }

        $this->validate($request, $rules);

        $order = ProjectHelper::getGlobalCartOrder(true);

        //Clear Order Item first
        $order->items()->delete();
        foreach($features as $idx=>$feature){
            $featureObj = $package->features->find($feature);

            $orderItem = new OrderItem([
                'item' => $featureObj->id,
                'item_type' => 'feature',
                'quantity' => 1,
                'price' => $featureObj->pivot->price,
                'net_price' => $featureObj->pivot->price,
                'sort_order' => $idx + 1
            ]);

            $order->items()->save($orderItem);
        }

        if(Auth::check()){
            $order->user()->associate(Auth::user());
            $redirectTo = route('frontend.property.create');
        }else{
            $redirectTo = route('frontend.account.register');
        }

        $order->package()->associate($package);
        $order->calculate();
        $order->save();

        return redirect($redirectTo);
    }

    public function getCreate()
    {
        $property = new Property();

        return view('frontend.property.create', [
            'model' => $property
        ]);
    }

    public function postCreate(PropertyFormRequest $request)
    {
        $property = new Property($request->all());
        $property->status = Property::STATUS_DRAFT;
        $property->user()->associate(Auth::user());
        $property->processViewingSchedule($request->all());

        $property->save();

        if($request->input('action') == 'save_information'){
            return redirect()->route('frontend.property.edit', ['id' => $property->id])->with('messages', [trans('property.messages.save_successful')]);
        }elseif($request->input('action') == 'save_continue'){
            return redirect()->route('frontend.property.details', ['id' => $property->id]);
        }
    }

    public function getEdit($id)
    {
        $property = Property::findOrFail($id);

        return view('frontend.property.edit', [
            'model' => $property
        ]);
    }

    public function postEdit(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->fill($request->all());
        $property->processViewingSchedule($request->all());
        $property->save();

        if($request->input('action') == 'save_information'){
            return redirect()->route('frontend.property.edit', ['id' => $property->id])->with('messages', [trans('property.messages.save_successful')]);
        }elseif($request->input('action') == 'save_continue'){
            return redirect()->route('frontend.property.details', ['id' => $property->id]);
        }
    }

    public function getPropertyDetails($id)
    {
        $property = Property::findOrFail($id);

        //dd(old());

        return view('frontend.property.property_detail', [
            'model' => $property
        ]);
    }

    public function postPropertyDetails(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->fill($request->all());
        $property->save();

        if($request->input('action') == 'save_information'){
            return redirect()->route('frontend.property.details', ['id' => $property->id])->with('messages', [trans('property.messages.save_successful')]);
        }elseif($request->input('action') == 'save_continue'){
            return redirect()->route('frontend.property.map', ['id' => $property->id]);
        }
    }

    public function getPropertyMap($id)
    {
        $property = Property::findOrFail($id);
        $defaultLatitude = empty($property->latitude)?config('app.default_latitude'):$property->latitude;
        $defaultLongitude = empty($property->longitude)?config('app.default_longitude'):$property->longitude;

        if(empty($property->latitude) || empty($property->longitude)){
            $mapDefault = true;
        }else{
            $mapDefault = false;
        }

        return view('frontend.property.property_map', [
            'model' => $property,
            'defaultLatitude' => $defaultLatitude,
            'defaultLongitude' => $defaultLongitude,
            'mapDefault' => $mapDefault,
            'mapSearch' => AddressHelper::getAddressLabel($property->subdistrict, 'subdistrict').' ,'.AddressHelper::getAddressLabel($property->city, 'city')
        ]);
    }

    public function postPropertyMap(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);
        $data = $request->all();

        //If not point map, set latitude & longitude to 0
        if($request->input('point_map') != 1){
            $data['latitude'] = NULL;
            $data['longitude'] = NULL;
        }

        $property->fill($data);
        $property->save();

        if($request->input('action') == 'save_information'){
            return redirect()->route('frontend.property.map', ['id' => $property->id])->with('messages', [trans('property.messages.save_successful')]);
        }elseif($request->input('action') == 'save_continue'){
            return redirect()->route('frontend.property.photos', ['id' => $property->id]);
        }
    }

    public function getPropertyPhotos($id)
    {
        $property = Property::findOrFail($id);

        $page = Page::where('identifier', 'presentation-is-key')->first();

        return view('frontend.property.property_photos', [
            'model' => $property,
            'page' => $page
        ]);
    }

    public function postPropertyPhotos(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);

        if($request->input('action') == 'save_information'){
            return redirect()->route('frontend.property.photos', ['id' => $property->id])->with('messages', [trans('property.messages.save_successful')]);
        }elseif($request->input('action') == 'save_continue'){
            return redirect()->route('frontend.property.floorplans', ['id' => $property->id]);
        }
    }

    public function getPropertyFloorplans($id)
    {
        $property = Property::findOrFail($id);

        return view('frontend.property.property_floorplans', [
            'model' => $property
        ]);
    }

    public function postPropertyFloorplans(PropertyFormRequest $request, $id)
    {
        $property = Property::findOrFail($id);

        if($request->input('action') == 'save_continue'){
            return redirect()->route('frontend.property.packages', ['id' => $property->id]);
        }
    }

    public function postPropertyPhotosUpload(Request $request, $id, $type)
    {
        $property = Property::findOrFail($id);

        if($type == 'photo'){
            $photos = $property->photos;
        }elseif($type == 'floorplan'){
            $photos = $property->floorplans;
        }
        $lastPhoto = $photos->last();
        $nextOrder = $lastPhoto?$lastPhoto->sort_order+1:1;

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
            $uploadedPhoto = $property->savePhoto($file, $type, $nextOrder);
            $uploadedPhotos[] = view('frontend.property.upload_photo', ['model' => $property, 'photo' => $uploadedPhoto])->render();
            $nextOrder += 1;
        }

        return response()->json($uploadedPhotos);
    }

    public function postPropertyPhotosDelete(Request $request, $id, $attachment_id)
    {
        $property = Property::findOrFail($id);

        $allowedAttachments = $property->attachments()->lists('id')->all();

        if(!in_array($attachment_id, $allowedAttachments)){
            return redirect()->route('frontend.property.photos', ['id' => $id])->with('messages', [trans('forms.property.messages.attachment_invalid_property')]);
        }

        $propertyAttachment = PropertyAttachment::findOrFail($attachment_id);
        $propertyAttachment->delete();

        if($propertyAttachment->type == 'photo'){
            return redirect()->route('frontend.property.photos', ['id' => $property->id])->with('messages', [trans('property.messages.photo_delete_successful')]);
        }elseif($propertyAttachment->type == 'floorplan'){
            return redirect()->route('frontend.property.floorplans', ['id' => $property->id])->with('messages', [trans('property.messages.floorplan_delete_successful')]);
        }
    }

    public function postPropertyPhotosReorder(Request $request, $id, $type)
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

    public function getPropertyPackages($id)
    {
        $property = Property::findOrFail($id);
        $packageCategories = PackageCategory::all();

        $selectedAddons = [];

        $globalCartOrder = ProjectHelper::getGlobalCartOrder();
        $packageOrder = $property->getCartOrder();
        $order = NULL;

        if(empty($packageOrder)){
            if(!is_null($globalCartOrder)){
                $order = $globalCartOrder;
                $order->property()->associate($property);
                $order->save();

                ProjectHelper::forgetGlobalCartOrder();

                //Redirect to review because package is already selected from homepage
                return redirect()->route('frontend.property.review', ['id' => $property->id]);
            }
        }else{
            $order = $packageOrder;
        }

        if($order){
            $selectedAddons[$order->package->id] = with(new Collection($order->getAddons()))->lists('id')->all();
        }

        return view('frontend.property.property_packages', [
            'model' => $property,
            'packageCategories' => $packageCategories,
            'selectedAddons' => $selectedAddons
        ]);
    }

    public function postPropertyPackages(PropertyFormRequest $request, $id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);
        $package = Package::findOrFail($request->input('action'));

        $features = $request->input('features.'.$package->id, []);

        $propertyCartOrder = $property->getCartOrder();
        if(empty($propertyCartOrder)){
            $order = new Order([
                'status' => Order::STATUS_CART
            ]);
            $order->property()->associate($property);
            $order->user()->associate($user);
            $order->save();
        }else{
            $order = $propertyCartOrder;
        }

        if($package->isExclusive){
            $exclusiveCategory = 'level_'.$package->category->slug;
        }else{
            $exclusiveCategory = FALSE;
        }

        //Clear Order Item first
        $order->items()->delete();

        foreach($features as $idx=>$feature){
            $featureObj = $package->features->find($feature);

            $orderItem = new OrderItem([
                'item' => $featureObj->id,
                'item_type' => 'feature',
                'quantity' => 1,
                'price' => $featureObj->pivot->price,
                'net_price' => $featureObj->pivot->price,
                'sort_order' => $idx + 1
            ]);

            $order->items()->save($orderItem);
        }

        $order->package()->associate($package);
        $order->calculate();
        $order->save();

        return redirect()->route('frontend.property.review', ['id' => $property->id]);
    }

    public function getPropertyOrderReview($id)
    {
        $property = Property::findOrFail($id);
        $order = $property->getCartOrder();

        return view('frontend.property.property_order_review', [
            'model' => $property,
            'order' => $order
        ]);
    }

    public function postPropertyOrderReview(PropertyFormRequest $request, $id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);

        if($request->input('action') == 'purchase'){
            $order = $property->getCartOrder();
            $payment_method = Payment::getPaymentMethods($request->input('payment_method'), TRUE);

            if($order->package->category->slug == 'sell'){
                $attachedPackages = $property->packages()->leftJoin('package_categories AS PC', 'PC.ID', '=', 'package_category_id')->where('PC.slug', 'sell')->get();
            }elseif($order->package->category->slug == 'rent'){
                $attachedPackages = $property->packages()->leftJoin('package_categories AS PC', 'PC.ID', '=', 'package_category_id')->where('PC.slug', 'rent')->get();
            }

            if($attachedPackages->count() > 0){
                $property->packages()->detach($attachedPackages->lists('id')->all());
            }

            $addons = [];
            foreach($order->items as $item){
                $addons[] = $item->getItem()->id;
            }

            $property->packages()->attach([
                $order->package->id => [
                    'addons' => implode('|', $addons)
                ]
            ]);

            $payment = new Payment([
                'total_amount' => $order->total_amount,
                'payment_method' => $payment_method['machine_name'],
                'status' => Payment::STATUS_UNPAID
            ]);
            $payment->user()->associate($user);
            $payment->order()->associate($order);
            $payment->save();

            $order->status = Order::STATUS_PENDING;
            $order->generateOrderNumber();
            $order->save();

            switch($payment_method['machine_name']){
                case Payment::METHOD_DOKU_CREDIT_CARD:
                    return redirect()->route('frontend.property.payment', ['id' => $property->id]);
                    break;
                default:
                    return redirect()->route('frontend.property.success', ['id' => $property->id]);
                    break;
            }
        }elseif($request->input('action') == 'change_package'){
            return redirect()->route('frontend.property.packages', ['id' => $property->id]);
        }
    }

    public function getPropertyPayment($id)
    {
        $property = Property::findOrFail($id);
        $order = $property->order;
        $existingPayments = $order->payments;

        if($existingPayments->count() < 1){
            return redirect()->route('frontend.property.review', ['id' => $property->id]);
        }

        $payment_method = $existingPayments->first()->payment_method;

        switch($payment_method){
            case Payment::METHOD_DOKU_CREDIT_CARD:
                $payment = $existingPayments->first();

                //Building the required external form fields
                $user = Auth::user();
                $user->load(['profile']);
                $shared_key = config('myshortcart.shared_key');
                $msc_transaction_id = config('myshortcart.prefix').'_'.$payment->id;

                foreach($order->items as $item){
                    $items[] = [
                        'name' => ($item->item_type=='feature')?trans('property.package.feature.'.$item->getItem()->code):$item->item,
                        'price' => $item->net_price,
                        'quantity' => $item->quantity
                    ];
                }

                $orderData = [
                    'ip_address' => \Illuminate\Support\Facades\Request::ip(),
                    'transaction_id' => $payment->id,
                    'msc_transaction_id' => $msc_transaction_id,
                    'amount' => $payment->total_amount,
                    'basket' => MyShortCart::formatBasket($items),
                    'words' => sha1(trim($payment->total_amount).trim($shared_key).trim($msc_transaction_id)),
                    'url' => route('frontend.property.payment', ['id' => $property->id]),
                    'customer_name' => $user->profile->first_name.' '.$user->profile->last_name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->profile->home_phone_number,
                    'customer_work_phone' => $user->profile->mobile_phone_number,
                    'customer_mobile_phone' => $user->profile->mobile_phone_number,
                    'customer_address' => trim(str_replace(["\r","\n"],' ',$user->profile->address)),
                    'customer_postal_code' => trim($user->profile->postal_code),
                    'customer_city' => trim(AddressHelper::getAddressLabel($user->profile->city, 'city')),
                    'customer_state' => trim(AddressHelper::getAddressLabel($user->profile->province, 'province')),
                    'customer_country' => 360,
                    'customer_birthday' => '',
                ];

                $orderData += [
                    'shipping_address' => $orderData['customer_address'],
                    'shipping_postal_code' => $orderData['customer_postal_code'],
                    'shipping_city' => $orderData['customer_city'],
                    'shipping_state' => $orderData['customer_state'],
                    'shipping_country' => $orderData['customer_country'],
                ];

                MyShortCart::saveRequestTransaction($orderData);
                return MyShortCart::renderForm($orderData);
            break;
            default:
                return redirect()->route('frontend.property.success', ['id' => $property->id]);
                break;
        }
    }

    public function getPropertySuccess($id)
    {
        $property = Property::findOrFail($id);

        $order = $property->order;

        if(!$order || in_array($order->status, [Order::STATUS_CART])){
            return redirect()->route('frontend.property.packages', ['id' => $property->id]);
        }

        if($property->status == Property::STATUS_DRAFT){
            $property->update([
                'status' => Property::STATUS_ACTIVE,
                'checkout_at' => Carbon::now()
            ]);
        }

        if($order->total_amount <= 0){
            $order->forceDelete();
        }

        return view('frontend.property.property_success', [
            'model' => $property
        ]);
    }

    public function getDraftEdit($id)
    {
        $property = Property::findOrFail($id);
        $property->update([
            'status' => Property::STATUS_DRAFT
        ]);

        return redirect()->route('frontend.property.edit', ['id' => $id]);
    }

    public function getLikeProperty($id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);

        if($property->user->id == $user->id){
            return redirect()->back()->with('messages', [trans('property.like.own_property')]);
        }

        $user->likeProperty($property);

        return redirect()->back()->with('messages', [trans('property.like.like_message', ['property_name' => $property->property_name])]);
    }

    public function getUnlikeProperty($id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);

        $user->unlikeProperty($property);

        return redirect()->back()->with('messages', [trans('property.like.unlike_message', ['property_name' => $property->property_name])]);
    }

    public function getToggleLikeProperty($id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);

        if($property->isLikedBy($user)){
            $user->unlikeProperty($property);
            $liked = false;
        }else{
            $user->likeProperty($property);
            $liked = true;
        }

        return '<li class="'.($liked?'checked':'').'"><a data-toggle="tooltip" title="'.($liked?trans('property.buttons.unlike'):trans('property.buttons.like')).'" href="'.route('frontend.property.toggle_like', ['id' => $property->id]).'" class="toggle-like"><i class="fa '.($liked?'fa-heart':'fa-heart-o').'"></i></a></li>';
    }

    public function getScheduleViewing($id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);

        $viewOnWeekends = FALSE;
        $viewOnWeekdays = FALSE;
        $enabledDays = [];

        if($property->for_sell){
            if(strpos($property->sell_viewing_schedule, 'weekend') !== FALSE){
                $viewOnWeekends = TRUE;
            }

            if(strpos($property->sell_viewing_schedule, 'weekdays') !== FALSE){
                $viewOnWeekdays = TRUE;
            }
        }

        if($property->for_rent){
            if(strpos($property->rent_viewing_schedule, 'weekend') !== FALSE){
                $viewOnWeekends = TRUE;
            }

            if(strpos($property->rent_viewing_schedule, 'weekdays') !== FALSE){
                $viewOnWeekdays = TRUE;
            }
        }

        if($viewOnWeekdays){
            $enabledDays += [1,2,3,4,5];
        }

        if($viewOnWeekends){
            $enabledDays += [0,6];
        }

        $disabledDays = array_diff([0,1,2,3,4,5,6], $enabledDays);

        $viewingSchedule = ViewingSchedule::where('user_id', $user->id)->where('property_id', $property->id)->first();

        $defaultDate = $viewingSchedule?$viewingSchedule->viewing_from->toIso8601String():Carbon::tomorrow()->format('Y-m-d');
        $defaultTime = $viewingSchedule?str_replace(':', '_', $viewingSchedule->viewing_from->format('H:i')):NULL;

        return view('frontend.property.schedule_viewings.mini_form', [
            'user' => $user,
            'property' => $property,
            'disabledDays' => $disabledDays,
            'defaultDate' => $defaultDate,
            'defaultTime' => $defaultTime,
            'viewingSchedule' => $viewingSchedule,
            'viewOnWeekdays' => $viewOnWeekdays,
            'viewOnWeekends' => $viewOnWeekends,
        ]);
    }

    public function postScheduleViewing(Request $request, $id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);
        $property->load('agent');

        $allowedTime = array_keys(Property::getViewingTimeLabel());
        $rules = [
            'viewing_date' => 'required|date_format:Y-m-d',
            'viewing_time' => [
                'required',
                'in:'.implode(',', $allowedTime)
            ]
        ];

        $this->validate($request, $rules);

        $viewingTime = str_replace('_', ':', $request->input('viewing_time'));

        $viewingFrom = \DateTime::createFromFormat('Y-m-d H:i', $request->input('viewing_date').' '.$viewingTime);
        $viewingTo = clone $viewingFrom;
        $viewingTo->modify('+2 hours');

        $viewingSchedule = ViewingSchedule::where('user_id', $user->id)->where('property_id', $property->id)->first();

        if($property->agent){
            $agent = $property->agent;
        }else{
            $agent = ProjectHelper::getDefaultAgent();
        }

        if(!$viewingSchedule){
            $viewingSchedule = new ViewingSchedule();
            $viewingSchedule->user()->associate($user);
            $viewingSchedule->property()->associate($property);

            if($agent){
                $viewingSchedule->agent()->associate($agent);
            }

            $reschedule = FALSE;
        }else{
            $reschedule = TRUE;
        }

        $viewingSchedule->fill([
            'viewing_from' => $viewingFrom->format('Y-m-d H:i:s'),
            'viewing_until' => $viewingTo->format('Y-m-d H:i:s')
        ]);

        $viewingSchedule->status = ViewingSchedule::STATUS_PENDING;
        $viewingSchedule->save();

        $conversation = $user->getPropertyConversation($property);
        if(!$conversation){
            $user->createPropertyConversation($property, $agent);
        }

        if($reschedule){
            $message = trans('property.schedule_viewing.reschedule_success_message');
        }else{
            $message = trans('property.schedule_viewing.success_message');
        }

        return redirect()->back()->with('messages', [$message]);
    }

    public function getAddToComparison($id)
    {
        $property = Property::findOrFail($id);

        PropertyCompareHelper::addToComparison($property);

        return redirect()->back()->with('messages', [trans('property.property_comparison.add_message', ['name' => $property->property_name])]);
    }

    public function getRemoveFromComparison($id)
    {
        $property = Property::findOrFail($id);

        PropertyCompareHelper::removeFromComparison($property);

        return redirect()->back()->with('messages', [trans('property.property_comparison.remove_message', ['name' => $property->property_name])]);
    }

    public function getCompare()
    {
        $properties = PropertyCompareHelper::getCurrentList();

        return view('frontend.property.compare', [
            'properties' => $properties
        ]);
    }
}