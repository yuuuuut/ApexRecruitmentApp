<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use Auth;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $post = Post::updateOrCreate([
            'user_id' => Auth::user()->id
        ], [
            'content' => $request->content,
        ]);

        return response($post, 201);
    }
}
