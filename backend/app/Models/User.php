<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'username', 'password', 'role', 'api_token'];

    protected $hidden = ['password', 'api_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }
}
