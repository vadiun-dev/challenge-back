<?php

namespace App\Http\Controllers;

use App\Models\Post;
use http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class BlogController
{
    public function index()
    {
        $posts = DB::table('posts')->get();
        foreach ($posts as $post) {
            $post->likes = DB::table('likes')->where('post_id', $post->id)->count();
        }
        return $posts;
    }

    public function show($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        $post->likes = DB::table('likes')->where('post_id', $post->id)->count();
        return $post;
    }

    public function addLike(Request $request, $postId)
    {

        DB::table('likes')->insert([
          'post_id' => $postId,
          'user_id' => auth()->user()->id,
          'created_at' => now(),
          'updated_at' => now()
      ]);

        return 1;
    }

    public function createPost(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);


        $post = Post::create([
             'title' => $request->input('title'),
             'content' => $request->input('content'),
         ]);

        return $post;
    }


}
