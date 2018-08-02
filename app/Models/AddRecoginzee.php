<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/9/13
 * Time: 11:40
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AddRecoginzee extends Model{
    protected $table='add_recognizee';

    public function product()
    {
        return $this->belongsTo('App\Models\Product','project','ty_product_id');
    }

}