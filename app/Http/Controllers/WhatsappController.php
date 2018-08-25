<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\Script;
use App\Whatsapp;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function store(Request $request)
    {
        try
        {
            $imei = $request->IMEI;
            $telephones = $request->Data_Num;

            if ( !$imei )
                return json_encode(array([
                                             'code' => 202
                                             , 'msg' => '查询机器码不能为空'
                                         ]), JSON_UNESCAPED_UNICODE);

            $msg = Whatsapp::where('machine_code', $imei)->first();
            if ( !$msg )
                return json_encode(array([
                                             'code' => 202
                                             , 'msg' => '该机器码不存在'
                                         ]), JSON_UNESCAPED_UNICODE);
            if($msg->end_time <= date('Y-m-d',time()))
                return json_encode(array(
                                       'code' => '203'
                                       ,'msg' => '该机器码已过期，请续费'
                                   ),JSON_UNESCAPED_UNICODE);

            $array = explode('|',$telephones);
            $r = Whatsapp::where('machine_code',$imei)->whereNotNull('user_id')->first();
            if(is_null($r))
                return array('code'=>201,'msg'=>'该机器码不存在');

            foreach($array as $item)
            {
                if(is_null($item) || $item == '')continue;
                $r = new Whatsapp();
                $r->model = 'whatsapp';
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
                $r = Whatsapp::find($id);
            } else {
                $r = Whatsapp::where('id', $id)
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
            Whatsapp::where('id', $id)
                     ->update([
                                  'end_time' => $newEndTime
                              ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }

    public function multiedit(Request $request)
    {

        $terminology = $request->data['terminology'];
        $intervalTime = $request->data['intervalTime'];
        $note = $request->data['note'];
        $multiArray = $request->multi;

        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Whatsapp::find($item);
                if ( !is_null($terminology) )
                    $r->terminology = $terminology;
                if ( !is_null($intervalTime) )
                    $r->intervalTime = $intervalTime;
                if ( !is_null($note) )
                    $r->note = $note;
                $r->save();
            } else
                try {
                    $r = Whatsapp::where('user_id',Admin::user()->id)->find($item);
                    if ( !is_null($terminology) )
                        $r->terminology = $terminology;
                    if ( !is_null($intervalTime) )
                        $r->intervalTime = $intervalTime;
                    if ( !is_null($note) )
                        $r->note = $note;
                    $r->save();
                } catch (Exception $e) {
                    return response()->json(['status' => 'error', 'msg' => '无权操作']);
                }
        }
        return response()->json(['status'=>'ok'],200);
    }

    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);

        $msg = Whatsapp::where('machine_code', $id)->first();
        if ( !$msg )
            return json_encode(array([
                                         "exist" => false,
                                         'code' => 202
                                         , 'msg' => '该机器码不存在'
                                     ]), JSON_UNESCAPED_UNICODE);
        if($msg->end_time <= date('Y-m-d',time()))
            return json_encode(array(
                                   'code' => '203'
                                   ,'msg' => '该机器码已过期，请续费'
                               ),JSON_UNESCAPED_UNICODE);
        return json_encode(array([
                                     "exist" => true,
                                     "model" => $msg->model,
                                     "Message" => $msg->terminology,
                                     "interval" => $msg->interval_time
                                 ]), JSON_UNESCAPED_UNICODE);
    }
}
