@extends('admin.layouts.master')

@section('title', 'Edit Member ('.$member->profile->singleName.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.member.index') }}"><i class="fa fa-user"></i> Members</a></li>
    <li>Edit Member ({{ $member->profile->singleName }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Member ({{ $member->profile->singleName }})</h4>
        </div>

        {!! Form::model($member,array('route' => ['admin.member.update', 'id' => $member->id], 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.members.create_form')
        {!! Form::close() !!}
    </div>
@endsection