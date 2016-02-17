<?php

namespace GoProp\Http\Controllers\Admin\Post;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Category;
use Illuminate\Http\Request;
use GoProp\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $qb = Post::with('translations');

        $posts = $qb->paginate(50);

        return view('admin.posts.index', [
            'posts' => $posts
        ]);
    }

    public function create($lang)
    {
        $post = new Post();

        $categoryOptions = $this->getCategoryOptions($lang);

        return view('admin.posts.create', [
            'post' => $post,
            'lang' => $lang,
            'categoryOptions' => $categoryOptions
        ]);
    }

    public function store(Request $request, $lang)
    {
        if($request->isMethod('POST')){
            $rules = $this->getRules();

            $this->validate($request, $rules);
        }

        $post = new Post();
        $post->fill([
            'status' => $request->input('status')
        ]);

        $translation = $post->translateOrNew($lang);
        $translation->fill($request->all());

        if($request->hasFile('image')){
            $translation->image = $translation->saveImage($request->file('image'));
        }

        $post->save();
        $post->categories()->sync($request->input('categories', []));
        $post->user()->associate(Auth::user());

        return redirect()->route('admin.post.index')->with('messages', ['Post created successfully.']);
    }

    public function edit($lang, $id)
    {
        $post = Post::findOrFail($id);
        $translation = $post->translate($lang, true);

        $categoryOptions = $this->getCategoryOptions($lang);

        return view('admin.posts.edit', [
            'post' => $post,
            'translation' => $translation,
            'lang' => $lang,
            'categoryOptions' => $categoryOptions
        ]);
    }

    public function update(Request $request, $lang, $id)
    {
        if($request->isMethod('POST')){
            $rules = $this->getRules();

            $this->validate($request, $rules);
        }

        $post = Post::findOrFail($id);
        $originalTranslation = $post->translate();

        $post->fill([
            'status' => $request->input('status')
        ]);
        $post->categories()->sync($request->input('categories', []));

        $translation = $post->translateOrNew($lang);
        $translation->fill($request->all());

        if($request->input('remove_image', 0) == 1){
            $translation->removeImage();
        }elseif($request->input('_translate') == 1){
            $translation->image = $originalTranslation->duplicateImage();
        }

        if($request->hasFile('image')){
            $translation->image = $translation->saveImage($request->file('image'));
        }

        $post->save();

        return redirect()->route('admin.post.index')->with('messages', ['Post '.$post->title.' successfully updated.']);
    }

    public function delete(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $title = $post->title;

        $post->delete();

        return redirect()->route('admin.post.index')->with('messages', ['Post '.$title.' is successfully deleted.']);
    }

    protected function getCategoryOptions($lang)
    {
        $categories = Category::all();
        $categoryOptions = [];

        foreach($categories as $category){
            $translation = $category->translate($lang, true);
            $categoryOptions[$category->id] = $translation->title;
        }

        return $categoryOptions;
    }

    protected function getRules()
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|max:1000',
        ];

        return $rules;
    }
}
