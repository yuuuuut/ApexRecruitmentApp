<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class FollowUserController extends Controller
{
    public function store($id)
    {
        Auth::user()->follow($id);
        Auth::user()->createNotificationFollow($id);

        return ["result" => 'OK'];
    }

    public function destroy($id)
    {
        Auth::user()->unfollow($id);

        return ["result" => 'OK'];
    }

    public function timeLine()
    {
        $posts = Auth::user()->followings()
                        ->with(['post.user'])
                        ->join('posts', 'users.id', '=', 'posts.user_id')
                        ->orderBy('posts.updated_at', 'DESC')
                        ->paginate(7);
        return $posts;
    }
}
