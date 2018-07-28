<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Messenger\Renewal;
use App\AdminUser;
use App\Messenger;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class MessengerController extends Controller
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

            $content->header('Messenger模块');

            $content->body($this->grid());
            $content->body(view('messenger.multiedit'));
            $r = Script::where('name','messenger')->first();
            $content->body(view('messenger.multicharge',compact('r')));
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

            $content->header('Messenger模块');
            $content->description('description');
            if(Admin::user()->isRole('admin'))
                $msg = Messenger::where('id',$id)->first();
            else
                $msg = Messenger::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$msg)return abort('404');
            $content->body(view('messenger.edit',['msg'=>$msg]));
//            $content->body($this->form()->edit($id));
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

            $content->header('Messenger模块');
            $content->description('description');

            $content->body(view('messenger.index'));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Messenger::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);

            $grid->id('ID')->sortable();
            $grid->machine_code('机器码')->drop('messenger');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'Messenger';
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
        return Admin::form(Messenger::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Messenger新增页面提交后，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $messenger = Messenger::where('machine_code',$request->data['machineCode'])->first();
        if($messenger)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));

        $msg = new Messenger();
        $msg->machine_code = $request->data['machineCode'];
        $msg->model = "Messenger";
        $msg->acceptrequest_bool = isset($request->data['acceptRequestBool']) ? 'true' : 'false' ;
        $msg->acceptrequest_num = $request->data['acceptRequestNum'];
        $msg->sendmessage_bool = isset($request->data['sendMessageBool']) ? 'true' : 'false' ;
        $msg->sendmessage_num = $request->data['sendMessageNum'];
        $msg->addfriend_bool = isset($request->data['addFriendBool']) ? 'true' : 'false' ;
        $msg->addfriend_num = $request->data['addFriendNum'];
        $msg->content = $request->data['content'];
        $msg->intervaltime = $request->data['intervalTime'];
//        $msg->area = $request->data['area'];
        $msg->mutualfriend_num = $request->data['mutualFriend'];
        $msg->user_id = Admin::user()->id;
        $msg->note = $request->data['note'];
        $msg->end_time = date('Y-m-d',time());
        $msg->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }

    /**
     * Messenger编辑页面，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editStore(Request $request)
    {
        $messenger = Messenger::where('id',$request->data['id'])->first();
        if($messenger && ($messenger->user_id != Admin::user()->id))
        {
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'无权操作'
                                          ]));
        }
        Messenger::where('id',$request->data['id'])
                    ->update([
                                 'machine_code' => $request->data['machineCode']
                                 ,'acceptrequest_bool' => isset($request->data['acceptRequestBool']) ? 'true' : 'false'
                                 ,'acceptrequest_num' => $request->data['acceptRequestNum']
                                 ,'sendmessage_bool' => isset($request->data['sendMessageBool']) ? 'true' : 'false'
                                 ,'sendmessage_num' => $request->data['sendMessageNum']
                                 ,'addfriend_bool' => isset($request->data['addFriendBool']) ? 'true' : 'false'
                                 ,'addfriend_num' => $request->data['addFriendNum']
                                 ,'content' => $request->data['content']
                                 ,'intervaltime' => $request->data['intervalTime']
                                 ,'mutualfriend_num' => $request->data['mutualFriend']
                                 ,'note' => $request->data['note']
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
    private $msg = null;
    private $id;

    public function renewalIndex($id=null)
    {
        $this->id = $id;
        if(!$id) return abort('404');
        if(Admin::user()->isRole('admin'))
            $this->msg = Messenger::where('id',$id)->first();
        else
        $this->msg = Messenger::where('id',$id)->where('user_id',Admin::user()->id)->first();

        if(is_null($this->msg))
            return abort('404');

        return Admin::content(function(Content $content) {
            $content->header('Messenger模块');
            $content->body(view('messenger.renewal',['msg'=>$this->msg,'id'=>$this->id]));
        });
    }

    public function renewalStore(Request $request)
    {
        $msg = null;
        if(Admin::user()->isRole('admin'))
        {
            $msg = Messenger::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $msg = Messenger::where('machine_code',$request->data['machine_code'])
                            ->where('user_id',Admin::user()->id)->first();
        }

        if(!$msg) return response()->json(array([
                                                   'code' => 201
                                                   ,'msg' => '该机器码不存在'
                                               ]));

        $sc = Script::where('name',$msg->model)->first();
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
        $oldEndTime = $msg->end_time;
        $currentTime = date("Y-m-d",time());
        $newEndTime = null;
        if($oldEndTime <= $currentTime)
        {
            $newEndTime = date("Y-m-d",strtotime("{$currentTime} + {$request->data['amount']} day"));
        }
        else
        {
            $newEndTime = date("Y-m-d",strtotime("{$msg->end_time} + {$request->data['amount']} day"));
        }
        Messenger::where('id',$request->data['mc_id'])
                    ->update([
                                 'end_time' => $newEndTime
                             ]);

        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
