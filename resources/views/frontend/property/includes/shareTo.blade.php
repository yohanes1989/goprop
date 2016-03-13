<li class="socialShare-to">
    <a href=""><i class="fa fa-share-alt"></i></a>
    <ul>
        <li><a target="_blank" class="popup-share-link" href="{{ \GoProp\Facades\ProjectHelper::getSocialShareLink('facebook', ['title' => $property->property_name, 'url' => route('frontend.property.view', ['id' => $property->id])]) }}"><i class="fa fa-facebook"></i></a></li>
        <li><a target="_blank" class="popup-share-link" href="{{ \GoProp\Facades\ProjectHelper::getSocialShareLink('twitter', ['title' => $property->property_name, 'url' => route('frontend.property.view', ['id' => $property->id])]) }}"><i class="fa fa-twitter"></i></a></li>
        <li><a target="_blank" class="popup-share-link" href="{{ \GoProp\Facades\ProjectHelper::getSocialShareLink('linkedin', ['title' => $property->property_name, 'url' => route('frontend.property.view', ['id' => $property->id])]) }}"><i class="fa fa-linkedin"></i></a></li>
        <li><a target="_blank" class="popup-share-link" href="{{ \GoProp\Facades\ProjectHelper::getSocialShareLink('googleplus', ['title' => $property->property_name, 'url' => route('frontend.property.view', ['id' => $property->id])]) }}"><i class="fa fa-google-plus"></i></a></li>
        <li><a target="_blank" href="{{ \GoProp\Facades\ProjectHelper::getSocialShareLink('whatsapp', ['title' => $property->property_name, 'url' => route('frontend.property.view', ['id' => $property->id])]) }}"><i class="fa fa-whatsapp"></i></a></li>
    </ul>
</li>