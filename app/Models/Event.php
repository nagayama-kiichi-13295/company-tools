<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'held_at',
    ];

    protected $casts = [
        'held_at' => 'datetime',
    ];

    // 作成者 (管理者)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 参加者
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}
