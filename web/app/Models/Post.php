<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'content', 'myid', 'platform'
    ];

    protected $visible = [
        'id', 'user_id','user', 'content', 'myid', 'platform',
        'updated_at'
    ];

    /**
     * userテーブル
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
