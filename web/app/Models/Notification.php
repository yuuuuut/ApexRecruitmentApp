<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'visiter_id', 'visited_id', 'action',
        'checked'
    ];

    protected $visible = [
        'visiter_id', 'visited_id', 'action',
        'checked', 'visiter'
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
}
