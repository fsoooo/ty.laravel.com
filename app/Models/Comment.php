<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/11/20
 * Time: 14:45
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $table = 'comment';
    
    //多态
    public function commentable()
    {
        return $this->morphTo();
    }
}