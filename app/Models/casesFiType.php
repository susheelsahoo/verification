<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class casesFiType extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'case_id', 'fi_type_id', 'mobile', 'user_id', 'address', 'pincode', 'land_mark',
    ];

    public function getUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public function getCase()
    {
        return $this->belongsTo('App\Models\cases', 'case_id', 'id');
    }
}
