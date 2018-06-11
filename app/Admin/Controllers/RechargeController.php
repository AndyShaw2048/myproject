<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use App\MCInfo;
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

        $time = date('Y-m-d H:i:s',time());
        $user = AdminUser::find(Admin::user()->id);
        $log = new Recharge();
        $log->serial = $sr->content;
        $log->money = '+'.$sr->money;
        $log->user_id = Admin::user()->id;
        $log->pay_time = $time;
        $log->save();

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

    private $mc = null;
    private $id;
    //续费操作
    public function renewalIndex($id=null)
    {
        $this->id = $id;
        if(!$id) return abort('404');

        $this->mc = MCInfo::where('id',$id)->where('user_id',Admin::user()->id)->first();
        if(is_null($this->mc))
            return abort('404');

        return Admin::content(function(Content $content) {
            $content->header('用户续费');
            $content->body(view('renewal',['mc'=>$this->mc,'id'=>$this->id]));
        });
    }

    public function renewalStore(Request $request)
    {
        $mc = MCInfo::where('machine_code',$request->data['machine_code'])
                    ->where('kind',session()->get('kind'))
                    ->where('user_id',Admin::user()->id)->first();
        if(!$mc) return response()->json(array([
            'code' => 201
            ,'msg' => '该机器码不存在'
                                               ]));

        $sc = Script::where('name',session()->get('kind'))->first();
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
