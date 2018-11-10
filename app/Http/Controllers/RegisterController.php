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
            'password' => 'required|alpha_dash|confirmed',
            'invitation' => 'required'
        ];
        $msg = [
            'username.alpha_dash' => '用户名包含非法字符',
            'username.unique' => '用户名已存在',
            'password.alpha_dash' => '密码包含非法字符',
            'password.confirmed' => '两次输入密码不匹配',
            'invitation.required' => '请填写邀请码'
        ];
        $validator  = Validator::make($request->all(),$rules,$msg);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        //判断邀请码是否有效
        $code = DB::table('admin_users')->where('invitation_code',$request->invitation)->first();
        if(!$code) return redirect()->back()->withInput()->withErrors(['error' => '邀请码无效']);
//        if($code->user_id != null) return redirect()->back()->withInput()->withErrors(['error' => '邀请码已被使用']);

        $user = new AdminUser();
        $user->username = $request->username;
        $user->name = $request->username;
        $user->password = bcrypt($request->password);
        $user->balance = 0;
        $user->rate = '10';
        $user->up_id = $code->id;
        $user->invitation_code = substr(md5(time().rand()),1,6);
        $user->save();
//        DB::update("update invitation set user_id=?,used_time=? where code = ?",[$user->id,date('Y-m-d H:i:s',time()),$code->code]);
        DB::insert("insert into admin_role_users (role_id,user_id) VALUES (?,?)",[2,$user->id]);
        return redirect()->back()->withErrors(['msg' => '注册成功，请登录']);
    }
}
