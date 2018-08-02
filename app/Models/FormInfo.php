<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormInfo extends Model
{
      protected $table = 'form_info';
      public function prepareParameter()
      {
          return $this->hasOne('App\Models\OrderPrepareParameter','order_prepare_parameter_id','id');
      }
}
