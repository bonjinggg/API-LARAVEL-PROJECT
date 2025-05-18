<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];
}
