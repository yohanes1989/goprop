@extends('admin.layouts.master')

@section('title', 'Customer Inquiry')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.customer_inquiry.index') }}"><i class="fa fa-comments"></i> Viewing Schedules</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Customer Inquiry</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>User</th>
                    <th>Property</th>
                    <th>Agent</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($conversations as $idx=>$conversation)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($conversations->currentPage() - 1) * $conversations->perPage()) }}</td>
                        <td><strong>{{ $conversation->sender->profile->singleName }}</strong><br/>
                            {{ $conversation->sender->username }}<br/>
                            {{ $conversation->sender->email }}
                        </td>
                        <td>
                            <strong>{{ $conversation->referenced->property_name }}</strong><br/>
                            {{ \GoProp\Facades\AddressHelper::getAddressLabel($conversation->referenced->city, 'city') }}, {{ \GoProp\Facades\AddressHelper::getAddressLabel($conversation->referenced->subdistrict, 'subdistrict') }}<br/>
                            {{ \GoProp\Facades\AddressHelper::getAddressLabel($conversation->referenced->province, 'province') }}
                        </td>
                        <td>
                            @if($conversation->recipient)
                                {{ $conversation->recipient->profile->singleName }}
                            @else
                                <div class="label label-danger">Unassigned</div>
                            @endif
                        </td>
                        <td>{{ $conversation->created_at->format('d M Y H:i') }}</td>
                        <td>
                            {{ \GoProp\Facades\AgentHelper::inquiryStatusByMessage($conversation->lastReply) }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.customer_inquiry.conversation', ['id' => $conversation->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Open Conversation"><i class="fa fa-comment"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {!! $conversations->render() !!}
    </div>
@endsection