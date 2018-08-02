<?php
/**
 * Created by PhpStorm.
 * User: wangsl
 * Date: 2018/01/10
 * Time: 10:05
 */
namespace App\Helper;

class ErrorNotice{
    //可以填写提示信息，跳转路由，自动跳转时间等
    //URL  可以为固定路由，比如首页:/,产品列表页:/product_list
    //URl  也可以是数值，window.history.go(-1)，回退多少页
    static public function error($notice = '',$url = '/',$sec = '5')
    {
        return view('error.error')
            ->with('notice',$notice)
            ->with('url',$url)
            ->with('sec',$sec)
            ->render();
    }
}









