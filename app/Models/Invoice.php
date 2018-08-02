<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public function users()
    {
        return $this->blongsTo('App\Models\User','id','user_id');
    }
}
