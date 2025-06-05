<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Posts;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
  protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    function post(): HasMany
    {
      return $this->hasMany(Posts::class);
    }
}

