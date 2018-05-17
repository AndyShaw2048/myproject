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
    
    public function getMCInfo($id = null)
    {
        $mc = MCInfo::where('machine_code',$id)->first();
        if($mc == null)
            return 'false';
        $string = $mc->mode.'|'.$mc->keyword.'|'.$mc->matching_name.'|'.$mc->relation_name;
        return $string;
    }
}
