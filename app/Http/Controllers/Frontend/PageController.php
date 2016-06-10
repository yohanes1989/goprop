<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Category;
use GoProp\Models\CategoryTranslation;
use GoProp\Models\FormSubmission;
use GoProp\Models\PackageCategory;
use GoProp\Models\Page;
use GoProp\Models\Post;
use GoProp\Models\PostTranslation;
use GoProp\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;
use Illuminate\Support\Facades\Mail;

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

    public function referralListing(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            'address' => 'required|min:10',
            'city' => 'required',
        ];

        if($request->isMethod('POST')){

            $this->validate($request, $rules);

            $formSubmission = new FormSubmission();
            $formSubmission->fill([
                'email' => $request->input('email'),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);
            $formSubmission->saveData([$request->except('_token')]);
            $formSubmission->save();

            $messageVars = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('contact_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
            ];

            Mail::send('frontend.emails.referral_listing', $messageVars, function ($m){
                $m->from(config('app.contact_from_email'), config('app.contact_from_name'));
                $m->to(config('app.contact_destination'))->subject('Referral Listing Registration');
            });

            return redirect()->refresh()->with('messages', [trans('contact.referral_listing_registration_msg')]);
        }

        $validator = JsValidatorFacade::make($rules);

        $content = Page::where('identifier', 'referral-listing')->first();

        return view('frontend.page.referral_listing', [
            'validator' => $validator,
            'content' => $content
        ]);
    }
}