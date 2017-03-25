<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'is_finalized', 'date_order',
    ];

    public function coupon()
    {
        return $this->belongsto('App\Coupon');
    }

    public function shipment()
    {
        return $this->belongsto('App\Shipment');
    }

    public function user()
    {
        return $this->belongsto('App\User');
    }
}
