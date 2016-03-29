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

        {!! Form::open(['class' => 'form-horizontal form-grid', 'method' => 'GET']) !!}
            <div class="form-group">
                <div class="col-sm-6 col-md-3">
                    {!! Form::text('search[keyword]', Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => 'Keyword (Name, Location, Description)', 'id' => 'search-keyword']) !!}
                </div>
                <div class="col-sm-6 col-md-1">
                    {!! Form::select('search[for]', $forOptions, [Request::input('search.for')], ['class' => 'form-control select-chosen', 'id' => 'search-for']) !!}
                </div>
                <div class="col-sm-6 col-md-2">
                    {!! Form::text('search[owner]', Request::input('search.owner'), ['class' => 'form-control', 'placeholder' => 'Owner', 'id' => 'search-owner', 'data-autocomplete' => route('admin.member.find.auto_complete', ['roles' => ['agent', 'authenticated_user']])]) !!}
                </div>
                <div class="col-sm-6 col-md-2">
                    {!! Form::select('search[agent]', $agentOptions, [Request::input('search.agent')], ['class' => 'form-control select-chosen', 'placeholder' => 'Agent', 'id' => 'search-agent']) !!}
                </div>
                <div class="col-sm-6 col-md-1">
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

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>For</th>
                        <th>Owner</th>
                        <th>Agent</th>
                        <th>Status</th>
                        <th>Upload Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($properties as $idx=>$property)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($properties->currentPage() - 1) * $properties->perPage()) }}</td>
                        <td>{{ $property->property_name }}</td>
                        <td>{{ $property->subdistrict_name.', '. $property->city_name }}</td>
                        <td>
                            @if($property->for_rent == 1)<div>For Rent</div>@endif
                            @if($property->for_sell == 1)<div>For Sell</div>@endif
                        </td>
                        <td>{{ $property->user->profile->singleName }}
                            <br/>{{ $property->user->profile->mobile_phone_number }}</td>
                        <td>
                            {{ $property->agent?$property->agent->profile->singleName:'Unassigned' }}
                        </td>
                        <td>
                            {{ \GoProp\Models\Property::getStatusLabel($property->status) }}
                        </td>
                        <td>{{ $property->checkout_at?$property->checkout_at->format('d M Y H:i'):null }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if($canAssign)
                                    <a href="{{ route('admin.property.assign_to_agent', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="open-modal btn btn-default" data-original-title="Assign To Agent"><i class="fa fa-users"></i></a>
                                @endif
                                <a href="{{ route('admin.property.edit', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('admin.property.media', ['id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Media"><i class="gi gi-picture"></i></a>
                                {!! Form::open(['route' => ['admin.property.delete', 'id' => $property->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
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