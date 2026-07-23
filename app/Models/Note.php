<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Fragment\FragmentUriGenerator;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_public',
    ];
    
    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function sharedGroupTags()
    {
        return $this->belongsToMany(GroupTag::class, 'note_group_tag');
    }
}