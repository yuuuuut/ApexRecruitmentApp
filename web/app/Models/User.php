<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $visible = [
        'id', 'name', 'profile'
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

    public function unfollow($id)
    {
        $followedUser = User::findOrFail($id);

        if ($followedUser) {
            $this->followings()->detach($followedUser->id);
        }
    }
}
