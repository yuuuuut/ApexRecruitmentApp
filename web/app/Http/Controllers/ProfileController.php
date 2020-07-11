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
        $profile = Profile::updateOrCreate([
            'user_id' => Auth::user()->id
        ], [
            'psid'     => $request->input('psid'),
            'content'  => $request->input('content'),
            'platform' => $request->input('platform'),
        ]);

        return response($profile, 201);
    }
}
