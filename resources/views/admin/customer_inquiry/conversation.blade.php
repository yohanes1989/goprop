@extends('admin.layouts.master')

@section('title', 'Conversation with '.$conversation->sender->profile->singleName)

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.customer_inquiry.index') }}"><i class="fa fa-comments"></i> {{ 'Conversation with '.$conversation->sender->profile->singleName }}</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <h4>{{ 'Conversation with '.$conversation->sender->profile->singleName }}</h4>
                </div>

                <div class="scrollDiv" data-scrollHeight="640">
                    <ul class="timeline">
                        @foreach($conversation->replies as $reply)
                            <li class="{{ $reply->sender->id == $conversation->sender->id?'':'text-right alt-color' }}">
                                <div class="timeline-item">
                                    <h6 class="timeline-title"><small class="timeline-meta">{{ $reply->created_at->format('d M Y H:i') }}</small> {{ $reply->sender->profile->singleName }}</h6>
                                    <div class="timeline-content">{{ $reply->message }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <h4>Reply</h4>
                </div>

                {!! Form::open(['class' => 'form-horizontal']) !!}
                <div class="form-group">
                {!! Form::textarea('message', null, ['placeholder' => 'Your Reply', 'class' => 'form-control', 'rows' => 4]) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection