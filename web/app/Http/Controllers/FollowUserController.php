<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FollowUser;
use App\Models\User;
use Auth;

class FollowUserController extends Controller
{
    public function store($id)
    {
        Auth::user()->follow($id);

        return ["result" => 'OK'];
    }

    public function destroy($id)
    {
        Auth::user()->unfollow($id);

        return ["result" => 'OK'];
    }

    public function followIndex($id)
    {
        $user = User::find($id);
        $follow = $user->followings()->get();

        return $follow;
    }

    public function followerIndex($id)
    {
        $user = User::find($id);
        $follower = $user->followers()->get();

        return $follower;
    }
}
