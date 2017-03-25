<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function coupon()
    {
        return $this->belongsto('App\Coupon');
    }

    public function shipment()
    {
        return $this->belongsto('App\Shipment');
    }
}
