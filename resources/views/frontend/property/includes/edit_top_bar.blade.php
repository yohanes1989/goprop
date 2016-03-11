<div class="menu-preview">
    <ul class="list-unstyled">
        <li><a href="{{ route('frontend.property.view', ['for' => $model->getViewFor(), 'id' => $model->id, 'preview' => TRUE, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}"><img src="{{ asset('assets/frontend/images/property-preview.png') }}" alt="" /> {{ trans('property.buttons.preview') }}</a></li>
        @if(in_array($model->status, [\GoProp\Models\Property::STATUS_ACTIVE]))
        <li><a data-confirm="{{ trans('property.view.unpublish_confirm') }}" href="{{ route('frontend.property.set_unpublish', ['id' => $model->id]) }}"><img src="{{ asset('assets/frontend/images/property-disable.png') }}" alt="" /> {{ trans('property.buttons.disable') }}</a></li>
        @endif
    </ul>
</div>