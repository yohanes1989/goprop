<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($posts as $post)
    <url>
        <loc>{{ route('frontend.page.resources.post', ['slug' => $post->slug]) }}</loc>
        <changefreq>weekly</changefreq>

        @if($post->image)
        <image:image>
            <image:loc>{{ asset('images/property_thumbnail/'.$post->image) }}</image:loc>
            <image:caption>{{ $post->title }}</image:caption>
        </image:image>
        @endif
    </url>
    @endforeach
</urlset>