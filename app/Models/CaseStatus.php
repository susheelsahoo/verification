<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

class CaseStatus extends Model
{
    protected $table = 'case_status';
    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];
=======
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
>>>>>>> f140f7f2f6fd15dd89d4da25c8f8270fa4b1128f
}
