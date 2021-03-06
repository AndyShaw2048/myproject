<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\Messenger;
use App\Script;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);

        $msg = Messenger::where('machine_code', $id)->first();
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
        return json_encode(array([
                                     "Model" => $msg->model
//                                     , "Area" => $msg->area
                                     , "AcceptRequest" => array([
                                                                    "PitchOn" => $msg->acceptrequest_bool == 'true' ? true : false
                                                                    , "Number" => $msg->acceptrequest_num
                                                                ])
                                     , "SendMessage" => array([
                                                                "PitchOn" => $msg->sendmessage_bool == 'true' ? true : false
                                                                , "Number" => $msg->sendmessage_num
                                                            ])
                                     , "AddFriend" => array([
                                                                   "PitchOn" => $msg->addfriend_bool == 'true' ? true : false
                                                                   , "Number" => $msg->addfriend_num
                                                               ])
                                     , "Content" => $msg->content
                                     , "IntervalTime" => $msg->intervaltime
                                     , "MutualFriend" => $msg->mutualfriend_num
                                 ]), JSON_UNESCAPED_UNICODE);
    }

    public function multiedit(Request $request)
    {
        $acceptRequestBool = isset($request->detail['acceptRequestBool']) ? 'true':'false';
        $acceptRequestNum = $request->detail['acceptRequestNum'];
        $sendMessageBool = isset($request->detail['sendMessageBool']) ? 'true':'false';
        $sendMessageNum = $request->detail['sendMessageNum'];
        $addFriendBool = isset($request->detail['addFriendBool']) ? 'true':'false';
        $addFriendNum = $request->detail['addFriendNum'];
        $content = $request->detail['content'];
        $intervalTime = $request->detail['intervalTime'];
        $mutualFriend = $request->detail['mutualFriend'];
//        $area = $request->detail['area'];
        $note = $request->detail['note'];
        $multiArray = $request->multi;

        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $msg = Messenger::find($item);
                if ( !is_null($acceptRequestBool) )
                    $msg->acceptrequest_bool = $acceptRequestBool;
                if ( !is_null($acceptRequestNum) )
                    $msg->acceptrequest_num = $acceptRequestNum;
                if ( !is_null($sendMessageBool) )
                    $msg->sendmessage_bool = $sendMessageBool;
                if ( !is_null($sendMessageNum) )
                    $msg->sendmessage_num = $sendMessageNum;
                if ( !is_null($addFriendBool) )
                    $msg->addfriend_bool = $addFriendBool;
                if ( !is_null($addFriendNum) )
                    $msg->addfriend_num = $addFriendNum;
                if ( !is_null($content) )
                    $msg->content = $content;
                if ( !is_null($intervalTime) )
                    $msg->intervaltime = $intervalTime;
                if ( !is_null($mutualFriend) )
                    $msg->mutualfriend_num = $mutualFriend;
//                if ( !is_null($area) )
//                    $msg->area = $area;
                if ( !is_null($note) )
                    $msg->note = $note;
                $msg->save();
            } else
                try {
                    $msg = Messenger::where('user_id',Admin::user()->id)->find($item);
                    if ( !is_null($acceptRequestBool) )
                        $msg->acceptrequest_bool = $acceptRequestBool;
                    if ( !is_null($acceptRequestNum) )
                        $msg->acceptrequest_num = $acceptRequestNum;
                    if ( !is_null($sendMessageBool) )
                        $msg->sendmessage_bool = $sendMessageBool;
                    if ( !is_null($sendMessageNum) )
                        $msg->sendmessage_num = $sendMessageNum;
                    if ( !is_null($addFriendBool) )
                        $msg->addfriend_bool = $addFriendBool;
                    if ( !is_null($addFriendNum) )
                        $msg->addfriend_num = $addFriendNum;
                    if ( !is_null($content) )
                        $msg->content = $content;
                    if ( !is_null($intervalTime) )
                        $msg->intervaltime = $intervalTime;
                    if ( !is_null($mutualFriend) )
                        $msg->mutualfriend_num = $mutualFriend;
//                    if ( !is_null($area) )
//                        $msg->area = $area;
                    if ( !is_null($note) )
                        $msg->note = $note;
                    $msg->save();
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
        foreach ($ids as $id) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Messenger::find($id);
            } else {
                $r = Messenger::where('id', $id)
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
            Messenger::where('id', $id)
                        ->update([
                                     'end_time' => $newEndTime
                                 ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
