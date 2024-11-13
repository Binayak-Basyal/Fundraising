<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin_info';

    protected $fillable = [
        'firstName', 'lastName', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function categories()
    // {
    //     return $this->hasMany(Category::class);
    // }
}
