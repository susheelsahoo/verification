<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class casesFiType extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'case_id', 'fi_type_id', 'mobile', 'address', 'pincode', 'land_mark',
    ];
}
