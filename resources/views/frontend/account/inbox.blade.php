@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="user-content-begin">
        <div class="row">
            <div class="col-sm-12 col-md-10 register-form-wrapper">
                <header class="header-area">
                    <h3 class="entry-title">{{ trans('property.inbox.title') }}</h3>
                    @if($property && $property->messages->count() < 1)
                    <div class="entry-button"><a href="{{ route('frontend.account.inbox', ['property_id' => $property->id, 'new' => TRUE]) }}"><img src="{{ asset('assets/frontend/images/icon-inbox-new.png') }}" /> Add Messages</a></div>
                    @endif
                </header>
                <div class="entry-content">
                    <div class="inbox-content-wrapper">
                        <div class="row">
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

                        @if($interested_properties->count() > 0)
                        <div class="chat-content-wrapper">
                            @if($property)
                                @if($conversation || \Illuminate\Support\Facades\Request::get('new'))
                                <div class="chat-inner-wrapper">
                                    <div class="chat-top">
                                        <div class="col-xs-5 user-info">
                                            <div class="row">
                                                <div class="icon">
                                                    <img src="{{ asset('assets/frontend/images/user-icon.png') }}" alt="">
                                                </div>
                                                <header class="entry-header">
                                                    @if(!$conversation)
                                                        <h5 class="entry-title">GoProp Agent</h5>
                                                    @else
                                                        <h5 class="entry-title">{{ $conversation->recipient->profile->singleName }}</h5>
                                                        <h6 class="entry-desc">{{ $conversation->recipient->profile->occupation }}</h6>
                                                    @endif
                                                </header>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="col-xs-7 button-area">
                                            <h6 class="entry-date">
                                                <a href="" class="btn btn-yellow"><img src="{{ asset('assets/frontend/images/icon-user-viewings.png') }}" /> <span>Viewing scheduled:</span> Sat, 26th Nov 2015 09.00</a>
                                            </h6>
                                        </div>
                                        -->
                                    </div>
                                    <div class="chat-middle">
                                        <div class="chat-middle-outer">
                                            <div class="chat-middle-content">
                                                @if($conversation)
                                                <div class="text-center">
                                                    <small>{{ trans('property.inbox.conversation_started', ['time' => $conversation->created_at->format('d M Y H:i')]) }}</small>
                                                </div>

                                                @foreach($conversation->replies as $reply)
                                                    <div class="chat-row {{ $reply->sender->id == $user->id?'chat-self':'chat-reply' }}">
                                                        <div class="chat-date">{{ $reply->created_at->format('d M Y H:i') }}</div>
                                                        <div class="chat-message">{{ $reply->message }}</div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-bottom">
                                        <header class="entry-header">
                                            <h4 class="entry-title">
                                                <img src="{{ asset('assets/frontend/images/icon-comments.png') }}" /> Property Questions
                                            </h4>
                                        </header>
                                        <div class="entry-content">
                                            {!! Form::open(['method' => 'POST', 'route' => ['frontend.account.inbox.send_message', 'property_id' => $property->id]]) !!}
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
                        @else
                            <div class="text-center">
                                <small>{!! trans('property.inbox.no_result_message') !!}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-2"></div>
        </div>
    </div>
@endsection