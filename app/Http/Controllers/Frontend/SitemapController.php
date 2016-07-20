<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Category;
use GoProp\Models\Post;
use GoProp\Models\Property;
use GoProp\Facades\AddressHelper;

class SitemapController extends Controller
{
    public function home()
    {
        $content = view('frontend.sitemap.home')->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    public function pages()
    {
        $content = view('frontend.sitemap.pages')->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    public function properties()
    {
        $qb = Property::active()->orderBy('checkout_at', 'DESC');
        $properties = $qb->get();

        $content = view('frontend.sitemap.properties', ['properties' => $properties])->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    public function resources()
    {
        $qb = Post::with('translations')->published()->orderBy('created_at', 'DESC');
        $posts = $qb->get();

        $content = view('frontend.sitemap.resources', ['posts' => $posts])->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    public function resourceCategories()
    {
        $categories = Category::all();

        $content = view('frontend.sitemap.resource_categories', ['categories' => $categories])->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }
}