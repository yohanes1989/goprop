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
use GoProp\Models\Profile;
use GoProp\Models\Testimonial;
use GoProp\Models\User;
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
            'email' => 'required|email|unique:users,email',
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

            $password = str_random(8);

            $user = new User([
                'email' => $request->input('email'),
                'status' => User::STATUS_ACTIVE,
                'password' => bcrypt($password)
            ]);
            $user->manage_property = FALSE;
            $user->save();
            $user->assignRole('agent');

            $names = explode(' ', $request->input('name'));

            $profile = new Profile();
            $profile->fill([
                'first_name' => array_shift($names),
                'last_name' => !empty($names)?implode(' ', $names):'',
                'mobile_phone_number' => $request->input('contact_number'),
                'address' => $request->input('address').', '.$request->input('city')
            ]);
            $profile->user()->associate($user);
            $profile->save();
            $user->load('profile');

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

            $this->notifyReferralAgent($user, $password);

            return redirect()->refresh()->with('messages', [trans('contact.referral_listing_registration_msg')]);
        }

        $validator = JsValidatorFacade::make($rules);

        $content = Page::where('identifier', 'referral-listing')->first();

        return view('frontend.page.referral_listing', [
            'validator' => $validator,
            'content' => $content
        ]);
    }

    public function notifySignedUpReferralAgents()
    {
        $submissions = FormSubmission::groupBy('email')->get();

        foreach($submissions as $submission){
            if(User::where('email', $submission->email)->count() < 1){
                $password = str_random(8);

                $user = new User([
                    'email' => $submission->email,
                    'status' => User::STATUS_ACTIVE,
                    'password' => bcrypt($password)
                ]);
                $user->manage_property = FALSE;
                $user->save();
                $user->assignRole('agent');

                $names = explode(' ', $submission->getData('name'));

                $profile = new Profile();
                $profile->fill([
                    'first_name' => array_shift($names),
                    'last_name' => !empty($names)?implode(' ', $names):'',
                    'mobile_phone_number' => $submission->getData('contact_number'),
                    'address' => $submission->getData('address').', '.$submission->getData('city')
                ]);
                $profile->user()->associate($user);
                $profile->save();
                $user->load('profile');

                $this->notifyReferralAgent($user, $password);
            }
        }
    }

    protected function notifyReferralAgent($user, $password)
    {
        $messageVars = [
            'user' => $user,
            'password' => $password,
        ];

        Mail::send('frontend.emails.new_referral_agent', $messageVars, function ($m) use ($user){
            $m->from(config('app.contact_from_email'), config('app.contact_from_name'));
            $m->to($user->email)->subject('Informasi Login GoProp Referral Agent');
        });
    }
}