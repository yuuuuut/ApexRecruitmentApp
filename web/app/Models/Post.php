<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
