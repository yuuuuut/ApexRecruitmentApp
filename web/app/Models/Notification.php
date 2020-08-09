<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Auth;

class Notification extends Model
{
    protected $fillable = [
        'visiter_id', 'visited_id', 'action',
        'checked'
    ];

    protected $visible = [
        'visiter_id', 'visited_id', 'action',
        'checked', 'visiter', 'created_at'
    ];

    /**
     * usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function visiter()
    {
        return $this->belongsTo('App\Models\User', 'visiter_id', 'id');
    }

    /**
     * usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function visited()
    {
        return $this->belongsTo('App\Models\User', 'visited_id', 'id');
    }

    /**
     * 通知を既読済みにする
     */
    public static function verifiedNotification($notification)
    {
        if ($notification) {
            foreach ($notification as $n) {
                if (!$n->checked)
                    $n->checked = true;
                    $n->save();
            }
        }
    }

    /**
     * 既読から2日済みの通知を削除する
     */
    public static function deleteNotification($notification)
    {
        if ($notification) {
            foreach ($notification as $n) {
                if ($n->checked && Carbon::now() > $n->updated_at->addDays(2)) {
                    $n->delete();
                }
            }
        }
    }

}
