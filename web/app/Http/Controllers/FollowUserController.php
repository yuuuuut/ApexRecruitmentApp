<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Auth;

class FollowUserController extends Controller
{
    public function store($id)
    {
        Auth::user()->follow($id);
        $user = User::find($id)->with(['profile'])->first();

        return response($user, 201);
    }

    public function destroy($id)
    {
        Auth::user()->unfollow($id);

        return ["result" => 'OK'];
    }

    public function followIndex($id)
    {
        $follow = User::find($id)->followings()
                        ->with(['profile'])
                        ->get();
        return $follow;
    }

    public function followerIndex($id)
    {
        $follower = User::find($id)->followers()
                        ->with(['profile'])
                        ->get();
        return $follower;
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
