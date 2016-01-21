@extends('admin.layouts.master')

@section('title', 'Properties')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="gi gi-home"></i> Properties</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.property.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Property</a>
                </div>
            </div>

            <h4>Properties</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>For</th>
                        <th>Username</th>
                        <th>Status</th>
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
                            {{ \GoProp\Models\Property::getStatusLabel($property->status) }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
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