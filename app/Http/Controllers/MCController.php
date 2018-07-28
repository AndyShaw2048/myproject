<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\MCInfo;
use App\Script;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class MCController extends Controller
{
    public function multiedit(Request $request)
    {
        $mode = $request->detail['mode'];
        $keyword = $request->detail['keyword'];
        $matchingName = $request->detail['matchingName'];
        $relationName = $request->detail['relationName'];
        $note = $request->detail['note'];
        $multiArray = $request->multi;

        foreach($multiArray as $item)
        {
            if(Admin::user()->isRole('admin'))
            {
                $mc = MCInfo::find($item);
                if(!is_null($mode))
                    $mc->mode = $mode;
                if(!is_null($keyword))
                    $mc->mode = $keyword;
                if(!is_null($matchingName))
                    $mc->matching_name = $matchingName;
                if(!is_null($relationName))
                    $mc->relation_name = $relationName;
                if(!is_null($note))
                    $mc->note = $note;
                $mc->save();
            }
            else
            {
                try
                {
                    $mc = MCInfo::where('user_id',Admin::user()->id)->find($item);
                    if(!is_null($mode))
                        $mc->mode = $mode;
                    if(!is_null($keyword))
                        $mc->mode = $keyword;
                    if(!is_null($matchingName))
                        $mc->matching_name = $matchingName;
                    if(!is_null($relationName))
                        $mc->relation_name = $relationName;
                    if(!is_null($note))
                        $mc->note = $note;
                    $mc->save();
                }
                catch(Exception $e)
                {
                    return response()->json(['status'=>'error','msg'=>'你没有权限继续操作']);
                }

            }

        }

        return response()->json(['status'=>'ok'],200);
    }
    
    public function getMCInfo($id = null)
    {
        if(!$id)
            return abort('404');
        $mc = MCInfo::where('machine_code',$id)->first();
        if($mc == null)
            return json_encode(array(
                                        'code' => '202'
                                        ,'msg' => '该机器码不存在'
                                    ),JSON_UNESCAPED_UNICODE);
        if($mc->end_time <= date('Y-m-d',time()))
            return json_encode(array(
                                        'code' => '203'
                                        ,'msg' => '该机器码已过期，请续费'
                                    ),JSON_UNESCAPED_UNICODE);
        return json_encode(array(
            'model' => 'amazon'
            ,'select' => $mc->ModeInfo->name
            ,'keyword' => $mc->keyword
            ,'matching_product' => array([
                'name' => $mc->matching_name
                ,'prime' => $mc->m_prime == 'true' ? true:false
                                ])
            ,'relation_product' => array([
                 'name' => $mc->relation_name
                 ,'prime' => $mc->r_prime == 'true' ? true:false
                                         ])
                                ),JSON_UNESCAPED_UNICODE);
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
                $r = MCInfo::find($id);
            }
            else
            {
                $r = MCInfo::where('id',$id)
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
            MCInfo::where('id',$id)
                  ->update([
                               'end_time' => $newEndTime
                           ]);
        }
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }

}
