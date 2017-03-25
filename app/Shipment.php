<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public function shipmentStatus()
    {
        return $this->hasMany('App\ShipmentStatus');
    }
}
