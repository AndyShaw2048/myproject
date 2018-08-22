<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Instagram\Renewal;
use App\AdminUser;
use App\Instagram;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class InstagramController extends Controller
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
            $content->header('Instagram模块');
            $content->body($this->grid());
            $content->body(view('instagram.multiedit'));
            $r = Script::where('name','instagram')->first();
            $content->body(view('instagram.multicharge',compact('r')));
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
            
            $content->header('Instagram模块');
            $content->description('编辑');
            if(Admin::user()->isRole('admin'))
                $r = Instagram::where('id',$id)->first();
            else
                $r = Instagram::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$r)return abort('404');
            $content->body(view('instagram.edit',['r'=>$r]));
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
            
            $content->header('Instagram模块');
            $content->description('新建');
            
            $content->body(view('instagram.index'));
        });
    }
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Instagram::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);
            
            $grid->id('ID')->sortable();
            $grid->machine_code('机器码')->drop('instagram');
//            $grid->machine_code('机器码')->drop('instagram');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'Instagram';
                });
                $grid->user_id('所属用户')->display(function($id){
                    return AdminUser::where('id',$id)->first()->name;
                });
            }
//            $grid->note('备注')->sortable();
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
        return Admin::form(Instagram::class, function (Form $form) {
            
            $form->display('id', 'ID');
            
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
    
    /**
     * Instagram新增页面提交后，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $r = Instagram::where('machine_code',$request->data['machineCode'])->first();
        if($r)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));
        
        $r = new Instagram();
        $r->machine_code = $request->data['machineCode'];
        $r->model = "Instagram";
        $r->auth_code = $request->data['authCode'];
        $r->comment = $request->data['comment'];
        $r->topic = $request->data['topic'];
        $r->message = $request->data['message'];
        $r->images_num = $request->data['imagesNum'];
        $r->comment_images = $request->data['commentImages'];
        $r->interval_time = $request->data['intervalTime'];
        $r->round_time = $request->data['roundTime'];
        $r->user_id = Admin::user()->id;
        $r->end_time = date('Y-m-d',time());
        $r->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }
    
    /**
     * Instagram编辑页面，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editStore(Request $request)
    {
        $instagram = Instagram::where('id',$request->data['id'])->first();
        if($instagram && ($instagram->user_id != Admin::user()->id))
        {
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'无权操作'
                                          ]));
        }
        Instagram::where('id',$request->data['id'])
            ->update([
                         'machine_code' => $request->data['machineCode'],
                         'auth_code' => $request->data['authCode'],
                         'comment' => $request->data['comment'],
                         'topic' => $request->data['topic'],
                         'message' => $request->data['message'],
                         'images_num' => $request->data['imagesNum'],
                         'comment_images' => $request->data['commentImages'],
                         'interval_time' => $request->data['intervalTime'],
                         'round_time' => $request->data['roundTime'],
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
    private $r = null;
    private $id;
    
    public function renewalIndex($id=null)
    {
        $this->id = $id;
        if(!$id) return abort('404');
        if(Admin::user()->isRole('admin'))
            $this->msg = Instagram::where('id',$id)->first();
        else
            $this->msg = Instagram::where('id',$id)->where('user_id',Admin::user()->id)->first();
        
        if(is_null($this->msg))
            return abort('404');
        
        return Admin::content(function(Content $content) {
            $content->header('Instagram模块');
            $content->body(view('instagram.renewal',['msg'=>$this->msg,'id'=>$this->id]));
        });
    }
    
    public function renewalStore(Request $request)
    {
        $r = null;
        if(Admin::user()->isRole('admin'))
        {
            $r = Instagram::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $r = Instagram::where('machine_code',$request->data['machine_code'])
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
        Instagram::where('id',$request->data['mc_id'])
            ->update([
                         'end_time' => $newEndTime
                     ]);
        
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
