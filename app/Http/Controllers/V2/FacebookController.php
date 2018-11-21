<?php

namespace App\Http\Controllers\V2;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacebookController extends Controller
{
    protected $model = 'facebook';

    public function index()
    {
        return view("v2.$this->model.index");
    }

}
