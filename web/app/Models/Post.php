<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'content', 'myid', 'platform',
        'legend', 'private'
    ];

    protected $visible = [
        'id', 'user_id','user', 'content', 'myid', 'platform',
        'legend', 'private', 'updated_at'
    ];

    /**
     * userテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Follower投稿通知作成
     */
    public static function createNotificationFollowerPost()
    {
        $follower = Auth::user()->followers()->get();

        if ($follower) {
            foreach ($follower as $f) {
                Notification::firstOrCreate([
                    'visiter_id' => Auth::user()->id,
                    'visited_id' => $f->id,
                    'action' => 'post'
                ]);
            }
        }
    }

}
