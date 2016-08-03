<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($properties as $property)
    <url>
        <loc>{{ $property->getExternalUrl() }}</loc>
        <changefreq>monthly</changefreq>

        @if($property->hasThumbnail())
        <image:image>
            <image:loc>{{ url('images/original/'.$property->getPhotoThumbnail()) }}</image:loc>
            <image:caption>{{ ProjectHelper::formatTitle($property->property_name.', '.trans('property.for.'.$property->getViewFor().'_property_title', ['name' => trans('property.property_type.'.$property->type->slug)])) }}</image:caption>
        </image:image>
        @endif
    </url>
    @endforeach
</urlset>