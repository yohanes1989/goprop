@extends('admin.layouts.master')

@section('title', 'Members')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.member.index') }}"><i class="fa fa-user"></i> Members</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.member.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Member</a>
                </div>
            </div>

            <h4>Members</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($members as $idx=>$member)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($members->currentPage() - 1) * $members->perPage()) }}</td>
                        <td>{{ $member->username }}</td>
                        <td>{{ $member->profile->singleName }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->profile->mobile_phone_number }}</td>
                        <td>
                            {{ $member->getStatusLabel($member->status) }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.member.edit', ['id' => $member->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                {!! Form::open(['route' => ['admin.member.delete', 'id' => $member->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $members->render() !!}
    </div>
@endsection