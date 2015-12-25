@foreach($properties as $property)
    @include('frontend.property.index.row', ['for' => $for, 'property' => $property])
@endforeach