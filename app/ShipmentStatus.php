<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    public function shipment()
    {
        return $this->belongsTo('App\Shipment');
    }
}
