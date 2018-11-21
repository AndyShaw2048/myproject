<?php

namespace App\Http\Controllers\V2;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{

    //添加分组
    public function addGroup(Request $request)
    {
        $g = new Group();
        $g->name = $request->name;
        $g->user_id = Auth::id();
        $g->model = $request->model;
        $g->ctime = date("Y-m-d H:i:s",time());
        $g->save();
        return ['code'=>200];
    }

    //删除
    public function deleteGroup(Request $request)
    {
        $array = $request->array;
        $user_id = Auth::id();
        foreach($array as $item)
        {
            DB::statement("delete from groups where id = $item ");
        }

        return ['code'=>200];
    }

    //重命名分组
    public function renameGroup(Request $request)
    {
        DB::statement("update groups set name=$request->name where id=$request->id");
        return ['code'=>200];
    }

    //显示分组
    public function showGroup(Request $request)
    {
        return 1;
        $groups = DB::table('groups')->where('model','facebook')->get();

    }
}
