<?php

namespace App\Http\Controllers;

use App\Models\School;

class TestController extends Controller
{
    public function index()
    {
        $res = School::create([
            'name' => 'hahha',
            'address' => '流量卡聚隆科技凌凯',
            'enabled' => 1,
        ]);
        print_r($res);
    }
}
