@foreach($properties as $property)
    <?php $for = $property->getViewFor(); ?>
    @include('frontend.property.index.row', ['for' => $for, 'property' => $property])
@endforeach