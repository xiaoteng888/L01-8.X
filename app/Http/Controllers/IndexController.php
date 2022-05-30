<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QL\QueryList;

class IndexController extends Controller
{
    public function index()
    {

    }

    public function test()
    {
        $data = QueryList::get('baidu.com/s?wd=laravel')->rules([
            'title'=>array('h3','text'),
            'link'=>array('h3>a','href')
        ])->query()->getData();
        //打印结果
        print_r($data);
        return;
    }

}
