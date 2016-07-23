<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\MainBanner;
use Illuminate\Http\Request;
use GoProp\Models\Testimonial;

class MainBannerController extends Controller
{
    public function index()
    {
        $qb = MainBanner::with('translations');

        $main_banners = $qb->paginate(50);

        return view('admin.main_banners.index', [
            'main_banners' => $main_banners
        ]);
    }

    public function create($lang)
    {
        $main_banner = new MainBanner();

        return view('admin.main_banners.create', [
            'main_banner' => $main_banner,
            'lang' => $lang
        ]);
    }

    public function store(Request $request, $lang)
    {

        $main_banner = new MainBanner([
            'url' => $request->get('url'),
            'sort_order' => $request->get('sort_order')
        ]);

        $translation = $main_banner->translateOrNew($lang);
        $translation->fill($request->all());

        if($request->isMethod('POST')){
            $rules = $this->getRules($translation);

            $this->validate($request, $rules);
        }

        if($request->hasFile('image')){
            $translation->image = $translation->saveImage($request->file('image'));
        }


        $main_banner->save();

        return redirect()->route('admin.main_banner.index')->with('messages', ['Main Banner created successfully.']);
    }

    public function edit($lang, $id)
    {
        $main_banner = MainBanner::findOrFail($id);
        $translation = $main_banner->translate($lang);

        return view('admin.main_banners.edit', [
            'main_banner' => $main_banner,
            'translation' => $translation,
            'lang' => $lang
        ]);
    }

    public function update(Request $request, $lang, $id)
    {
        $main_banner = MainBanner::findOrFail($id);
        $main_banner->fill([
            'url' => $request->get('url'),
            'sort_order' => $request->get('sort_order')
        ]);

        $translation = $main_banner->translateOrNew($lang);
        $translation->fill($request->all());

        if($request->isMethod('POST')){
            $rules = $this->getRules($translation);

            $this->validate($request, $rules);
        }

        if($request->hasFile('image')){
            $translation->image = $translation->saveImage($request->file('image'));
        }

        $main_banner->save();

        return redirect()->route('admin.main_banner.index')->with('messages', ['Main Banner is successfully updated.']);
    }

    public function delete(Request $request, $id)
    {
        $main_banner = MainBanner::findOrFail($id);

        $main_banner->delete();

        return redirect()->route('admin.main_banner.index')->with('messages', ['Main Banner is successfully deleted.']);
    }

    protected function getRules($translation=null)
    {
        $rules = [
            'title' => 'required',
            'url' => 'required',
            'image' => 'image'.(!$translation->image?'|required':''),
        ];

        return $rules;
    }
}
