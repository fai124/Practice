<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;

class Serv extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services')
            ->withPivot('service_date', 'id')
            ->withTimestamps();
    }
}
