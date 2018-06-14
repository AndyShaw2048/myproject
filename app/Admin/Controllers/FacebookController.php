<?php

namespace App\Admin\Controllers;

use App\FacebookInfo;

use App\MCInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Facebook模块');
//            $content->description('description');

            $content->body(view('facebook.index'));
        });
    }

    public function store(Request $request)
    {
        $mc = MCInfo::where('machine_code',$request->data['machineCode'])
                    ->where('user_id',Admin::user()->id)->first();
        if(!$mc)
        {
            return response()->json(array([
                                              'code'=>'201',
                                              'msg'=>'该机器码不存在'
                                          ]));
        }
        $fb = new FacebookInfo();
        $fb->machine_code = $request->data['machineCode'];
        $fb->model = "Facebook";
        $fb->area = $request->data['area'];
        $fb->addfriend_bool = isset($request->data['addFriendBool']) ? 'true' : 'false' ;
        $fb->addfriend_num = $request->data['addFriendNum'];
        $fb->acceptrequest_bool = isset($request->data['acceptRequestBool']) ? 'true' : 'false' ;
        $fb->acceptrequest_num = $request->data['acceptRequestNum'];
        $fb->intogroup_bool = isset($request->data['intoGroupBool']) ? 'true' : 'false' ;
        $fb->intogroup_groupname = $request->data['intoGroupName'];
        $fb->pointzan_bool = isset($request->data['pointZanBool']) ? 'true' : 'false' ;
        $fb->pointzan_num = $request->data['pointZanNum'];
        $fb->mutualfriend_bool = isset($request->data['mutualFriendBool']) ? 'true' : 'false' ;
        $fb->mutualfriend_num = $request->data['mutualFriendNum'];
        $fb->intervaltime_num = $request->data['intervalTimeNum'];
        $fb->save();
        return response()->json(array([
            'code'=>'200',
                                      ]));
    }

}
