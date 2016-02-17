<?php

namespace GoProp\Http\Controllers\Admin\Post;

use GoProp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GoProp\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $qb = Category::with(['translations', 'postsCount']);

        $categories = $qb->paginate(50);

        return view('admin.posts.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create($lang)
    {
        $category = new Category();

        return view('admin.posts.categories.create', [
            'category' => $category,
            'lang' => $lang
        ]);
    }

    public function store(Request $request, $lang)
    {
        if($request->isMethod('POST')){
            $rules = $this->getRules();

            $this->validate($request, $rules);
        }

        $category = new Category();

        $translation = $category->translateOrNew($lang);
        $translation->fill($request->all());

        $category->save();

        return redirect()->route('admin.post.category.index')->with('messages', ['Category created successfully.']);
    }

    public function edit($lang, $id)
    {
        $category = Category::findOrFail($id);
        $translation = $category->translate($lang, true);

        return view('admin.posts.categories.edit', [
            'category' => $category,
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

        $category = Category::findOrFail($id);

        $translation = $category->translateOrNew($lang);
        $translation->fill($request->all());

        $category->save();

        return redirect()->route('admin.post.category.index')->with('messages', ['Category '.$category->title.' successfully updated.']);
    }

    public function delete(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $title = $category->title;

        $category->delete();

        return redirect()->route('admin.post.category.index')->with('messages', ['Category '.$title.' is successfully deleted.']);
    }

    protected function getRules()
    {
        $rules = [
            'title' => 'required',
        ];

        return $rules;
    }
}
