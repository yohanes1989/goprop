<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($categories as $category)
    <url>
        <loc>{{ route('frontend.page.resources.category', ['category' => $category->slug]) }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    @endforeach
</urlset>