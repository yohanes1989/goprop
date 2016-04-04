@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="user-content-begin">
        <div class="row">
            <div class="col-sm-12 col-md-10 register-form-wrapper">
                <header class="header-area">
                    <h3 class="entry-title">{{ trans('property.inbox.title') }}</h3>
                    @if($property && !$conversation)
                    <div class="entry-button"><a href="{{ route('frontend.account.inbox', ['property_id' => $property->id, 'new' => TRUE]) }}"><img src="{{ asset('assets/frontend/images/icon-inbox-new.png') }}" /> Add Messages</a></div>
                    @endif
                </header>
                <div class="entry-content">
                    <div class="inbox-content-wrapper">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label('your_properties', trans('property.inbox.your_properties')) !!}
                                <select id="your_properties" class="form-control select-go-to">
                                    <option value="{{ route('frontend.account.inbox') }}">{{ trans('forms.please_select') }}</option>
                                    @foreach($my_properties as $my_property)
                                        <option {{ ($property && $my_property->id==$property->id)?'selected':'' }} value="{{ route('frontend.account.inbox', ['property_id' => $my_property->id]) }}">{{ $my_property->property_name.' ('.$my_property->city_name.', '.$my_property->subdistrict_name.')' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('properties_interested', trans('property.inbox.properties_interested')) !!}
                                <select id="properties_interested" class="form-control select-go-to">
                                    <option value="{{ route('frontend.account.inbox') }}">{{ trans('forms.please_select') }}</option>
                                    @foreach($interested_properties as $interested_property)
                                        <option {{ ($property && $interested_property->id==$property->id)?'selected':'' }} value="{{ route('frontend.account.inbox', ['property_id' => $interested_property->id]) }}">{{ $interested_property->property_name.' ('.$interested_property->city_name.', '.$interested_property->subdistrict_name.')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="chat-content-wrapper">
                            @if($property)
                                @if($conversation || \Illuminate\Support\Facades\Request::get('new'))
                                <div class="chat-inner-wrapper">
                                    <div class="chat-top">
                                        <div class="col-xs-12 user-info">
                                            <div class="row">
                                                <div class="icon">
                                                    <img src="{{ asset('assets/frontend/images/user-icon.png') }}" alt="">
                                                </div>
                                                <header class="entry-header">
                                                    @if(!$conversation || !$conversation->recipient)
                                                        <h5 class="entry-title">GoProp Agent</h5>
                                                    @else
                                                        <h5 class="entry-title">{{ $conversation->recipient->profile->singleName }}</h5>
                                                        <p class="entry-desc">
                                                            <a href="tel:{{ $conversation->recipient->profile->mobile_phone_number }}"><i class="fa fa-mobile"></i> {{ $conversation->recipient->profile->mobile_phone_number }}</a>
                                                        </p>
                                                    @endif
                                                </header>
                                            </div>
                                        </div>

                                        @if($confirmedViewingSchedule)
                                        <div class="col-xs-7 button-area">
                                            <h6 class="entry-date">
                                                <div class="btn btn-yellow"><img src="{{ asset('assets/frontend/images/icon-user-viewings.png') }}" /> <span>{{ trans('property.viewings.scheduled_label') }}:</span> {{ $confirmedViewingSchedule->viewing_from->format('D, d M Y  H:i') }}</div>
                                            </h6>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="chat-middle">
                                        <div class="chat-middle-outer">
                                            <div class="chat-middle-content" id="chatLineHolder">
                                                @if($conversation)
                                                <div class="text-center">
                                                    <small>{{ trans('property.inbox.conversation_started', ['time' => $conversation->created_at->format('d M Y H:i')]) }}</small>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-bottom">
                                        <header class="entry-header">
                                            <h4 class="entry-title">
                                                <img src="{{ asset('assets/frontend/images/icon-comments.png') }}" /> {{ trans('property.inbox.property_questions') }}
                                            </h4>
                                        </header>
                                        <div class="entry-content">
                                            {!! Form::open(['method' => 'POST', 'id' => 'chat-form', 'route' => ['frontend.account.inbox.send_message', 'property_id' => $property->id], 'data-property_id' => $property->id]) !!}
                                                {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 4]) !!}
                                                {!! Form::submit(trans('property.inbox.send_message'), ['class' => 'btn btn-yellow']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <h4 class="text-center unbold color-gray">{{ trans('property.inbox.please_add_message') }}</h4>
                                @endif
                            @else
                                <h3 class="text-center unbold color-gray">{{ trans('property.inbox.please_select_property') }}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-2"></div>
        </div>
    </div>
@endsection