<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use App\MCInfo;
use App\Rebate;
use App\Recharge;

use App\Script;
use App\Serial;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('用户充值');
            $logs = Recharge::where('user_id',Admin::user()->id)->orderBy('id','desc')->paginate(10);
            $content->body(view('recharge',['logs'=>$logs]));
        });
    }

    public function store(Request $request)
    {
        $sr = Serial::where('content',$request->serial['number'])->first();
        //序列号不存在
        if(is_null($sr))
            return response()->json(array([
                                              'code' => 201
                                              ,'msg' => '该序列号不存在'
                                          ]));

        if($sr->status == 1)
            return response()->json(array([
                                              'code' => 201
                                              ,'msg' => '该序列号已使用'
                                          ]));

        //添加记录至充值详情表
        $time = date('Y-m-d H:i:s',time());
        $user = AdminUser::find(Admin::user()->id);
        $log = new Recharge();
        $log->serial = $sr->content;
        $log->money = '+'.$sr->money;
        $log->user_id = Admin::user()->id;
        $log->pay_time = $time;
        $log->save();

        //添加记录至佣金返利表
        $rebate = new Rebate();
        $rebate->up_id = Admin::user()->up_id;
        $rebate->down_id = Admin::user()->id;
        $rebate->real_money = $sr->money;
        $rebate->return_money = $sr->money * Admin::user()->rate * 0.01;
        $rebate->save();

        //增加提现余额至上级用户
        $up = AdminUser::find(Admin::user()->up_id);
        $money = ($sr->money * Admin::user()->rate * 0.01) + $up->rebate_money;
        DB::update('update admin_users set rebate_money = ? where id = ?',[$money,$up->id]);

        Serial::where('content',$request->serial['number'])
            ->update([
                'user_id'=>Admin::user()->id
                ,'used_time'=>$time
                ,'status'=>1
                     ]);

        AdminUser::where('id',Admin::user()->id)
            ->update([
                'balance'=>$user->balance + $sr->money
                     ]);

        return response()->json(array([
            'code' => 200
                                      ]));
    }


    /**
     * 续费操作，根据机器码ID进行续费
     *
     * @param null $id
     * @return Content|void
     */
    private $mc = null;
    private $id;

    public function renewalIndex($id=null)
    {
        $this->id = $id;
        if(!$id) return abort('404');

        $this->mc = MCInfo::where('id',$id)->where('user_id',Admin::user()->id)->first();
        if(is_null($this->mc))
            return abort('404');

        return Admin::content(function(Content $content) {
            $content->header('Amazon模块');
            $content->body(view('renewal',['mc'=>$this->mc,'id'=>$this->id]));
        });
    }

    public function renewalStore(Request $request)
    {
        $mc = MCInfo::where('machine_code',$request->data['machine_code'])
                    ->where('user_id',Admin::user()->id)->first();
        if(!$mc) return response()->json(array([
            'code' => 201
            ,'msg' => '该机器码不存在'
                                               ]));

        $sc = Script::where('name',$mc->model)->first();
        $user = AdminUser::find(Admin::user()->id);

        $used_money = $request->data['amount'] * $sc->rate;
        if($used_money > $user->balance)
            return response()->json(array([
                           'code' => 201
                           ,'msg' => '余额不足'
                                          ]));

        AdminUser::where('id',Admin::user()->id)
                 ->update([
                     'balance' => $user->balance - $used_money
                          ]);

        //续费时结束时间小于当前时间
        $oldEndTime = $mc->end_time;
        $currentTime = date("Y-m-d",time());
        $newEndTime = null;
        if($oldEndTime <= $currentTime)
        {
            $newEndTime = date("Y-m-d",strtotime("{$currentTime} + {$request->data['amount']} day"));
        }
        else
        {
            $newEndTime = date("Y-m-d",strtotime("{$mc->end_time} + {$request->data['amount']} day"));
        }
        MCInfo::where('id',$request->data['mc_id'])
              ->update([
                  'end_time' => $newEndTime
                       ]);

        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
