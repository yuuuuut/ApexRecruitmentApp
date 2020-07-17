<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = [
        'is_following',
    ];

    protected $visible = [
        'id', 'name', 'profile',
        'is_following',
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

    /**
     * profileテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    /**
     * followingsテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'user_id', 'followed_user_id')
                    ->using(FollowUser::class);
    }

    /**
     * followersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'followed_user_id', 'user_id')
                    ->using(FollowUser::class);
    }

    /**
     * ユーザーをフォローする
     */
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

    /**
     * ユーザーのフォローを外す
     */
    public function unfollow($id)
    {
        $followedUser = User::findOrFail($id);

        if ($followedUser) {
            $this->followings()->detach($followedUser->id);
        }
    }

    /**
     * is_following
     * @return Boolean
     */
    public function getIsFollowingAttribute()
    {
        return $this->followers->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }
}
