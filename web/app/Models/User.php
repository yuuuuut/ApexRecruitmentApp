<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Notification;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = [
        'is_following', 'is_followed'
    ];

    protected $visible = [
        'id', 'name', 'profile', 'post',
        'is_following', 'is_followed'
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
     * postテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post()
    {
        return $this->hasOne('App\Models\Post');
    }

    /**
     * profileテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    /**
     * follow_usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'user_id', 'followed_user_id')
                    ->using(FollowUser::class);
    }

    /**
     * follow_usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_users', 'followed_user_id', 'user_id')
                    ->using(FollowUser::class);
    }

    /**
     * notificationテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function active_notifications()
    {
        return $this->hasMany('App\Models\Notification', 'visiter_id');
    }

    /**
     * notificationテーブル
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function passive_notifications()
    {
        return $this->hasMany('App\Models\Notification', 'visited_id');
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
        if (Auth::guest()) {
            return false;
        }

        return $this->followers->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    /**
     * is_followed
     * @return Boolean
     */
    public function getIsFollowedAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->followings->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    /**
     * Follow通知作成
     */
    public function createNotificationFollow($id)
    {
        /*
        $notification = Notification::where('visiter_id', Auth::user()->id)
                                        ->where('visited_id', $id)
                                        ->where('action', 'follow')
                                        ->exists();
        */
        $noti = new Notification();
        $noti->visiter_id = Auth::user()->id;
        $noti->visited_id = $id;
        $noti->action = 'follow';
        $noti->save();
        /*
            Notification::firstOrCreate([
                'visiter_id', Auth::user()->id,
                'visited_id' => $id,
                'action' => 'follow',
            ]);
            */
    }
}
