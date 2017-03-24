<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'users';
    
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address',
    ];
	
	protected $hidden = [
        'password'
    ];

    public function newQuery() // override query builder result for eloquent
    {
        $query = parent::newQuery();
        $query->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', '=', '2');
        return $query;
    }
}
