<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\AdminUser;
use App\Script;
use App\Instagram;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);
        
        $r = Instagram::where('machine_code', $id)->first();
        if ( !$r )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '该机器码不存在'
                                     ]), JSON_UNESCAPED_UNICODE);
        if($r->end_time <= date('Y-m-d',time()))
            return json_encode(array(
                                   'code' => '203'
                                   ,'msg' => '该机器码已过期，请续费'
                               ),JSON_UNESCAPED_UNICODE);
        return json_encode(array([
                                     'Model' => $r->model,
                                     'thumb_prime' => $r->thumb_prime,
                                     'follow_prime' => $r->follow_prime,
                                     'message_prime' => $r->message_prime,
                                     'topic' => $r->topic,
                                     'thumb_count' => $r->thumb_count,
                                     'context' => $r->context,
                                     'pic_count' => $r->pic_count,
                                     'message' => $r->message,
                                     'interval' => $r->interval
                                 ]), JSON_UNESCAPED_UNICODE);
    }
    
    public function multiedit(Request $request)
    {

        $thumb_prime = isset($request->data['thumb_prime']) ? 'true' : 'false' ;
        $follow_prime = isset($request->data['follow_prime']) ? 'true' : 'false' ;
        $message_prime = isset($request->data['message_prime']) ? 'true' : 'false' ;
        $topic = $request->data['topic'];
        $thumb_count = $request->data['thumb_count'];
        $context = $request->data['context'];
        $pic_count = $request->data['pic_count'];
        $message = $request->data['message'];
        $interval = $request->data['interval'];
        $multiArray = $request->multi;
        
        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Instagram::find($item);
                if ( !is_null($thumb_prime) )
                    $r->thumb_prime = $thumb_prime;
                if ( !is_null($follow_prime) )
                    $r->follow_prime = $follow_prime;
                if ( !is_null($message_prime) )
                    $r->message_prime = $message_prime;
                if ( !is_null($topic) )
                    $r->topic = $topic;
                if ( !is_null($thumb_count) )
                    $r->thumb_count = $thumb_count;
                if ( !is_null($context) )
                    $r->context = $context;
                if ( !is_null($pic_count) )
                    $r->pic_count = $pic_count;
                if ( !is_null($message) )
                    $r->message = $message;
                if ( !is_null($interval) )
                    $r->interval = $interval;
                $r->save();
            } else
                try {
                    $r = Instagram::where('user_id',Admin::user()->id)->find($item);
                    if ( !is_null($thumb_prime) )
                        $r->thumb_prime = $thumb_prime;
                    if ( !is_null($follow_prime) )
                        $r->follow_prime = $follow_prime;
                    if ( !is_null($message_prime) )
                        $r->message_prime = $message_prime;
                    if ( !is_null($topic) )
                        $r->topic = $topic;
                    if ( !is_null($thumb_count) )
                        $r->thumb_count = $thumb_count;
                    if ( !is_null($context) )
                        $r->context = $context;
                    if ( !is_null($pic_count) )
                        $r->pic_count = $pic_count;
                    if ( !is_null($message) )
                        $r->message = $message;
                    if ( !is_null($interval) )
                        $r->interval = $interval;
                    $r->save();
                } catch (Exception $e) {
                    return response()->json(['status' => 'error', 'msg' => '无权操作']);
                }
        }
        return response()->json(['status'=>'ok'],200);
    }
    
    /**
     * 批量充值
     * @param Request $request
     */
    public function multiCharge(Request $request)
    {
        $ids = $request->multi;
        foreach($ids as $id)
        {
            if(Admin::user()->isRole('admin'))
            {
                $r = Instagram::find($id);
            }
            else
            {
                $r = Instagram::where('id',$id)
                         ->where('user_id',Admin::user()->id)->first();
            }
            
            if(!$r) return response()->json(array([
                                                      'code' => 201
                                                      ,'msg' => '该机器码不存在'
                                                  ]));
            
            $sc = Script::where('name',$r->model)->first();
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
            $oldEndTime = $r->end_time;
            $currentTime = date("Y-m-d",time());
            $newEndTime = null;
            if($oldEndTime <= $currentTime)
            {
                $newEndTime = date("Y-m-d",strtotime("{$currentTime} + {$request->data['amount']} day"));
            }
            else
            {
                $newEndTime = date("Y-m-d",strtotime("{$r->end_time} + {$request->data['amount']} day"));
            }
            Instagram::where('id',$id)
                ->update([
                             'end_time' => $newEndTime
                         ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
