<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GoProp\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $qb = Page::with('translations');

        $pages = $qb->paginate(50);

        return view('admin.pages.index', [
            'pages' => $pages
        ]);
    }

    public function create($lang)
    {
        $page = new Page();

        return view('admin.pages.create', [
            'page' => $page,
            'lang' => $lang
        ]);
    }

    public function store(Request $request, $lang)
    {
        if($request->isMethod('POST')){
            $rules = $this->getRules();

            $this->validate($request, $rules);
        }

        $page = new Page($request->all());

        $translation = $page->translateOrNew($lang);
        $translation->fill($request->all());

        $page->save();

        return redirect()->route('admin.page.index')->with('messages', ['Page created successfully.']);
    }

    public function edit($lang, $id)
    {
        $page = Page::findOrFail($id);
        $translation = $page->translate($lang, true);

        return view('admin.pages.edit', [
            'page' => $page,
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

        $page = Page::findOrFail($id);
        $page->fill($request->all());

        $translation = $page->translateOrNew($lang);
        $translation->fill($request->all());

        $page->save();

        return redirect()->route('admin.page.index')->with('messages', ['Page '.$page->title.' successfully updated.']);
    }

    public function delete(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $title = $page->title;

        $page->delete();

        return redirect()->route('admin.page.index')->with('messages', ['Page '.$title.' is successfully deleted.']);
    }

    protected function getRules()
    {
        $rules = [
            'identifier' => 'required',
            'title' => 'required',
            'content' => 'required'
        ];

        return $rules;
    }
}
