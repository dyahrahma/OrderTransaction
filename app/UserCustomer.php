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
        $query->join('user_roles', 'users.email', '=', 'user_roles.email')
			->where('user_roles.role_id', '=', '2');
        return $query;
    }
}
