<?php

namespace App\Admin\Controllers;

use App\AmazonThr;
use App\Admin\Extensions\AmazonThr\Renewal;
use App\AdminUser;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class AmazonThrController extends Controller
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
            
            $content->header('AmazonThr模块');
//            $content->description('description');
            
            $content->body($this->grid());
            $content->body(view('amazonThr.multiedit'));
            $r = Script::where('name','AmazonThr')->first();
            $content->body(view('amazonThr.multicharge',compact('r')));
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
            
            $content->header('AmazonThr模块');
            $content->description('编辑');
            if(Admin::user()->isRole('admin'))
                $r = AmazonThr::where('id',$id)->first();
            else
                $r = AmazonThr::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$r)return abort('404');
            $content->body(view('amazonThr.edit',['r'=>$r]));
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
            
            $content->header('AmazonThr模块');
            $content->description('新建');

//            $content->body($this->form());
            $content->body(view('amazonThr.index'));
            
        });
    }
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(AmazonThr::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);
            
            $grid->id('ID')->sortable();
            $grid->machine_code('机器码')->drop('AmazonThr');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'AmazonThr';
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
        return Admin::form(AmazonThr::class, function (Form $form) {
            
            $form->display('id', 'ID');
            
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
    
    
    
    public function store(Request $request)
    {
        $a = AmazonThr::where('machine_code',$request->data['machine_code'])->first();
        if($a)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));
        $r = new AmazonThr();
        $r->model = 'AmazonThr';
        $r->machine_code = $request->data['machine_code'];
        $r->first_run = $request->data['first_run'];
        $r->second_run = $request->data['second_run'];
        $r->third_run = $request->data['third_run'];
        $r->fourth_run = $request->data['fourth_run'];
        $r->fifth_run = $request->data['fifth_run'];
        $r->run_speed = $request->data['run_speed'];
        $r->run_times = $request->data['run_times'];
        $r->timing_run_hours = $request->data['timing_run_hours'];
        $r->timing_run_minutes = $request->data['timing_run_minutes'];
        $r->each_time_interval = $request->data['each_time_interval'];
        $r->auto_buy_prime = isset( $request->data['auto_buy_prime'] ) ? 'true' : 'false';
        $r->auto_buy_keyword = $request->data['auto_buy_keyword'];
        $r->auto_buy_item = $request->data['auto_buy_item'];
        $r->relevance_item_prime = isset( $request->data['relevance_item_prime'] ) ? 'true' : 'false';
        $r->relevance_item_keyword_one = $request->data['relevance_item_keyword_one'];
        $r->relevance_item_item_one = $request->data['relevance_item_item_one'];
        $r->relevance_item_keyword_two = $request->data['relevance_item_keyword_two'];
        $r->relevance_item_item_two = $request->data['relevance_item_item_two'];
        $r->sponsored_prime = isset( $request->data['sponsored_prime'] ) ? 'true' : 'false';
        $r->sponsored_keyword = $request->data['sponsored_keyword'];
        $r->keyword_top_prime = isset( $request->data['keyword_top_prime'] ) ? 'true' : 'false';
        $r->keyword_top_keyword = $request->data['keyword_top_keyword'];
        $r->keyword_top_item = $request->data['keyword_top_item'];
        $r->delete_review_prime = isset( $request->data['delete_review_prime'] ) ? 'true' : 'false';
        $r->delete_review_keyword = $request->data['delete_review_keyword'];
        $r->delete_review_item = $request->data['delete_review_item'];
        $r->leave_review_prime = isset( $request->data['leave_review_prime'] ) ? 'true' : 'false';
        $r->leave_review_keyword = $request->data['leave_review_keyword'];
        $r->leave_review_item = $request->data['leave_review_item'];
        $r->leave_review_star = $request->data['leave_review_star'];
        $r->leave_review_contact = $request->data['leave_review_contact'];
        $r->leave_review_title = $request->data['leave_review_title'];
        $r->note = $request->data['note'];
        $r->user_id = Admin::user()->id;
        $r->end_time = date('Y-m-d',time());
        $r->save();

        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }
    
    public function editStore(Request $request)
    {
        $amazonThr = AmazonThr::where('id',$request->data['id'])->first();
        if(!Admin::user()->isRole('admin'))
        {
            if($amazonThr && ($amazonThr->user_id != Admin::user()->id))
            {
                return response()->json(array([
                                                  'code'=>'201'
                                                  ,'msg'=>'无权操作'
                                              ]));
            }
        }
        AmazonThr::where('id',$request->data['id'])
              ->update([
                            'machine_code' => $request->data['machine_code'],
                            'first_run' => $request->data['first_run'],
                            'second_run' => $request->data['second_run'],
                            'third_run' => $request->data['third_run'],
                            'fourth_run' => $request->data['fourth_run'],
                            'fifth_run' => $request->data['fifth_run'],
                            'run_speed' => $request->data['run_speed'],
                            'run_times' => $request->data['run_times'],
                            'timing_run_hours' => $request->data['timing_run_hours'],
                            'timing_run_minutes' => $request->data['timing_run_minutes'],
                            'each_time_interval' => $request->data['each_time_interval'],
                            'auto_buy_prime' => isset( $request->data['auto_buy_prime'] ) ? 'true' : 'false',
                            'auto_buy_keyword' => $request->data['auto_buy_keyword'],
                            'auto_buy_item' => $request->data['auto_buy_item'],
                            'relevance_item_prime' => isset( $request->data['relevance_item_prime'] ) ? 'true' : 'false',
                            'relevance_item_keyword_one' => $request->data['relevance_item_keyword_one'],
                            'relevance_item_item_one' => $request->data['relevance_item_item_one'],
                            'relevance_item_keyword_two' => $request->data['relevance_item_keyword_two'],
                            'relevance_item_item_two' => $request->data['relevance_item_item_two'],
                            'sponsored_prime' => isset( $request->data['sponsored_prime'] ) ? 'true' : 'false',
                            'sponsored_keyword' => $request->data['sponsored_keyword'],
                            'keyword_top_prime' => isset( $request->data['keyword_top_prime'] ) ? 'true' : 'false',
                            'keyword_top_keyword' => $request->data['keyword_top_keyword'],
                            'keyword_top_item' => $request->data['keyword_top_item'],
                            'delete_review_prime' => isset( $request->data['delete_review_prime'] ) ? 'true' : 'false',
                            'delete_review_keyword' => $request->data['delete_review_keyword'],
                            'delete_review_item' => $request->data['delete_review_item'],
                            'leave_review_prime' => isset( $request->data['leave_review_prime'] ) ? 'true' : 'false',
                            'leave_review_keyword' => $request->data['leave_review_keyword'],
                            'leave_review_item' => $request->data['leave_review_item'],
                            'leave_review_star' => $request->data['leave_review_star'],
                            'leave_review_contact' => $request->data['leave_review_contact'],
                            'leave_review_title' => $request->data['leave_review_title'],
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
            $this->r = AmazonThr::where('id',$id)->first();
        else
            $this->r = AmazonThr::where('id',$id)->where('user_id',Admin::user()->id)->first();
        
        if(is_null($this->r))
            return abort('404');
        return Admin::content(function(Content $content) {
            $content->header('AmazonThr模块');
            $content->body(view('amazonThr.renewal',['r'=>$this->r,'id'=>$this->id]));
        });
    }
    
    public function renewalStore(Request $request)
    {
        $r = null;
        if(Admin::user()->isRole('admin'))
        {
            $r = AmazonThr::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $r = AmazonThr::where('machine_code',$request->data['machine_code'])
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
        AmazonThr::where('id',$request->data['mc_id'])
              ->update([
                           'end_time' => $newEndTime
                       ]);
        
        return response()->json(array([
                                          'code' => 200
                                      ]));
    }
}
