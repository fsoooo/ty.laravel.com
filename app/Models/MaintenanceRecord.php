<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    //保全记录表
    protected $table = 'maintenance_record';

    public function maintenance_record_user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    //保全记录关联保单表
    public function maintenance_record_warranty()
    {
        return $this->belongsTo('App\Models\Warranty','warranty_id','id');
    }
    //保全记录关联订单表
    public function maintenance_record_order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
    //保全记录关联被保人表，此关联用于查找删除的被保人信息
    public function maintenance_record_recognizee()
    {
        return $this->hasOne('App\Models\WarrantyRecognizee','id','change_content');
    }


}
