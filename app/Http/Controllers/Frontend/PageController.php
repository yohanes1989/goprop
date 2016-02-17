<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Category;
use GoProp\Models\CategoryTranslation;
use GoProp\Models\PackageCategory;
use GoProp\Models\Page;
use GoProp\Models\Post;
use GoProp\Models\PostTranslation;
use GoProp\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        $packageCategories = PackageCategory::all();

        $serviceSection = Page::where('identifier', 'home-service')->first();
        $overviewSection = Page::where('identifier', 'home-overview')->first();

        $testimonials = Testimonial::orderBy(DB::raw('RAND()'))->take(5)->get();

        return view('frontend.page.home', [
            'packageCategories' => $packageCategories,
            'serviceSection' => $serviceSection,
            'overviewSection' => $overviewSection,
            'testimonials' => $testimonials
        ]);
    }

    public function staticPage($identifier)
    {
        $content = Page::where('identifier', $identifier)->first();

        return view('frontend.page.static_page', [
            'content' => $content
        ]);
    }

    public function resources($category=null)
    {
        $qb = Post::with('translations')->published()->orderBy('created_at', 'DESC');

        if($category){
            $categoryTranslation = CategoryTranslation::whereSlug($category)->firstOrFail();
            $categoryObj = $categoryTranslation->category;

            $title = trans('resources.title').' - '.$categoryObj->title;

            $qb->whereHas('categories', function($q) use ($categoryObj){
                $q->where('category_id', $categoryObj->id);
            });
        }else{
            $title = trans('resources.title');
        }

        $posts = $qb->paginate(5);
        $categories = Category::with(['translations', 'postsCount'])->get();

        return view('frontend.page.resources.category', [
            'paginator' => $posts,
            'categories' => $categories,
            'title' => $title
        ]);
    }

    public function resourcePost($slug)
    {
        $qb = PostTranslation::with('post')->whereSlug($slug);
        $postTranslation = $qb->firstOrFail();
        $post = $postTranslation->post()->published()->firstOrFail();

        $title = $post->title;
        $categories = Category::with(['translations', 'postsCount'])->get();

        return view('frontend.page.resources.post', [
            'post' => $post,
            'categories' => $categories,
            'title' => $title
        ]);
    }

    public function propertyTermsConditions()
    {
        return view('frontend.page.property_terms_conditions');
    }
}