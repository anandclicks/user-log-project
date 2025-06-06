<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posts extends Model
{
    protected $table = 'posts';
    protected $fillable = ['deps', 'image',];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
