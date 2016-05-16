@extends('admin.layouts.master')

@section('title', 'Properties')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="gi gi-home"></i> Properties</a></li>
@endsection

@section('content')
    <?php
    $isAdmin = \Illuminate\Support\Facades\Auth::user()->is('administrator');
    $canAssign = $isAdmin;
    ?>
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.property.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Property</a>
                </div>
            </div>

            <h4>Properties</h4>
        </div>

        @if($isAdmin)
        
        @else
        {!! Form::open(['class' => 'form-horizontal form-grid', 'method' => 'GET']) !!}
        <div class="form-group">
            <div class="col-sm-6 col-md-3">
                {!! Form::text('search[keyword]', Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => 'Keyword (Name, Location, Description)', 'id' => 'search-keyword']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[for]', $forOptions, [Request::input('search.for')], ['class' => 'form-control select-chosen', 'id' => 'search-for']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[owner]', $ownerOptions, [Request::input('search.owner')], ['class' => 'form-control select-chosen', 'placeholder' => 'Owner', 'id' => 'search-owner']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[status]', $statusOptions, [Request::input('search.status')], ['class' => 'form-control select-chosen', 'id' => 'search-status']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::text('search[upload_date]', Request::input('search.upload_date'), ['class' => 'form-control input-datepicker-close', 'data-date-format' => 'dd-mm-yyyy', 'placeholder' => 'Upload Date', 'id' => 'search-upload-date']) !!}
            </div>
            <div class="col-sm-6 col-md-1">
                {!! Form::button('Filter', ['type' => 'submit', 'class' => 'btn btn-info']) !!}
            </div>
        </div>
        {!! Form::close() !!}
        @endif

        <?php $allPortals = \GoProp\Models\PropertyPortal::getAllPortals(); ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>For</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th>Upload Date</th>
                        @if($isAdmin)
                        <th>Portals</th>
                        <th>Listing</th>
                        <th>Selling</th>
                        @endif
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($properties as $idx=>$property)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($properties->currentPage() - 1) * $properties->perPage()) }}</td>
                        <td>{{ isset($property->listing_code)?$property->listing_code:'' }}</td>
                        <td>{{ $property->property_name }}</td>
                        <td>{{ $property->subdistrict_name.', '. $property->city_name }}</td>
                        <td>
                            @if($property->for_rent == 1)<div>For Rent</div>@endif
                            @if($property->for_sell == 1)<div>For Sell</div>@endif
                        </td>
                        <td>{{ $property->user?$property->user->profile->singleName:'Unassigned' }}
                            <br/>{{ $property->user?$property->user->profile->mobile_phone_number:'' }}</td>
                        <td>
                            {{ \GoProp\Models\Property::getStatusLabel($property->status) }}
                        </td>
                        <td>{{ $property->checkout_at?$property->checkout_at->format('d M Y H:i'):null }}</td>
                        @if($isAdmin)
                        <td>
                            @foreach($allPortals as $portal)
                                <div>{!! '<i class="fa fa-'.(in_array($portal->id, $property->propertyPortals->pluck('id')->all())?'check':'times').'"></i> '.$portal->name !!}</div>
                            @endforeach
                        </td>
                        <td>
                            <p>Agent: {{ $property->agentList?$property->agentList->profile->singleName:'Unassigned' }}</p>
                            <p>Referral: {{ $property->referralList?$property->referralList->profile->singleName:'Unassigned' }}</p>
                        </td>
                        <td>
                            <p>Agent: {{ $property->agentSell?$property->agentSell->profile->singleName:'Unassigned' }}</p>
                            <p>Referral: {{ $property->referralSell?$property->referralSell->profile->singleName:'Unassigned' }}</p>
                        </td>
                        @endif
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.property.view', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.property.edit', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('admin.property.media', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Media"><i class="gi gi-picture"></i></a>
                                @if(!$property->trashed())
                                @if($canAssign)
                                    <a href="{{ route('admin.property.assign_to_agent', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="open-modal btn btn-default" data-original-title="Assign To Agent"><i class="fa fa-users"></i></a>
                                @endif
                                @if($isAdmin || $property->isOwner(\Illuminate\Support\Facades\Auth::user()))
                                {!! Form::open(['route' => ['admin.property.delete', 'id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                                @endif
                                @endif

                                @if($isAdmin && $property->trashed())
                                    {!! Form::open(['route' => ['admin.property.restore', 'id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Restore"><i class="fa fa-undo"></i></button>{!! Form::close() !!}
                                    {!! Form::open(['route' => ['admin.property.delete.force', 'id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete from Trash"><i class="fa fa-trash"></i></button>{!! Form::close() !!}
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $properties->render() !!}
    </div>
@endsection