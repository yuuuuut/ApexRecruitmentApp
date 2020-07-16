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
        'is_following', 'followings',
        'following_count', 'followers_count'
    ];

    protected $visible = [
        'id', 'name', 'profile',
        'followings',
        'is_following', 'following_count',
        'followers_count'
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
        return $this->belongsToMany(self::class, 'follow_users', 'user_id', 'followed_user_id')
                    ->using(FollowUser::class);
    }

    /**
     * followersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'follow_users', 'followed_user_id', 'user_id')
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
     * following_count
     * @return Int
     */
    public function getFollowingCountAttribute()
    {
        return $this->followings->count();
    }

    /**
     * followings
     * @return Array
     */
    public function getFollowingsAttribute()
    {
        return $this->followings()->with(['profile'])->get();
    }

    /**
     * followers_count
     * @return Int
     */
    public function getFollowersCountAttribute()
    {
        return $this->followers->count();
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
