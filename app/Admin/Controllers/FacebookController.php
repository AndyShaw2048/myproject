<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Facebook\Renewal;
use App\AdminUser;
use App\FacebookInfo;

use App\MCInfo;
use App\Script;
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
            $content->body(view('facebook.multiedit'));
            $r = Script::where('name','facebook')->first();
            $content->body(view('facebook.multicharge',compact('r')));
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
            if(Admin::user()->isRole('admin'))
                $fb = FacebookInfo::where('id',$id)->first();
            else
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
            $grid->machine_code('机器码')->drop('facebook');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'Facebook';
                });
                $grid->user_id('所属用户')->display(function($id){
                    return AdminUser::where('id',$id)->first()->name;
                });
            }
            $grid->note('备注')->sortable();
            $grid->updated_at('修改时间');

            $grid->actions(function ($actions) {

                // 添加操作
                $actions->append(new Renewal($actions->getKey()));
            });
            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->equal('machine_code','机器码');
                $filter->like('note','备注');
            });
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
        $fb->intogroup_number = $request->data['intoGroupNumber'];
        $fb->pointzan_bool = isset($request->data['pointZanBool']) ? 'true' : 'false' ;
        $fb->pointzan_num = $request->data['pointZanNum'];
        $fb->mutualfriend_bool = isset($request->data['mutualFriendBool']) ? 'true' : 'false' ;
        $fb->mutualfriend_num = $request->data['mutualFriendNum'];
        $fb->appointgroup_bool = isset($request->data['appointGroupBool']) ? 'true' : 'false' ;
        $fb->appointgroup_name = $request->data['appointGroupName'];
        $fb->appointgroup_number = $request->data['appointGroupNumber'];
        $fb->contactadd_bool = isset($request->data['contactAddBool']) ? 'true' : 'false' ;
        $fb->contactadd_number = $request->data['contactAddNumber'];
        $fb->intervaltime_num = $request->data['intervalTimeNum'];
        $fb->user_id = Admin::user()->id;
        $fb->note = $request->data['note'];
        $fb->end_time = date('Y-m-d',time());
        $fb->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }

    public function editStore(Request $request)
    {
        $facebook = FacebookInfo::where('id',$request->data['id'])->first();
        if(!Admin::user()->isRole('admin'))
        {
            if($facebook && ($facebook->user_id != Admin::user()->id))
            {
                return response()->json(array([
                                                  'code'=>'201'
                                                  ,'msg'=>'无权操作'
                                              ]));
            }
        }
        FacebookInfo::where('id',$request->data['id'])
                    ->update([
                                 'machine_code' => $request->data['machineCode']
                                 ,'area' => $request->data['area']
                                 ,'addfriend_bool' => isset($request->data['addFriendBool']) ? 'true' : 'false'
                                 ,'addfriend_num' => $request->data['addFriendNum']
                                 ,'acceptrequest_bool' => isset($request->data['acceptRequestBool']) ? 'true' : 'false'
                                 ,'acceptrequest_num' => $request->data['acceptRequestNum']
                                 ,'intogroup_bool' => isset($request->data['intoGroupBool']) ? 'true' : 'false'
                                 ,'intogroup_groupname' => $request->data['intoGroupName']
                                 ,'intogroup_number' => $request->data['intoGroupNumber']
                                 ,'pointzan_bool' => isset($request->data['pointZanBool']) ? 'true' : 'false'
                                 ,'pointzan_num' => $request->data['pointZanNum']
                                 ,'mutualfriend_bool' => isset($request->data['mutualFriendBool']) ? 'true' : 'false'
                                 ,'mutualfriend_num' => $request->data['mutualFriendNum']
                                 ,'appointgroup_bool' => isset($request->data['appointGroupBool']) ? 'true' : 'false'
                                 ,'appointgroup_name' => $request->data['appointGroupName']
                                 ,'appointgroup_number' => $request->data['appointGroupNumber']
                                 ,'contactadd_bool' => isset($request->data['contactAddBool']) ? 'true' : 'false'
                                 ,'contactadd_number' => $request->data['contactAddNumber']
                                 ,'intervaltime_num' => $request->data['intervalTimeNum']
                             ]);
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }
    
    /**
     * 续费操作，根据机器码ID进行续费
     *
     * @param null $id
     * @return Content|void
     */
    private $fb = null;
    private $id;

    public function renewalIndex($id=null)
    {
        $this->id = $id;
        if(!$id) return abort('404');

        if(Admin::user()->isRole('admin'))
            $this->fb = FacebookInfo::where('id',$id)->first();
        else
            $this->fb = FacebookInfo::where('id',$id)->where('user_id',Admin::user()->id)->first();

        if(is_null($this->fb))
            return abort('404');

        return Admin::content(function(Content $content) {
            $content->header('Facebook模块');
            $content->body(view('facebook.renewal',['fb'=>$this->fb,'id'=>$this->id]));
        });
    }

    public function renewalStore(Request $request)
    {
        $fb = null;
        if(Admin::user()->isRole('admin'))
        {
            $fb = FacebookInfo::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $fb = FacebookInfo::where('machine_code',$request->data['machine_code'])
                              ->where('user_id',Admin::user()->id)->first();
        }
        if(!$fb) return response()->json(array([
                                                   'code' => 201
                                                   ,'msg' => '该机器码不存在'
                                               ]));

        $sc = Script::where('name',$fb->model)->first();
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
        $oldEndTime = $fb->end_time;
        $currentTime = date("Y-m-d",time());
        $newEndTime = null;
        if($oldEndTime <= $currentTime)
        {
            $newEndTime = date("Y-m-d",strtotime("{$currentTime} + {$request->data['amount']} day"));
        }
        else
        {
            $newEndTime = date("Y-m-d",strtotime("{$fb->end_time} + {$request->data['amount']} day"));
        }
        FacebookInfo::where('id',$request->data['mc_id'])
              ->update([
                           'end_time' => $newEndTime
                       ]);

        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
