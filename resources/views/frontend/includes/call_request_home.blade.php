<section class="calling-columns">
    <div class="container">
        <div class="col-xs-12">
            <header class="entry-header text-center">
                <h2 class="entry-title">{{ trans('contact.call_us_text', ['phone' => '0815 1917 2767']) }}</h2>
            </header>
            {!! Form::open(['method' => 'POST', 'route' => 'contact.request_call', 'class' => 'ajax-form form form-inline text-center']) !!}

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
</section><!-- end of calling-columns -->