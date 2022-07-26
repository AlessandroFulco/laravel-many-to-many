<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::paginate(15);
        return view('admin.posts.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:100',
            'slug'      => 'required|string|max:100|unique:posts',
            'category_id'  => 'required|integer|exists:categories,id',
            'tags'      => 'nullable|array',
            'tags.*'    => 'integer|exists:tags,id',
            'image'     => 'required_without:content|nullable|url',
            'content'   => 'required_without:image|nullable|string|max:5000',
            'excerpt'   => 'nullable|string|max:200',
        ]);

        $data = $request->all();
        // dump($data);

        $post = Post::create($data);
        $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.show', ['posts' => $post->id]);

    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }


    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', [
            'post'          => $post,
            'categories'    => $categories,
            'tags'          => $tags,
        ]);
    }


    public function update(Request $request, Post $post)
    {
        $data = $request->all();

        $post->update($data);
        $post->update()->tags()->sync($data['tags']);
        return redirect()->route('admin.posts.show', ['posts' => $post->id]);
    }


    public function destroy($id)
    {
        //
    }
}
