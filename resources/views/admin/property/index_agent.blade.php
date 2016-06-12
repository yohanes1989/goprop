@extends('admin.layouts.master')

@section('title', 'Properties')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index.agent', ['type' => 'referral-listing']) }}"><i class="gi gi-home"></i> {{ $title }}</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>{{ $title }}</h4>
        </div>

        {!! Form::open(['class' => 'form-horizontal form-grid', 'method' => 'GET']) !!}
        <div class="form-group">
            <div class="col-sm-6 col-md-3">
                {!! Form::text('search[keyword]', Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => 'Keyword (Name, Location, Description)', 'id' => 'search-keyword']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[for]', $forOptions, [Request::input('search.for')], ['class' => 'form-control select-chosen', 'id' => 'search-for']) !!}
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
                            {{ $property->status?\GoProp\Models\Property::getStatusLabel($property->status):'' }}
                        </td>
                        <td>{{ $property->checkout_at?$property->checkout_at->format('d M Y H:i'):null }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('frontend.property.view', ['id' => $property->id]) }}" target="_blank" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
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