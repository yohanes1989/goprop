@extends('admin.layouts.master')

@section('title', 'Viewing Schedules')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('agent.viewing_schedule.index') }}"><i class="fa fa-calendar"></i> My Viewing Schedules</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>My Viewing Schedules</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>User</th>
                        <th>Property</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($viewingSchedules as $idx=>$viewingSchedule)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($viewingSchedules->currentPage() - 1) * $viewingSchedules->perPage()) }}</td>
                        <td><strong>{{ $viewingSchedule->user->profile->singleName }}</strong><br/>
                            {{ $viewingSchedule->user->username }}<br/>
                            {{ $viewingSchedule->user->email }}<br/>
                            {{ $viewingSchedule->user->profile->mobile_phone_number }}
                        </td>
                        <td>
                            <strong>{{ $viewingSchedule->property->property_name }}</strong><br/>
                            {{ \GoProp\Facades\AddressHelper::getAddressLabel($viewingSchedule->property->city, 'city') }}, {{ \GoProp\Facades\AddressHelper::getAddressLabel($viewingSchedule->property->subdistrict, 'subdistrict') }}<br/>
                            {{ \GoProp\Facades\AddressHelper::getAddressLabel($viewingSchedule->property->province, 'province') }}
                        </td>
                        <td>{{ $viewingSchedule->viewing_from->format('d M Y H:i').' - '.$viewingSchedule->viewing_until->format('H:i') }}</td>
                        <td>
                            {{ \GoProp\Models\ViewingSchedule::getStatusLabel($viewingSchedule->status) }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('agent.viewing_schedule.quick_edit', ['id' => $viewingSchedule->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="open-modal btn btn-default" data-original-title="Quick Edit"><i class="fa fa-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $viewingSchedules->render() !!}
    </div>
@endsection