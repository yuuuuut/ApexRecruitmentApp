<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfile;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function create(StoreProfile $request)
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
