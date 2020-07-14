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
}
