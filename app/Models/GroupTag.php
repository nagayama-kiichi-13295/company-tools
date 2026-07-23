<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTag extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_group_tag');
    }
}