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

    public function getCreatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function getUpdatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function getCaseFiType()
    {
        return $this->hasMany('App\Models\casesFiType', 'case_id');
    }

    public function getApplicationType()
    {
        return $this->hasOne('App\Models\ApplicationType', 'id', 'application_type');
    }

    public function getBank()
    {
        return $this->hasOne('App\Models\Bank', 'id', 'bank_id');
    }

    public function getProduct()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    public function getProductMap()
    {
        return $this->hasOne('App\Models\BankProductMapping', 'id', 'product_id');
    }
}
