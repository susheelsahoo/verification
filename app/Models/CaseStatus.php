<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CaseStatus extends Authenticatable
{
    use Notifiable;

    protected $table = 'case_status';

    protected $fillable = [
        'name', 'status',
    ];

    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
