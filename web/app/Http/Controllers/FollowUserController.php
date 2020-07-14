<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FollowUser;
use App\Models\User;
use Auth;

class FollowUserController extends Controller
{
    public function store(Request $request)
    {
        $followedUser = User::findOrFail($request->input('id'));

        FollowUser::firstOrCreate([
            'user_id' => Auth::id(),
            'followed_user_id' => $followedUser->id,
        ]);

        return ["result" => 'OK'];
    }

    public function destroy($id)
    {
        //$followedUser = User::findOrFail($id);
        //$user = Auth::user();
        //$user->followings()->detach($followedUser->id);
        Auth::user()->unfollow($id);
        return ["result" => 'OK'];
    }
}
