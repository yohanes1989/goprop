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
        {!! Form::open(['class' => 'form-horizontal form-grid', 'method' => 'GET']) !!}
            <div class="form-group">
                <div class="col-xs-6 col-md-4">
                    {!! Form::text('search[keyword]', Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => 'Keyword (Name, Location, Description)', 'id' => 'search-keyword']) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::select('search[for]', $forOptions, [Request::input('search.for')], ['class' => 'form-control select-chosen', 'id' => 'search-for']) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::text('search[owner]', Request::input('search.owner'), ['class' => 'form-control', 'placeholder' => 'Owner', 'id' => 'search-owner', 'data-autocomplete' => route('admin.member.find.auto_complete', ['roles' => ['agent', 'authenticated_user']])]) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::select('search[status]', $statusOptions, [Request::input('search.status')], ['class' => 'form-control select-chosen', 'id' => 'search-status']) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::text('search[upload_date]', Request::input('search.upload_date'), ['class' => 'form-control input-datepicker-close', 'data-date-format' => 'dd-mm-yyyy', 'placeholder' => 'Upload Date', 'id' => 'search-upload-date']) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::select('search[agentList]', $agentOptions, [Request::input('search.agentList')], ['class' => 'form-control select-chosen', 'placeholder' => 'Agent List', 'id' => 'search-agentList']) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::select('search[referralList]', $agentOptions, [Request::input('search.referralList')], ['class' => 'form-control select-chosen', 'placeholder' => 'Referral List', 'id' => 'search-referralList']) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::select('search[agentSell]', $agentOptions, [Request::input('search.agentSell')], ['class' => 'form-control select-chosen', 'placeholder' => 'Agent Sell', 'id' => 'search-agentSell']) !!}
                </div>
                <div class="col-xs-6 col-md-2">
                    {!! Form::select('search[referralSell]', $agentOptions, [Request::input('search.referralSell')], ['class' => 'form-control select-chosen', 'placeholder' => 'Referral Sell', 'id' => 'search-referralSell']) !!}
                </div>
                <div class="col-xs-12 col-md-12">
                    {!! Form::button('Filter', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                    {!! Form::submit('Export to XLS', ['name' => 'export_xls', 'type' => 'submit', 'class' => 'btn btn-info']) !!}
                </div>
            </div>
        {!! Form::close() !!}
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
                        <th>Listing Agent</th>
                        <th>Listing Referral</th>
                        <th>Selling Agent</th>
                        <th>Selling Referral</th>
                        @endif
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($properties as $idx=>$property)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($properties->currentPage() - 1) * $properties->perPage()) }}</td>
                        <td>{{ $property->listing_code }}</td>
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
                        <td>{{ $property->checkout_at?$property->checkout_at->format('d M Y H:i'):null }}</td>
                        @if($isAdmin)
                        <td>
                            {{ $property->agentList?$property->agentList->profile->singleName:'Unassigned' }}
                        </td>
                        <td>
                            {{ $property->referralList?$property->referralList->profile->singleName:'Unassigned' }}
                        </td>
                        <td>
                            {{ $property->agentSell?$property->agentSell->profile->singleName:'Unassigned' }}
                        </td>
                        <td>
                            {{ $property->referralSell?$property->referralSell->profile->singleName:'Unassigned' }}
                        </td>
                        @endif
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