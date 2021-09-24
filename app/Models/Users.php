<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = "id";

    public function user_role(){
        return $this->belongsTo(\App\Models\Roles::class, 'role_id', 'id');
    }
}
