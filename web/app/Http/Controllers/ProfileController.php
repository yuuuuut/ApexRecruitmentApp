<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Profile;


class ProfileController extends Controller
{
    public function create(Request $request)
    {
        $profile = new Profile();

        $profile->user_id  = Auth::user()->id;
        $profile->psid     = $request->input('psid');
        $profile->content  = $request->input('content');
        $profile->platform = $request->input('platform');
        $profile->save();

        return response($profile, 201);
    }
}
