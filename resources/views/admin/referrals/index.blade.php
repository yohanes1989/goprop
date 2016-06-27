@extends('admin.layouts.master')

@section('title', 'Properties')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.referrals.index') }}"><i class="fa fa-bell-o"></i> My Referrals</a></li>
@endsection

@section('content')
    <?php
    $isAdmin = \Illuminate\Support\Facades\Auth::user()->is('administrator');
    ?>
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.referrals.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Referral Information</a>
                </div>
            </div>

            <h4>Properties</h4>
        </div>

        @if($isAdmin)
        {!! Form::open(['class' => 'form-horizontal form-grid', 'method' => 'GET']) !!}
        <div class="form-group">
            <div class="col-sm-6 col-md-3">
                {!! Form::text('search[keyword]', Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => 'Keyword (Name, Email, Location, Phone)', 'id' => 'search-keyword']) !!}
            </div>
            <div class="col-xs-6 col-md-2">
                {!! Form::select('search[agent]', $agentOptions, [Request::input('search.agent')], ['class' => 'form-control select-chosen', 'placeholder' => 'Referral Agent', 'id' => 'search-agentReferral']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[status]', $statusOptions, [Request::input('search.status', 'all')], ['class' => 'form-control select-chosen', 'id' => 'search-status']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[followed_up]', $followedUpOptions, [Request::input('search.followed_up', 'all')], ['class' => 'form-control select-chosen', 'id' => 'search-followed-up']) !!}
            </div>
            <div class="col-sm-6 col-md-1">
                {!! Form::button('Filter', ['type' => 'submit', 'class' => 'btn btn-info']) !!}
            </div>
        </div>
        {!! Form::close() !!}
        @else
        {!! Form::open(['class' => 'form-horizontal form-grid', 'method' => 'GET']) !!}
        <div class="form-group">
            <div class="col-sm-6 col-md-3">
                {!! Form::text('search[keyword]', Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => 'Keyword (Name, Email, Location, Phone)', 'id' => 'search-keyword']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[status]', $statusOptions, [Request::input('search.status', 'all')], ['class' => 'form-control select-chosen', 'id' => 'search-status']) !!}
            </div>
            <div class="col-sm-6 col-md-2">
                {!! Form::select('search[followed_up]', $followedUpOptions, [Request::input('search.followed_up', 'all')], ['class' => 'form-control select-chosen', 'id' => 'search-followed-up']) !!}
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
                        @if($isAdmin)
                        <th>Referral Agent</th>
                        @endif
                        <th>Type</th>
                        <th>Name</th>
                        <th>Contact Number/Email</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Followed Up</th>
                        <th>Referred On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($referrals as $idx=>$referral)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($referrals->currentPage() - 1) * $referrals->perPage()) }}</td>
                        @if($isAdmin)
                        <td>{{ $referral->user->profile->singleName }}</td>
                        @endif
                        <td>{{ $referral->type->name }}</td>
                        <td>{{ $referral->name }}</td>
                        <td>{{ $referral->contact_number.(!empty($referral->other_contact_number)?', '.$referral->other_contact_number:'') }}<br/>{{ $referral->email }}</td>
                        <td>{!! nl2br($referral->address).'<br/>'.$referral->province_name.', '.$referral->city_name .', '. $referral->subdistrict_name!!}<br/>
                            {{ $referral->postal_code }}
                        </td>
                        <td>{{ \GoProp\Models\ReferralInformation::getStatusOptions($referral->status) }}</td>
                        <td><i class="fa fa-{{ $referral->followed_up?'check':'remove' }}"></i></td>
                        <td>{{ $referral->created_at?$referral->created_at->format('d M Y H:i'):null }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if(!$referral->followed_up || $isAdmin)
                                <a href="{{ route('admin.referrals.edit', ['id' => $referral->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                {!! Form::open(['route' => ['admin.referrals.delete', 'id' => $referral->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $referrals->render() !!}
    </div>
@endsection