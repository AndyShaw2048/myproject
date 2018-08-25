<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\FacebookInfo;
use App\FacebookInfoInfo;
use App\Script;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);
        $fb = FacebookInfo::where('machine_code', $id)->first();
        if ( !$fb )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '该机器码不存在'
                                     ]), JSON_UNESCAPED_UNICODE);
        if($fb->end_time <= date('Y-m-d',time()))
            return json_encode(array(
                                   'code' => '203'
                                   ,'msg' => '该机器码已过期，请续费'
                               ),JSON_UNESCAPED_UNICODE);
        return json_encode(array([
                                     "Model" => $fb->model
                                     , "Area" => $fb->area
                                     , "AddFriend" => array([
                                                                "PitchOn" => $fb->addfriend_bool == 'true' ? true : false
                                                                , "Number" => $fb->addfriend_num
                                                            ])
                                     , "AcceptRequest" => array([
                                                                    "PitchOn" => $fb->acceptrequest_bool == 'true' ? true : false
                                                                    , "Number" => $fb->acceptrequest_num
                                                                ])
                                     , "IntoGroup" => array([
                                                                "PitchOn" => $fb->intogroup_bool == 'true' ? true : false
                                                                , "GroupName" => $fb->intogroup_groupname
                                                                , "Number" => $fb->intogroup_number
                                                            ])
                                     , "PointZan" => array([
                                                               "PitchOn" => $fb->pointzan_bool == 'true' ? true : false
                                                               , "Number" => $fb->pointzan_num
                                                           ])
                                     , "AppointGroup" => array([
                                                                "PitchOn" => $fb->appointgroup_bool == 'true' ? true : false
                                                                , "GroupName" => $fb->appointgroup_bool
                                                                , "Number" => $fb->appointgroup_number
                                                            ])
                                     , "ContactAdd" => array([
                                                                   "PitchOn" => $fb->contactadd_bool == 'true' ? true : false
                                                                   , "Number" => $fb->contactadd_number
                                                               ])
                                     , "MutualFriend" => array([
                                                                   "PitchOn" => $fb->mutualfriend_bool == 'true' ? true : false
                                                                   , "Number" => $fb->mutualfriend_num
                                                               ])
                                     , "IntervalTime" => $fb->intervaltime_num
                                 ]), JSON_UNESCAPED_UNICODE);
    }
    
    public function multiedit(Request $request)
    {
        $addFriendBool = isset($request->detail['addFriendBool']) ? 'true':'false';
        $addFriendNum = $request->detail['addFriendNum'];
        $acceptRequestBool = isset($request->detail['acceptRequestBool']) ? 'true':'false';
        $acceptRequestNum = $request->detail['acceptRequestNum'];
        $intoGroupBool = isset($request->detail['intoGroupBool']) ? 'true':'false';
        $intoGroupName = $request->detail['intoGroupName'];
        $intoGroupNumber = $request->detail['$intoGroupNumber'];
        $pointZanBool = isset($request->detail['pointZanBool']) ? 'true':'false';
        $pointZanNum = $request->detail['pointZanNum'];
        $mutualFriendBool = isset($request->detail['mutualFriendBool']) ? 'true':'false';
        $mutualFriendNum = $request->detail['mutualFriendNum'];
        $appointGroupBool = isset($request->detail['appointGroupBool']) ? 'true':'false';
        $appointGroupName = $request->detail['appointGroupName'];
        $appointGroupNumber = $request->detail['appointGroupNumber'];
        $contactAddBool = isset($request->detail['contactAddBool']) ? 'true':'false';
        $contactAddNumber = $request->detail['contactAddNumber'];
        $intervalTimeNum = $request->detail['intervalTimeNum'];
        $area = $request->detail['area'];
        $note = $request->detail['note'];
        $multiArray = $request->multi;

        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $fb = FacebookInfo::find($item);
                if ( !is_null($addFriendBool) )
                    $fb->addfriend_bool = $addFriendBool;
                if ( !is_null($addFriendNum) )
                    $fb->addfriend_num = $addFriendNum;
                if ( !is_null($acceptRequestBool) )
                    $fb->acceptrequest_bool = $acceptRequestBool;
                if ( !is_null($acceptRequestNum) )
                    $fb->acceptrequest_num = $acceptRequestNum;
                if ( !is_null($intoGroupBool) )
                    $fb->intogroup_bool = $intoGroupBool;
                if ( !is_null($intoGroupName) )
                    $fb->intogroup_groupname = $intoGroupName;
                if ( !is_null($intoGroupNumber) )
                    $fb->intogroup_number = $intoGroupNumber;
                if ( !is_null($pointZanBool) )
                    $fb->pointzan_bool = $pointZanBool;
                if ( !is_null($pointZanNum) )
                    $fb->pointzan_num = $pointZanNum;
                if ( !is_null($mutualFriendBool) )
                    $fb->mutualfriend_bool = $mutualFriendBool;
                if ( !is_null($mutualFriendNum) )
                    $fb->mutualfriend_num = $mutualFriendNum;
                if ( !is_null($appointGroupBool) )
                    $fb->appointgroup_bool = $appointGroupBool;
                if ( !is_null($appointGroupName) )
                    $fb->appointgroup_name = $appointGroupName;
                if ( !is_null($appointGroupNumber) )
                    $fb->appointgroup_number = $appointGroupNumber;
                if ( !is_null($contactAddBool) )
                    $fb->contactadd_bool = $contactAddBool;
                if ( !is_null($contactAddNumber) )
                    $fb->contactadd_number = $contactAddNumber;
                if ( !is_null($intervalTimeNum) )
                    $fb->intervaltime_num = $intervalTimeNum;
                if ( !is_null($area) )
                    $fb->area = $area;
                if ( !is_null($note) )
                    $fb->note = $note;
                $fb->save();
            } else
                try {
                    $fb = FacebookInfo::where('id',Admin::user()->id)->find($item);
                    if ( !is_null($addFriendBool) )
                        $fb->addfriend_bool = $addFriendBool;
                    if ( !is_null($addFriendNum) )
                        $fb->addfriend_num = $addFriendNum;
                    if ( !is_null($acceptRequestBool) )
                        $fb->acceptrequest_bool = $acceptRequestBool;
                    if ( !is_null($acceptRequestNum) )
                        $fb->acceptrequest_num = $acceptRequestNum;
                    if ( !is_null($intoGroupBool) )
                        $fb->intogroup_bool = $intoGroupBool;
                    if ( !is_null($intoGroupName) )
                        $fb->intogroup_groupname = $intoGroupName;
                    if ( !is_null($intoGroupNumber) )
                        $fb->intogroup_number = $intoGroupNumber;
                    if ( !is_null($pointZanBool) )
                        $fb->pointzan_bool = $pointZanBool;
                    if ( !is_null($pointZanNum) )
                        $fb->pointzan_num = $pointZanNum;
                    if ( !is_null($mutualFriendBool) )
                        $fb->mutualfriend_bool = $mutualFriendBool;
                    if ( !is_null($mutualFriendNum) )
                        $fb->mutualfriend_num = $mutualFriendNum;
                    if ( !is_null($appointGroupBool) )
                        $fb->appointgroup_bool = $appointGroupBool;
                    if ( !is_null($appointGroupName) )
                        $fb->appointgroup_name = $appointGroupName;
                    if ( !is_null($appointGroupNumber) )
                        $fb->appointgroup_number = $appointGroupNumber;
                    if ( !is_null($contactAddBool) )
                        $fb->contactadd_bool = $contactAddBool;
                    if ( !is_null($contactAddNumber) )
                        $fb->contactadd_number = $contactAddNumber;
                    if ( !is_null($intervalTimeNum) )
                        $fb->intervaltime_num = $intervalTimeNum;
                    if ( !is_null($area) )
                        $fb->area = $area;
                    if ( !is_null($note) )
                        $fb->note = $note;
                    $fb->save();
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
                $r = FacebookInfo::find($id);
            }
            else
            {
                $r = FacebookInfo::where('id',$id)
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
            FacebookInfo::where('id',$id)
                  ->update([
                               'end_time' => $newEndTime
                           ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
