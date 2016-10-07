@extends('admin.layouts.master')

@section('title', 'Users')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.user.index') }}"><i class="fa fa-users"></i> Users</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>

            <h4>Agents</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <!--<th>Username</th>-->
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Managed Province</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $idx=>$user)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($users->currentPage() - 1) * $users->perPage()) }}</td>
                        <!--<td>{{ $user->username }}</td>-->
                        <td>
                            @if($user->profile)
                            {{ $user->profile->singleName }}<br/>{{ $user->profile->occupation }}
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->profile?$user->profile->mobile_phone_number:'' }}</td>
                        <td>{{ $user->profile?AddressHelper::getAddressLabel($user->profile->province, 'province'):'' }}</td>
                        <td>
                            {{ $user->getStatusLabel($user->status) }}
                        </td>
                        <td>
                            {{ $user->roles->get(0)->name }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.user.edit', ['id' => $user->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                {!! Form::open(['route' => ['admin.user.delete', 'id' => $user->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $users->render() !!}
    </div>
@endsection