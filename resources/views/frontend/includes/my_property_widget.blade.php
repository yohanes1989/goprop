<div class="property-quick-bar">
    <div class="pull-left">
        <a href="{{ (\Illuminate\Support\Facades\Request::has('backUrl'))?Illuminate\Support\Facades\Request::get('backUrl'):route('frontend.property.edit', ['id' => $property->id]) }}" class="btn btn-grey">{{ trans('property.view.preview_edit') }}</a>
    </div>

    <div class="pull-right">
        <h4>{{ trans('property.status.'.$property->status) }}</h4>
    </div>

    <div class="clearfix"></div>
</div>