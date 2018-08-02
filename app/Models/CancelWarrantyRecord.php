<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelWarrantyRecord extends Model
{
    //
    protected $table = 'cancel_warranty_record';

    public function cancel_order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
}
