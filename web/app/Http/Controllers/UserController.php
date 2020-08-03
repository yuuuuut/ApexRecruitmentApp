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
        $user = User::where('id', $id)
                    ->with(['profile', 'post.user'])
                    ->first();
        return $user;
    }
}
