<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Posts extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title', 'deps', 'image',];

    function user(){
        return $this->belongsTo(User::class);
    }
}
