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
                MCInfo::where('id',$item)
                      ->update([
                                   'mode' => $mode,
                                   'keyword' => $keyword,
                                   'matching_name' => $matchingName,
                                   'relation_name' => $relationName,
                                   'note' => $note,
                               ]);
            }
            else
            {
                try
                {
                    MCInfo::where('id',$item)
                          ->where('user_id',Admin::user()->id)
                          ->update([
                                       'mode' => $mode,
                                       'keyword' => $keyword,
                                       'matching_name' => $matchingName,
                                       'relation_name' => $relationName,
                                       'note' => $note,
                                   ]);
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
        $mc = MCInfo::where('machine_code',$id)->firstOrFail();
        $string = $mc->mode.'|'.$mc->keyword.'|'.$mc->matching_name.'|'.$mc->relation_name;
        return $string;
    }
}
