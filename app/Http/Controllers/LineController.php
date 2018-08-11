<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\Script;
use App\Line;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class LineController extends Controller
{
    public function store(Request $request)
    {
        try
        {
            $imei = $request->IMEI;
            $telephones = $request->Data_Num;
            $array = explode('|',$telephones);
            $r = Line::where('machine_code',$imei)->whereNotNull('user_id')->first();
            if(is_null($r))
                return array('code'=>201,'msg'=>'该机器码不存在');
            
            foreach($array as $item)
            {
                $r = new Line();
                $r->model = 'line';
                $r->machine_code = $imei;
                $r->telephone = $item;
                $r->save();
            }
            return array('code'=>200,'msg'=>'上传成功');
        }
        catch(\Exception $e)
        {
            return array('code'=>202,'msg'=>'上传失败');
        }
    }
    
    /**
     * 批量充值
     * @param Request $request
     */
    public function multiCharge(Request $request)
    {
        $ids = $request->multi;
        foreach ($ids as $id) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Line::find($id);
            } else {
                $r = Line::where('id', $id)
                             ->where('user_id', Admin::user()->id)->first();
            }
            
            if ( !$r ) return response()->json(array([
                                                         'code' => 201
                                                         , 'msg' => '该机器码不存在'
                                                     ]));
            
            $sc = Script::where('name', $r->model)->first();
            $user = AdminUser::find(Admin::user()->id);
            
            $used_money = $request->data['amount'] * $sc->rate;
            if ( $used_money > $user->balance )
                return response()->json(array([
                                                  'code' => 201
                                                  , 'msg' => '余额不足'
                                              ]));
            
            AdminUser::where('id', Admin::user()->id)
                     ->update([
                                  'balance' => $user->balance - $used_money
                              ]);
            
            //续费时结束时间小于当前时间
            $oldEndTime = $r->end_time;
            $currentTime = date("Y-m-d", time());
            $newEndTime = null;
            if ( $oldEndTime <= $currentTime ) {
                $newEndTime = date("Y-m-d", strtotime("{$currentTime} + {$request->data['amount']} day"));
            } else {
                $newEndTime = date("Y-m-d", strtotime("{$r->end_time} + {$request->data['amount']} day"));
            }
            Line::where('id', $id)
                    ->update([
                                 'end_time' => $newEndTime
                             ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
