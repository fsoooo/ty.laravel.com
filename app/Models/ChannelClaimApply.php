<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelClaimApply extends Model{

    protected $table = "channel_claim_apply";
    //保单关联
    public function warrantyRule()
    {
        return $this->hasOne('App\Models\WarrantyRule','union_order_code', 'union_order_code');
    }
    //保单
    public function warranty()
    {
        return $this->hasOne('App\Models\Warranty','warranty_code', 'warranty_code');
    }
}
