<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('frontend.sitemap.pages') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ route('frontend.sitemap.properties') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ route('frontend.sitemap.resources') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ route('frontend.sitemap.resource_categories') }}</loc>
    </sitemap>
</sitemapindex>