@extends('admin.layouts.master')

@section('title', 'Areas')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.location.area.index') }}"><i class="gi gi-google_maps"></i> Areas</a></li>
@endsection

@section('content')
    {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
        <div class="col-sm-3">
            {!! Form::select('search[province]', $provinces, [Request::input('search.province')], ['class'=>'form-control select-chosen']) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::select('search[city]', $cities, [Request::input('search.city')], ['class'=>'form-control select-chosen']) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::text('search[subdistrict]', Request::input('search.subdistrict'), ['placeholder' => 'Area', 'class'=>'form-control']) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::submit('Search', ['class' => 'btn btn-info']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.location.area.create', ['backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Area</a>
                </div>
            </div>

            <h4>Areas</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Province</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($areas as $idx=>$area)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($areas->currentPage() - 1) * $areas->perPage()) }}</td>
                        <td>{{ $area->subdistrict_name }}</td>
                        <td>{{ $area->city_name }}</td>
                        <td>{{ $area->province_name }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.location.area.edit', ['id' => $area->subdistrict_id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                {!! Form::open(['route' => ['admin.location.area.delete', 'id' => $area->subdistrict_id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $areas->render() !!}
    </div>
@endsection