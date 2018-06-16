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

            $content->body($this->grid());
//            $content->body(view('facebook.index'));
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Facebook模块');
            $content->description('编辑');
            $fb = FacebookInfo::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$fb)return abort('404');
            $content->body(view('facebook.edit',['fb'=>$fb]));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Facebook模块');
            $content->description('新建');

//            $content->body($this->form());
            $content->body(view('facebook.index'));

        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(FacebookInfo::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);

            $grid->id('ID')->sortable();
            $grid->machine_code('机器码');
            $grid->updated_at('修改时间');

            $grid->disableFilter();
            $grid->disableExport();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(FacebookInfo::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }



    public function store(Request $request)
    {
        $facebook = FacebookInfo::where('machine_code',$request->data['machineCode'])->first();
        if($facebook)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));
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
        $fb->user_id = Admin::user()->id;
        $fb->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }

    public function editStore(Request $request)
    {
        $facebook = FacebookInfo::where('machine_code',$request->data['machineCode'])->first();
        if($facebook && ($facebook->user_id != Admin::user()->id))
        {
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'无权操作'
                                          ]));
        }
        FacebookInfo::where('machine_code',$request->data['machineCode'])
                    ->update([
                                 'machine_code' => $request->data['machineCode']
                                 ,'area' => $request->data['area']
                                 ,'addfriend_bool' => isset($request->data['addFriendBool']) ? 'true' : 'false'
                                 ,'addfriend_num' => $request->data['addFriendNum']
                                 ,'acceptrequest_bool' => isset($request->data['acceptRequestBool']) ? 'true' : 'false'
                                 ,'acceptrequest_num' => $request->data['acceptRequestNum']
                                 ,'intogroup_bool' => isset($request->data['intoGroupBool']) ? 'true' : 'false'
                                 ,'intogroup_groupname' => $request->data['intoGroupName']
                                 ,'pointzan_bool' => isset($request->data['pointZanBool']) ? 'true' : 'false'
                                 ,'pointzan_num' => $request->data['pointZanNum']
                                 ,'mutualfriend_bool' => isset($request->data['mutualFriendBool']) ? 'true' : 'false'
                                 ,'mutualfriend_num' => $request->data['mutualFriendNum']
                                 ,'intervaltime_num' => $request->data['intervalTimeNum']
                             ]);
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }
}
