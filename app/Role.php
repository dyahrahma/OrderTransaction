<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users_role()
    {
        return $this->belongsToMany('App\User', 'user_roles');
    }
}
