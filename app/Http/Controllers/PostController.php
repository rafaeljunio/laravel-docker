<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBY('id', 'DESC')->paginate(15);
        return $posts;
    }

    public function store(StoreUpdatePost $request){
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return $post;

        // $post = Post::create($request->all());
    }

    public function show($id){
        //$post = Post::where('id', $id)->first();
        $post = Post::find($id);
        return $post;
        // $post = Post::create($request->all());
    }

    public function destroy($id){
        $post = Post::find($id);
        $post->delete();
    }

    public function update(StoreUpdatePost $request, $id){
        $post = Post::find($id);
        $post->update($request->all());
    }

    public function search(Request $request){
        $filters = $request->except('_token');

        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
                        ->orWhere('content', 'LIKE', "%{$request->search}%")
                        ->paginate();
        //toSql(); para debugar

        $posts->appends($filters)->links();

        return $posts;
    }
}
