<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('frontend.page.static_page', ['identifier' => 'get-started']) }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('frontend.page.static_page', ['identifier' => 'about-goprop']) }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('frontend.property.search', ['search' => ['for' => 'sell']]) }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('frontend.property.search', ['search' => ['for' => 'rent']]) }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('frontend.page.resources') }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('frontend.page.contact') }}</loc>
        <changefreq>monthly</changefreq>
    </url>
</urlset>