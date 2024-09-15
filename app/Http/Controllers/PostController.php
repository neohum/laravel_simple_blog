<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
     {
        $post = Post::all()->sortByDesc('id');
        return view('posts.index', ['posts'=>$post]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request) {
  // validations
  $request->validate([
    'title' => 'required',
    'content' => 'required',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
  ]);

  $post = new Post;

  $file_name = time() . '.' . request()->image->getClientOriginalExtension();
  request()->image->move(public_path('images'), $file_name);

  $post->title = $request->title;
  $post->content = $request->content;
  $post->image = $file_name;

  $post->save();
  return redirect()->route('posts.index')->with('success', '글쓰기가 완료되었습니다.');
}
}
