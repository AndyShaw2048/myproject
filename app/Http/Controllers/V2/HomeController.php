<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //V2首页函数
    protected function index()
    {
        return view('v2.index');
    }
}
