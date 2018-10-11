<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\AmazonThr;
use App\Script;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class AmazonThrController extends Controller
{
    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);
        $r = AmazonThr::where('machine_code', $id)->first();
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
                                     ,'Run1' => $r->first_run
                                     ,'Run2' => $r->second_run
                                     ,'Run3' => $r->third_run
                                     ,'Run4' => $r->fourth_run
                                     ,'Run5' => $r->fifth_run
                                     ,'Run_Speed' => $r->run_speed
                                     ,'Run_Times' => $r->run_times
                                     ,'Timing_time' => $r->timing_run_hours.':'.$r->timing_run_minutes
                                     ,'Each_Time_Interval:' => $r->each_time_interval

                                     , 'Auto_Buy' => array([
                                                                "Prime" => $r->auto_buy_prime == 'true' ? true : false
                                                                , "Keyword" => $r->auto_buy_keyword
                                                                , "Item" => $r->auto_buy_item
                                                            ])
                                     , 'Relevance_Item' => array([
                                                               "Prime" => $r->relevance_item_prime == 'true' ? true : false
                                                               , "Keyword_1" => $r->relevance_item_keyword_one
                                                               , "Item_1" => $r->relevance_item_item_one
                                                               , "Keyword_2" => $r->relevance_item_keyword_two
                                                               , "Item_2" => $r->relevance_item_item_two
                                                           ])
                                     , 'Sponsored' => array([
                                                               "Prime" => $r->sponsored_prime == 'true' ? true : false
                                                               , "Keyword" => $r->sponsored_keyword
                                                           ])
                                     , 'Keyword_Top' => array([
                                                               "Prime" => $r->keyword_top_prime == 'true' ? true : false
                                                               , "Keyword" => $r->keyword_top_keyword
                                                               , "Item" => $r->keyword_top_item
                                                           ])
                                     , 'Delete_Review' => array([
                                                                   "Prime" => $r->delete_review_prime == 'true' ? true : false
                                                                   , "Keyword" => $r->delete_review_keyword
                                                                   , "Item" => $r->delete_review_item
                                                               ])
                                     , 'Leave_A_Review' => array([
                                                                    "Prime" => $r->leave_review_prime == 'true' ? true : false
                                                                    , "Keyword" => $r->leave_review_keyword
                                                                    , "Item" => $r->leave_review_item
                                                                    , "Star" => $r->leave_review_star
                                                                    , "Contact" => $r->leave_review_contact
                                                                    , "Title" => $r->leave_review_title
                                                                ])
                                     ,'note' => $r->note
                                 ]), JSON_UNESCAPED_UNICODE);
    }
    public function multiedit(Request $request)
    {
        $first_run = $request->data['first_run'];
        $second_run = $request->data['second_run'];
        $third_run = $request->data['third_run'];
        $fourth_run = $request->data['fourth_run'];
        $fifth_run = $request->data['fifth_run'];
        $run_speed = $request->data['run_speed'];
        $run_times = $request->data['run_times'];
        $timing_run_hours = $request->data['timing_run_hours'];
        $timing_run_minutes = $request->data['timing_run_minutes'];
        $each_time_interval = $request->data['each_time_interval'];
        $auto_buy_prime = isset( $request->data['auto_buy_prime'] ) ? 'true' : 'false';
        $auto_buy_keyword = $request->data['auto_buy_keyword'];
        $auto_buy_item = $request->data['auto_buy_item'];
        $relevance_item_prime = isset( $request->data['relevance_item_prime'] ) ? 'true' : 'false';
        $relevance_item_keyword_one = $request->data['relevance_item_keyword_one'];
        $relevance_item_item_one = $request->data['relevance_item_item_one'];
        $relevance_item_keyword_two = $request->data['relevance_item_keyword_two'];
        $relevance_item_item_two = $request->data['relevance_item_item_two'];
        $sponsored_prime = isset( $request->data['sponsored_prime'] ) ? 'true' : 'false';
        $sponsored_keyword = $request->data['sponsored_keyword'];
        $keyword_top_prime = isset( $request->data['keyword_top_prime'] ) ? 'true' : 'false';
        $keyword_top_keyword = $request->data['keyword_top_keyword'];
        $keyword_top_item = $request->data['keyword_top_item'];
        $delete_review_prime = isset( $request->data['delete_review_prime'] ) ? 'true' : 'false';
        $delete_review_keyword = $request->data['delete_review_keyword'];
        $delete_review_item = $request->data['delete_review_item'];
        $leave_review_prime = isset( $request->data['leave_review_prime'] ) ? 'true' : 'false';
        $leave_review_keyword = $request->data['leave_review_keyword'];
        $leave_review_item = $request->data['leave_review_item'];
        $leave_review_star = $request->data['leave_review_star'];
        $leave_review_contact = $request->data['leave_review_contact'];
        $leave_review_title = $request->data['leave_review_title'];
        $note = $request->data['note'];
        $multiArray = $request->multi;
        
        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $r = AmazonThr::find($item);
                if ( !is_null($first_run) )
                    $r->first_run = $first_run;
                if ( !is_null($second_run) )
                    $r->second_run = $second_run;
                if ( !is_null($third_run) )
                    $r->third_run = $third_run;
                if ( !is_null($fourth_run) )
                    $r->fourth_run = $fourth_run;
                if ( !is_null($fifth_run) )
                    $r->fifth_run = $fifth_run;
                if ( !is_null($run_speed) )
                    $r->run_speed = $run_speed;
                if ( !is_null($run_times) )
                    $r->run_times = $run_times;
                if ( !is_null($timing_run_hours) )
                    $r->timing_run_hours = $timing_run_hours;
                if ( !is_null($timing_run_minutes) )
                    $r->timing_run_minutes = $timing_run_minutes;
                if ( !is_null($each_time_interval) )
                    $r->each_time_interval = $each_time_interval;
                if ( !is_null($auto_buy_prime) )
                    $r->auto_buy_prime = $auto_buy_prime;
                if ( !is_null($auto_buy_keyword) )
                    $r->auto_buy_keyword = $auto_buy_keyword;
                if ( !is_null($auto_buy_item) )
                    $r->auto_buy_item = $auto_buy_item;
                if ( !is_null($relevance_item_prime) )
                    $r->relevance_item_prime = $relevance_item_prime;
                if ( !is_null($relevance_item_keyword_one) )
                    $r->relevance_item_keyword_one = $relevance_item_keyword_one;
                if ( !is_null($relevance_item_item_one) )
                    $r->relevance_item_item_one = $relevance_item_item_one;
                if ( !is_null($relevance_item_keyword_two) )
                    $r->relevance_item_keyword_two = $relevance_item_keyword_two;
                if ( !is_null($relevance_item_item_two) )
                    $r->relevance_item_item_two = $relevance_item_item_two;
                if ( !is_null($sponsored_prime) )
                    $r->sponsored_prime = $sponsored_prime;
                if ( !is_null($sponsored_keyword) )
                    $r->sponsored_keyword = $sponsored_keyword;
                if ( !is_null($keyword_top_prime) )
                    $r->keyword_top_prime = $keyword_top_prime;
                if ( !is_null($keyword_top_keyword) )
                    $r->keyword_top_keyword = $keyword_top_keyword;
                if ( !is_null($keyword_top_item) )
                    $r->keyword_top_item = $keyword_top_item;
                if ( !is_null($delete_review_prime) )
                    $r->delete_review_prime = $delete_review_prime;
                if ( !is_null($delete_review_keyword) )
                    $r->delete_review_keyword = $delete_review_keyword;
                if ( !is_null($leave_review_prime) )
                    $r->leave_review_prime = $leave_review_prime;
                if ( !is_null($leave_review_keyword) )
                    $r->leave_review_keyword = $leave_review_keyword;
                if ( !is_null($leave_review_item) )
                    $r->leave_review_item = $leave_review_item;
                if ( !is_null($leave_review_star) )
                    $r->leave_review_star = $leave_review_star;
                if ( !is_null($leave_review_contact) )
                    $r->leave_review_contact = $leave_review_contact;
                if ( !is_null($leave_review_title) )
                    $r->leave_review_title = $leave_review_title;
                if ( !is_null($note) )
                    $r->note = $note;
                $r->save();
            } else
                try {
                    $r = AmazonThr::find($item);
                    if ( !is_null($first_run) )
                        $r->first_run = $first_run;
                    if ( !is_null($second_run) )
                        $r->second_run = $second_run;
                    if ( !is_null($third_run) )
                        $r->third_run = $third_run;
                    if ( !is_null($fourth_run) )
                        $r->fourth_run = $fourth_run;
                    if ( !is_null($fifth_run) )
                        $r->fifth_run = $fifth_run;
                    if ( !is_null($run_speed) )
                        $r->run_speed = $run_speed;
                    if ( !is_null($run_times) )
                        $r->run_times = $run_times;
                    if ( !is_null($timing_run_hours) )
                        $r->timing_run_hours = $timing_run_hours;
                    if ( !is_null($timing_run_minutes) )
                        $r->timing_run_minutes = $timing_run_minutes;
                    if ( !is_null($each_time_interval) )
                        $r->each_time_interval = $each_time_interval;
                    if ( !is_null($auto_buy_prime) )
                        $r->auto_buy_prime = $auto_buy_prime;
                    if ( !is_null($auto_buy_keyword) )
                        $r->auto_buy_keyword = $auto_buy_keyword;
                    if ( !is_null($auto_buy_item) )
                        $r->auto_buy_item = $auto_buy_item;
                    if ( !is_null($relevance_item_prime) )
                        $r->relevance_item_prime = $relevance_item_prime;
                    if ( !is_null($relevance_item_keyword_one) )
                        $r->relevance_item_keyword_one = $relevance_item_keyword_one;
                    if ( !is_null($relevance_item_item_one) )
                        $r->relevance_item_item_one = $relevance_item_item_one;
                    if ( !is_null($relevance_item_keyword_two) )
                        $r->relevance_item_keyword_two = $relevance_item_keyword_two;
                    if ( !is_null($relevance_item_item_two) )
                        $r->relevance_item_item_two = $relevance_item_item_two;
                    if ( !is_null($sponsored_prime) )
                        $r->sponsored_prime = $sponsored_prime;
                    if ( !is_null($sponsored_keyword) )
                        $r->sponsored_keyword = $sponsored_keyword;
                    if ( !is_null($keyword_top_prime) )
                        $r->keyword_top_prime = $keyword_top_prime;
                    if ( !is_null($keyword_top_keyword) )
                        $r->keyword_top_keyword = $keyword_top_keyword;
                    if ( !is_null($keyword_top_item) )
                        $r->keyword_top_item = $keyword_top_item;
                    if ( !is_null($delete_review_prime) )
                        $r->delete_review_prime = $delete_review_prime;
                    if ( !is_null($delete_review_keyword) )
                        $r->delete_review_keyword = $delete_review_keyword;
                    if ( !is_null($delete_review_item) )
                        $r->delete_review_item = $delete_review_item;
                    if ( !is_null($leave_review_prime) )
                        $r->leave_review_prime = $leave_review_prime;
                    if ( !is_null($leave_review_keyword) )
                        $r->leave_review_keyword = $leave_review_keyword;
                    if ( !is_null($leave_review_item) )
                        $r->leave_review_item = $leave_review_item;
                    if ( !is_null($leave_review_star) )
                        $r->leave_review_star = $leave_review_star;
                    if ( !is_null($leave_review_contact) )
                        $r->leave_review_contact = $leave_review_contact;
                    if ( !is_null($leave_review_title) )
                        $r->leave_review_title = $leave_review_title;
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
                $r = AmazonThr::find($id);
            }
            else
            {
                $r = AmazonThr::where('id',$id)
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
            AmazonThr::where('id',$id)
                  ->update([
                               'end_time' => $newEndTime
                           ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
