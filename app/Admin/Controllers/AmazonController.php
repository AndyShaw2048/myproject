<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Amazon\Renewal;
use App\AdminUser;
use App\Amazon;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class AmazonController extends Controller
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
            
            $content->header('Amazon Two模块');
//            $content->description('description');
            
            $content->body($this->grid());
            $content->body(view('amazon.multiedit'));
            $r = Script::where('name','Amazon Two')->first();
            $content->body(view('amazon.multicharge',compact('r')));
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
            
            $content->header('Amazon Two模块');
            $content->description('编辑');
            if(Admin::user()->isRole('admin'))
                $r = Amazon::where('id',$id)->first();
            else
                $r = Amazon::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$r)return abort('404');
            $content->body(view('amazon.edit',['r'=>$r]));
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
            
            $content->header('Amazon Two模块');
            $content->description('新建');

//            $content->body($this->form());
            $content->body(view('amazon.index'));
            
        });
    }
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Amazon::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);
            
            $grid->id('ID')->sortable();
            $grid->machine_code('机器码')->drop('amazon2');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'Amazon';
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
        return Admin::form(Amazon::class, function (Form $form) {
            
            $form->display('id', 'ID');
            
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
    
    
    
    public function store(Request $request)
    {
        $amazon = Amazon::where('machine_code',$request->data['machineCode'])->first();
        if($amazon)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));
        $r = new Amazon();
        $r->model = 'Amazon Two';
        $r->machine_code = $request->data['machineCode'];
        $r->mode = $request->data['mode'];
        $r->keyword = $request->data['keyword'];
        $r->m_prime = isset($request->data['mPrime']) ? 'true' : 'false' ;
        $r->matching_name = $request->data['matchingName'];
        $r->r_prime = isset($request->data['rPrime']) ? 'true' : 'false' ;
        $r->relation_name = $request->data['relationName'];
        $r->interval_minute = $request->data['intervalMinute'];
        $r->interval_second = $request->data['intervalSecond'];
        $r->vpn = $request->data['vpn'];
        $r->street = $request->data['street'];
        $r->city = $request->data['city'];
        $r->state = $request->data['state'];
        $r->zip = $request->data['zip'];
        $r->contact = $request->data['contact'];
        $r->card_num = $request->data['cardNum'];
        $r->end_month = $request->data['endMonth'];
        $r->end_year = $request->data['endYear'];
        $r->user_id = Admin::user()->id;
        $r->note = $request->data['note'];
        $r->end_time = date('Y-m-d',time());
        $r->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }
    
    public function editStore(Request $request)
    {
        $amazon = Amazon::where('id',$request->data['id'])->first();
        if(!Admin::user()->isRole('admin'))
        {
            if($amazon && ($amazon->user_id != Admin::user()->id))
            {
                return response()->json(array([
                                                  'code'=>'201'
                                                  ,'msg'=>'无权操作'
                                              ]));
            }
        }
        Amazon::where('id',$request->data['id'])
                    ->update([
                                 'machine_code' => $request->data['machineCode'],
                                 'mode' => $request->data['mode'],
                                 'keyword' => $request->data['keyword'],
                                 'm_prime' => isset($request->data['mPrime']) ? 'true' : 'false' ,
                                 'matching_name' => $request->data['matchingName'],
                                 'r_prime' => isset($request->data['rPrime']) ? 'true' : 'false' ,
                                 'relation_name' => $request->data['relationName'],
                                 'interval_minute' => $request->data['intervalMinute'],
                                 'interval_second' => $request->data['intervalSecond'],
                                 'vpn' => $request->data['vpn'],
                                 'street' => $request->data['street'],
                                 'city' => $request->data['city'],
                                 'state' => $request->data['state'],
                                 'zip' => $request->data['zip'],
                                 'contact' => $request->data['contact'],
                                 'card_num' => $request->data['cardNum'],
                                 'end_month' => $request->data['endMonth'],
                                 'end_year' => $request->data['endYear'],
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
            $this->r = Amazon::where('id',$id)->first();
        else
            $this->r = Amazon::where('id',$id)->where('user_id',Admin::user()->id)->first();
        
        if(is_null($this->r))
            return abort('404');
        
        return Admin::content(function(Content $content) {
            $content->header('Amazon模块');
            $content->body(view('amazon.renewal',['r'=>$this->r,'id'=>$this->id]));
        });
    }
    
    public function renewalStore(Request $request)
    {
        $r = null;
        if(Admin::user()->isRole('admin'))
        {
            $r = Amazon::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $r = Amazon::where('machine_code',$request->data['machine_code'])
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
        Amazon::where('id',$request->data['mc_id'])
                    ->update([
                                 'end_time' => $newEndTime
                             ]);
        
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
