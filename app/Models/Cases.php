<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cases extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
