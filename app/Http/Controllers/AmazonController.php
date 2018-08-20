<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\Amazon;
use App\AmazonInfo;
use App\Script;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class AmazonController extends Controller
{
    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);
        $r = Amazon::where('machine_code', $id)->first();
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
                                     "Model" => $r->model
                                     , "Area" => $r->area
                                     , "AddFriend" => array([
                                                                "PitchOn" => $r->addfriend_bool == 'true' ? true : false
                                                                , "Number" => $r->addfriend_num
                                                            ])
                                     , "AcceptRequest" => array([
                                                                    "PitchOn" => $r->acceptrequest_bool == 'true' ? true : false
                                                                    , "Number" => $r->acceptrequest_num
                                                                ])
                                     , "IntoGroup" => array([
                                                                "PitchOn" => $r->intogroup_bool == 'true' ? true : false
                                                                , "GroupName" => $r->intogroup_groupname
                                                            ])
                                     , "PointZan" => array([
                                                               "PitchOn" => $r->pointzan_bool == 'true' ? true : false
                                                               , "Number" => $r->pointzan_num
                                                           ])
                                     , "MutualFriend" => array([
                                                                   "PitchOn" => $r->mutualfriend_bool == 'true' ? true : false
                                                                   , "Number" => $r->mutualfriend_num
                                                               ])
                                     , "IntervalTime" => $r->intervaltime_num
                                 ]), JSON_UNESCAPED_UNICODE);
    }
    public function multiedit(Request $request)
    {
        $mode = $request->data['mode'];
        $keyword = $request->data['keyword'];
        $m_prime = isset($request->data['mPrime']) ? 'true' : 'false' ;
        $matching_name = $request->data['matchingName'];
        $r_prime = isset($request->data['rPrime']) ? 'true' : 'false' ;
        $relation_name = $request->data['relationName'];
        $interval_minute = $request->data['intervalMinute'];
        $interval_second = $request->data['intervalSecond'];
        $vpn = $request->data['vpn'];
        $street = $request->data['street'];
        $city = $request->data['city'];
        $state = $request->data['state'];
        $zip = $request->data['zip'];
        $contact = $request->data['contact'];
        $card_num = $request->data['cardNum'];
        $end_month = $request->data['endMonth'];
        $end_year = $request->data['endYear'];
        $note = $request->data['note'];
        $multiArray = $request->multi;
        
        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Amazon::find($item);
                if ( !is_null($mode) )
                    $r->mode = $mode;
                if ( !is_null($keyword) )
                    $r->keyword = $keyword;
                if ( !is_null($m_prime) )
                    $r->m_prime = $m_prime;
                if ( !is_null($matching_name) )
                    $r->matching_name = $matching_name;
                if ( !is_null($r_prime) )
                    $r->r_prime = $r_prime;
                if ( !is_null($relation_name) )
                    $r->relation_name = $relation_name;
                if ( !is_null($interval_minute) )
                    $r->interval_minute = $interval_minute;
                if ( !is_null($interval_second) )
                    $r->interval_second = $interval_second;
                if ( !is_null($vpn) )
                    $r->vpn = $vpn;
                if ( !is_null($street) )
                    $r->street = $street;
                if ( !is_null($city) )
                    $r->city = $city;
                if ( !is_null($state) )
                    $r->state = $state;
                if ( !is_null($zip) )
                    $r->zip = $zip;
                if ( !is_null($contact) )
                    $r->contact = $contact;
                if ( !is_null($card_num) )
                    $r->card_num = $card_num;
                if ( !is_null($end_month) )
                    $r->end_month = $end_month;
                if ( !is_null($end_year) )
                    $r->end_year = $end_year;
                if ( !is_null($note) )
                    $r->note = $note;
                $r->save();
            } else
                try {
                    $r = Amazon::find($item);
                    if ( !is_null($mode) )
                        $r->mode = $mode;
                    if ( !is_null($keyword) )
                        $r->keyword = $keyword;
                    if ( !is_null($m_prime) )
                        $r->m_prime = $m_prime;
                    if ( !is_null($matching_name) )
                        $r->matching_name = $matching_name;
                    if ( !is_null($r_prime) )
                        $r->r_prime = $r_prime;
                    if ( !is_null($relation_name) )
                        $r->relation_name = $relation_name;
                    if ( !is_null($interval_minute) )
                        $r->interval_minute = $interval_minute;
                    if ( !is_null($interval_second) )
                        $r->interval_second = $interval_second;
                    if ( !is_null($vpn) )
                        $r->vpn = $vpn;
                    if ( !is_null($street) )
                        $r->street = $street;
                    if ( !is_null($city) )
                        $r->city = $city;
                    if ( !is_null($state) )
                        $r->state = $state;
                    if ( !is_null($zip) )
                        $r->zip = $zip;
                    if ( !is_null($contact) )
                        $r->contact = $contact;
                    if ( !is_null($card_num) )
                        $r->card_num = $card_num;
                    if ( !is_null($end_month) )
                        $r->end_month = $end_month;
                    if ( !is_null($end_year) )
                        $r->end_year = $end_year;
                    if ( !is_null($note) )
                        $r->note = $note;
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
                $r = Amazon::find($id);
            }
            else
            {
                $r = Amazon::where('id',$id)
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
            Amazon::where('id',$id)
                        ->update([
                                     'end_time' => $newEndTime
                                 ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
