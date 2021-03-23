<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller {

    public function index(){
        //$posts = Post::all();
        $posts = Post::paginate(10);
        $posts = Post::withTrashed()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post){
        return view('posts.show', compact('post'));
    }

    public function create(){
        $users = User::all();
        return view('posts.create', compact('users'));
    }

    public function store(StorePostRequest $request){ //service container
        Post::create($request->all());
        return redirect()->route('posts.index');
    }

    public function edit(Post $post){
        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    public function update(Post $post, StorePostRequest $request){
        $post->update($request->all());
        return redirect()->route('posts.index');
    }
    public function destroy(Post $post) {
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function restore($post) {
        Post::onlyTrashed()->find($post)->restore();
        return redirect()->route('posts.index');
    }

}
