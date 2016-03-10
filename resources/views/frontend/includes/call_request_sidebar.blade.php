<div class="calling-us-widget">
    <h4 class="entry-title">{{ trans('contact.call_us_text', ['phone' => '+62 878 8733 2268']) }}</h4>
    <div class="entry-content">
        {!! Form::open(['method' => 'POST', 'route' => 'contact.request_call', 'class' => 'ajax-form']) !!}
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="{{ trans('contact.name') }} ({{ trans('contact.required') }})" />
            </div>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="{{ trans('contact.phone') }} ({{ trans('contact.required') }})" />
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="{{ trans('contact.email') }} ({{ trans('contact.required') }})" />
            </div>
            <!--
            <div class="form-group">
                <select class="form-control">
                    <option>Reason for enquiry</option>
                </select>
            </div>
            -->
            <div class="form-group btn-submit">
                <button class="btn btn-grey">{{ trans('contact.request_call') }}</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>