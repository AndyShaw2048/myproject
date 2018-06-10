<?php

namespace App\Http\Controllers;

use App\AdminUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|alpha_dash|unique:admin_users',
            'password' => 'required|alpha_dash|confirmed'
        ];
        $msg = [
            'username.alpha_dash' => '用户名包含非法字符',
            'username.unique' => '用户名已存在',
            'password.alpha_dash' => '密码包含非法字符',
            'password.confirmed' => '两次输入密码不匹配',
        ];
        $validator  = Validator::make($request->all(),$rules,$msg);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = new AdminUser();
        $user->username = $request->username;
        $user->name = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();
        DB::insert("insert into admin_role_users (role_id,user_id) VALUES (?,?)",[2,$user->id]);
        return redirect()->back()->withErrors(['msg' => '注册成功，请登录']);
    }
}
