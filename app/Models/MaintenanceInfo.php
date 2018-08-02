<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceInfo extends Model
{
    //保全
    protected $table = 'maintenance_info';

    public function warranty_rule()
    {
        return $this->hasOne('App\Models\WarrantyRule','union_order_code','union_order_id');
    }
}
