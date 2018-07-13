<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Wish\Renewal;
use App\AdminUser;
use App\Wish;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class WishController extends Controller
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

            $content->header('Wish模块');

            $content->body($this->grid());
            $content->body(view('wish.multiedit'));
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

            $content->header('Wish模块');
            $content->description('编辑');
            if(Admin::user()->isRole('admin'))
                $r = Wish::where('id',$id)->first();
            else
                $r = Wish::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$r)return abort('404');
            $content->body(view('wish.edit',['r'=>$r]));
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

            $content->header('Wish模块');
            $content->description('description');

            $content->body(view('wish.index'));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Wish::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);

            $grid->id('ID')->sortable();
            $grid->machine_code('机器码');
//            $grid->machine_code('机器码')->drop('wish');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'Wish';
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
        return Admin::form(Wish::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Wish新增页面提交后，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $r = Wish::where('machine_code',$request->data['machineCode'])->first();
        if($r)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));

        $r = new Wish();
        $r->machine_code = $request->data['machineCode'];
        $r->model = "Wish";
        $r->isRegister = isset($request->data['isRegister']) ? 'true' : 'false' ;
        $r->lastName = $request->data['lastName'];
        $r->firstName = $request->data['lastName'];
        $r->email = $request->data['lastName'];
        $r->password = $request->data['lastName'];
        $r->isAddAddress = isset($request->data['isRegister']) ? 'true' : 'false' ;
        $r->address = $request->data['lastName'];
        $r->state = $request->data['lastName'];
        $r->city = $request->data['lastName'];
        $r->code = $request->data['lastName'];
        $r->telephone = $request->data['lastName'];
        $r->isAutoBuy = isset($request->data['isRegister']) ? 'true' : 'false' ;
        $r->goodsName = $request->data['lastName'];
        $r->goodsList = $request->data['lastName'];
        $r->cardNumber = $request->data['lastName'];
        $r->CW = $request->data['lastName'];
        $r->term = $request->data['lastName'];
        $r->intervaltime = $request->data['intervalTime'];
        $r->user_id = Admin::user()->id;
        $r->note = $request->data['note'];
        $r->end_time = date('Y-m-d',time());
        $r->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }

    /**
     * Wish编辑页面，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editStore(Request $request)
    {
        $wish = Wish::where('machine_code',$request->data['machineCode'])->first();
        if($wish && ($wish->user_id != Admin::user()->id))
        {
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'无权操作'
                                          ]));
        }
        Wish::where('machine_code',$request->data['machineCode'])
                 ->update([
                                'isRegister' => isset($request->data['isRegister']) ? 'true' : 'false' ,
                                'lastName' => $request->data['lastName'],
                                'firstName' => $request->data['firstName'],
                                'email' => $request->data['email'],
                                'password' => $request->data['password'],
                                'isAddAddress' => isset($request->data['isAddAddress']) ? 'true' : 'false' ,
                                'address' => $request->data['address'],
                                'state' => $request->data['state'],
                                'city' => $request->data['city'],
                                'code' => $request->data['code'],
                                'telephone' => $request->data['telephone'],
                                'isAutoBuy' => isset($request->data['isAutoBuy']) ? 'true' : 'false' ,
                                'goodsName' => $request->data['goodsName'],
                                'goodsList' => $request->data['goodsList'],
                                'cardNumber' => $request->data['cardNumber'],
                                'CW' => $request->data['CW'],
                                'term' => $request->data['term'],
                                'intervalTime' => $request->data['intervalTime'],
                                'note' => $request->data['note'],
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
            $this->msg = Wish::where('id',$id)->first();
        else
            $this->msg = Wish::where('id',$id)->where('user_id',Admin::user()->id)->first();

        if(is_null($this->msg))
            return abort('404');

        return Admin::content(function(Content $content) {
            $content->header('Wish模块');
            $content->body(view('wish.renewal',['msg'=>$this->msg,'id'=>$this->id]));
        });
    }

    public function renewalStore(Request $request)
    {
        $r = null;
        if(Admin::user()->isRole('admin'))
        {
            $r = Wish::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $r = Wish::where('machine_code',$request->data['machine_code'])
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
        Wish::where('id',$request->data['mc_id'])
                 ->update([
                              'end_time' => $newEndTime
                          ]);

        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
