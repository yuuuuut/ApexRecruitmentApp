<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = User::where('id', $id)
                    ->with(['profile', 'post.user'])
                    ->first();

        $follow = User::find($id)->followings()
                    ->with(['profile'])
                    ->get();

        $follower = User::find($id)->followers()
                    ->with(['profile'])
                    ->get();

        return [$user, $follow, $follower];
    }
}
