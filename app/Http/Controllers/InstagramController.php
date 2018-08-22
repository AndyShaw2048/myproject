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
                                     'auth_code' => $r->auth_code,
                                    'comment' => $r->comment,
                                    'topic' => $r->topic,
                                    'message' => $r->message,
                                    'images_num' => $r->images_num,
                                    'comment_images' => $r->comment_images,
                                    'interval_time' => $r->interval_time,
                                    'round_time' => $r->round_time,
                                 ]), JSON_UNESCAPED_UNICODE);
    }
    
    public function multiedit(Request $request)
    {
        $auth_code = $request->data['authCode'];
        $comment = $request->data['comment'];
        $topic = $request->data['topic'];
        $message = $request->data['message'];
        $images_num = $request->data['imagesNum'];
        $comment_images = $request->data['commentImages'];
        $interval_time = $request->data['intervalTime'];
        $round_time = $request->data['roundTime'];
        $multiArray = $request->multi;
        
        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Instagram::find($item);
                if ( !is_null($auth_code) )
                    $r->auth_code = $auth_code;
                if ( !is_null($comment) )
                    $r->comment = $comment;
                if ( !is_null($topic) )
                    $r->topic = $topic;
                if ( !is_null($message) )
                    $r->message = $message;
                if ( !is_null($images_num) )
                    $r->images_num = $images_num;
                if ( !is_null($comment_images) )
                    $r->comment_images = $comment_images;
                if ( !is_null($interval_time) )
                    $r->interval_time = $interval_time;
                if ( !is_null($round_time) )
                    $r->round_time = $round_time;
                $r->save();
            } else
                try {
                    $r = Instagram::where('user_id',Admin::user()->id)->find($item);
                    if ( !is_null($auth_code) )
                        $r->auth_code = $auth_code;
                    if ( !is_null($comment) )
                        $r->comment = $comment;
                    if ( !is_null($topic) )
                        $r->topic = $topic;
                    if ( !is_null($message) )
                        $r->message = $message;
                    if ( !is_null($images_num) )
                        $r->images_num = $images_num;
                    if ( !is_null($comment_images) )
                        $r->comment_images = $comment_images;
                    if ( !is_null($interval_time) )
                        $r->interval_time = $interval_time;
                    if ( !is_null($round_time) )
                        $r->round_time = $round_time;
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
