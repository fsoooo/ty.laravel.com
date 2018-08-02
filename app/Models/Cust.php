<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 15:36
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Cust extends Model{
    protected $table="cust";

    protected $fillable = [
        'name', 'code', 'email', 'occupation', 'type', 'id_type', 'phone', 'other',
        'company_name', 'is_three_company', 'organization_code', 'license_code', 'tax_code',
        'province', 'city', 'county', 'street_address', 'license_image', 'cust_from', 'status',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cust_rule()
    {
        return $this->hasOne('App\Models\CustRule','code','code');
    }

    public function cust_warranty_recognizee()
    {
        return $this->hasMany('App\Models\WarrantyRecognizee','code');
    }
}
