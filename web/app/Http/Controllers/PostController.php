<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;

use App\Models\Post;

use Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        $platform = $request->input('platform');
        $legend   = $request->input('legend');

        $query->where('platform', $platform)->get();

        if (!empty($legend)) {
            $query->whereIn('legend', $legend)->get();
        }

        $posts = $query->with(['user'])->orderBy(Post::UPDATED_AT, 'desc')->paginate(7);

        return $posts;
    }

    public function show(string $id)
    {
        $post = Post::where('id', $id)->with(['user'])->first();

        return $post ?? abort(404);
    }

    public function create(CreatePostRequest $request)
    {
        $post = Post::updateOrCreate([
            'user_id' => Auth::user()->id
        ], [
            'content' => $request->content,
            'myid' => $request->myid,
            'platform' => $request->platform,
            'legend' => $request->legend,
            'private' => $request->private,
        ]);

        return response($post, 201);
    }
}
