<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/12/1
 * Time: 15:55
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model{
    protected $table = 'messages';

    //多对多
    public function comments()
    {
        return $this->morphMany('App\Models\Comment','commentable');
    }
}