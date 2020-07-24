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
            'content'  => $request->input('content'),
        ]);

        return response($profile, 201);
    }
}
