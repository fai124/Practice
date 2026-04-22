<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Like;

class Comment extends Model
{
    protected $fillable = ['user_id', 'serv_id', 'comment', 'parent_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function serv(): BelongsTo 
    {
        return $this->belongsTo(Serv::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }
}
