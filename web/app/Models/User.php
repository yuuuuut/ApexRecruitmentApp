<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\FollowUser;

use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = [
        'is_following'
    ];

    protected $visible = [
        'id', 'name', 'profile',
        'is_following'
    ];

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function followings()
    {
        return $this->belongsToMany(self::class, 'follow_users', 'user_id', 'followed_user_id')
                    ->using(FollowUser::class);
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'follow_users', 'followed_user_id', 'user_id')
                    ->using(FollowUser::class);
    }

    public function follow($id)
    {
        $followedUser = User::findOrFail($id);

        if ($followedUser) {
            FollowUser::firstOrCreate([
                'user_id' => Auth::id(),
                'followed_user_id' => $followedUser->id,
            ]);
        }
    }

    public function unfollow($id)
    {
        $followedUser = User::findOrFail($id);

        if ($followedUser) {
            $this->followings()->detach($followedUser->id);
        }
    }

    public function getIsFollowingAttribute()
    {
        return $this->followers->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }
}
