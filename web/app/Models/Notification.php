<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'visiter_id', 'visited_id', 'action'
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
}
