<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;

use App\Models\Post;

use Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user'])->orderBy(Post::UPDATED_AT, 'desc')->paginate(7);

        return $posts;
    }

    public function create(CreatePostRequest $request)
    {
        $post = Post::updateOrCreate([
            'user_id' => Auth::user()->id
        ], [
            'content' => $request->content,
            'myid' => $request->myid,
            'platform' => $request->platform,
        ]);

        return response($post, 201);
    }
}
