<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    //
    protected $table = 'flow';

  public function node()
  {
      return $this->hasMany('App\Models\Node','flow_id','id');
  }


}
