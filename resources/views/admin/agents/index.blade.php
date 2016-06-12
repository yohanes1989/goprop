@extends('admin.layouts.master')

@section('title', 'Agents')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.agent.index') }}"><i class="fa fa-users"></i> Agents</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.agent.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Agent</a>
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
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($agents as $idx=>$agent)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($agents->currentPage() - 1) * $agents->perPage()) }}</td>
                        <!--<td>{{ $agent->username }}</td>-->
                        <td>{{ $agent->profile->singleName }}<br/>{{ $agent->profile->occupation }}</td>
                        <td>{{ $agent->email }}</td>
                        <td>{{ $agent->profile->mobile_phone_number }}</td>
                        <td>
                            {{ $agent->getStatusLabel($agent->status) }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.agent.edit', ['id' => $agent->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                {!! Form::open(['route' => ['admin.agent.delete', 'id' => $agent->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $agents->render() !!}
    </div>
@endsection