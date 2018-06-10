<?php

namespace App\Http\Controllers;

use App\MCInfo;
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
    
    public function getMCInfo($kind = null,$id = null)
    {
        if(!($kind || $id))
            return 'false';
        $mc = MCInfo::where('machine_code',$id)
                    ->where('kind',$kind)->first();
        if($mc == null)
            return response()->json(array(
                                        'code' => '202'
                                        ,'msg' => '该机器码不存在'
                                    ));
        if($mc->end_time < date('Y-m-d',time()))
            return response()->json(array(
                                        'code' => '203'
                                        ,'msg' => '该机器码已过期，请续费'
                                    ));
        return response()->json(array(
            'model' => 'amazon'
            ,'select' => $mc->ModeInfo->name
            ,'keyword' => $mc->keyword
            ,'matching_product' => array([
                'name' => $mc->matching_name
                ,'prime' => $mc->m_prime
                                ])
            ,'relation_product' => array([
                 'name' => $mc->relation_name
                 ,'prime' => $mc->r_prime
                                         ])
                                ));


    }

    public function setKind(Request $request)
    {
        session(['kind'=>$request->kind]);
        session()->save();
        return response()->json(array(['code'=>session()->get('kind')]));
    }
}
