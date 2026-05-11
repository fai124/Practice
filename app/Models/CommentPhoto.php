<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentPhoto extends Model
{
    protected $fillable = ['comment_id', 'photo'];

    public function comment()
    {
        return $this->belongsTo(\App\Models\Comment::class);
    }
}