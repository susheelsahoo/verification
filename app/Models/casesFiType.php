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

    public function getUser(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function getCase(){
        return $this->belongsTo('App\Models\Cases', 'case_id', 'id');
    }

    public function getCaseFiType(){
        return $this->hasMany('App\Models\casesFiType','case_id');
    }

    // public function getFiType(){
    //     return $this->hasMany('App\Models\FiType','id','fi_type_id');
    // }

    public function getFiType(){
        return $this->hasOne('App\Models\FiType','id','fi_type_id');
    }

    public function getCaseStatus(){
        return $this->hasOne('App\Models\CaseStatus','id','sub_status');
    }



}
