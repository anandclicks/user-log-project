<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Posts;

class User extends Authenticatable
{
  protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    function user(){
      return $this->belongsTo(Posts::class);
    }
}

