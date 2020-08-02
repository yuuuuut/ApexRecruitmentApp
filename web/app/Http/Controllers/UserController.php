<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;

use Auth;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = User::where('id', $id)->with(['profile'])->first();
        $post = Post::where('user_id', $id)->with(['user'])->first();

        return [$user, $post];
    }
}
