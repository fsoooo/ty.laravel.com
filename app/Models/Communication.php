<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/11/22
 * Time: 11:18
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model{
    protected $table = 'communication';

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','ty_product_id','ty_product_id');
    }
}