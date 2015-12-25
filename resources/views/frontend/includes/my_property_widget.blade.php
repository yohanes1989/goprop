<div class="property-quick-bar">
    <div class="pull-left">
        @if($property->status == \GoProp\Models\Property::STATUS_DRAFT)
            <a href="{{ (\Illuminate\Support\Facades\Request::has('backUrl'))?Illuminate\Support\Facades\Request::get('backUrl'):route('frontend.property.edit', ['id' => $property->id]) }}" class="btn btn-grey">{{ trans('property.view.preview_edit') }}</a>
        @else
            <a data-confirm="{{ trans('property.view.unpublish_confirm') }}" href="{{ route('frontend.property.set_draft_edit', ['id' => $property->id]) }}" class="btn btn-grey">{{ trans('property.view.set_draft_edit') }}</a>
        @endif
    </div>

    <div class="pull-right">
        <h4>{{ trans('property.status.'.$property->status) }}</h4>
    </div>

    <div class="clearfix"></div>
</div>