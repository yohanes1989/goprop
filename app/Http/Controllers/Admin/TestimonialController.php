<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GoProp\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $qb = Testimonial::with('translations');

        $testimonials = $qb->paginate(50);

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials
        ]);
    }

    public function create($lang)
    {
        $testimonial = new Testimonial();

        return view('admin.testimonials.create', [
            'testimonial' => $testimonial,
            'lang' => $lang
        ]);
    }

    public function store(Request $request, $lang)
    {
        if($request->isMethod('POST')){
            $rules = $this->getRules();

            $this->validate($request, $rules);
        }

        $testimonial = new Testimonial();
        if($request->hasFile('image')){
            $testimonial->image = $testimonial->saveImage($request->file('image'));
        }

        $translation = $testimonial->translateOrNew($lang);
        $translation->fill($request->all());


        $testimonial->save();

        return redirect()->route('admin.testimonial.index')->with('messages', ['Testimonial created successfully.']);
    }

    public function edit($lang, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $translation = $testimonial->translate($lang, true);

        return view('admin.testimonials.edit', [
            'testimonial' => $testimonial,
            'translation' => $translation,
            'lang' => $lang
        ]);
    }

    public function update(Request $request, $lang, $id)
    {
        if($request->isMethod('POST')){
            $rules = $this->getRules();

            $this->validate($request, $rules);
        }

        $testimonial = Testimonial::findOrFail($id);

        if($request->input('remove_image', 0) == 1){
            $testimonial->removeImage();
        }

        if($request->hasFile('image')){
            $testimonial->image = $testimonial->saveImage($request->file('image'));
        }

        $translation = $testimonial->translateOrNew($lang);
        $translation->fill([
            'title' => $request->title,
            'content' => $request->content
        ]);

        $testimonial->save();

        return redirect()->route('admin.testimonial.index')->with('messages', ['Testimonial is successfully updated.']);
    }

    public function delete(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->delete();

        return redirect()->route('admin.testimonial.index')->with('messages', ['Testimonial is successfully deleted.']);
    }

    protected function getRules()
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'image' => 'image'
        ];

        return $rules;
    }
}
