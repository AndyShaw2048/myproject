<?php

namespace App\Http\Controllers;

use App\FacebookInfo;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function getInfo($id = null)
    {
        if(!$id)
            return json_encode(array([
                'code' => 202
                ,'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);

        $fb = FacebookInfo::where('machine_code',$id)->first();
        if(!$fb)
            return json_encode(array([
                 'code' => 202
                 ,'msg' => '该机器码不存在'
                                     ]), JSON_UNESCAPED_UNICODE);
        return json_encode(array([
                 "Model" => $fb->model
                 ,"Area" => $fb->area
                 ,"AddFriend" => array([
                             "PitchOn" => $fb->addfriend_bool
                             ,"Number" => $fb->addfriend_num
                                       ])
                 ,"AcceptRequest" => array([
                                           "PitchOn" => $fb->acceptrequest_bool
                                           ,"Number" => $fb->acceptrequest_num
                                       ])
                 ,"IntoGroup" => array([
                                           "PitchOn" => $fb->intogroup_bool
                                           ,"GroupNmae" => $fb->intogroup_groupname
                                       ])
                 ,"PointZan" => array([
                                           "PitchOn" => $fb->pointzan_bool
                                           ,"Number" => $fb->pointzan_num
                                       ])
                 ,"MutualFriend" => array([
                                          "PitchOn" => $fb->mutualfriend_bool
                                          ,"Number" => $fb->mutualfriend_num
                                      ])
                 ,"IntervalTime" => $fb->intervaltime_num
                                 ]), JSON_UNESCAPED_UNICODE);
    }
}
