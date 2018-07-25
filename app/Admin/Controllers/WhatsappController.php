<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Whatsapp\Renewal;
use App\AdminUser;
use App\Whatsapp;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class WhatsappController extends Controller
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

            $content->header('Whatsapp模块');

            $content->body($this->grid());
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

            $content->header('Whatsapp模块');
            $content->description('编辑');
            if(Admin::user()->isRole('admin'))
                $r = Whatsapp::where('id',$id)->first();
            else
                $r = Whatsapp::where('id',$id)->where('user_id',Admin::user()->id)->first();
            if(!$r)return abort('404');
            $content->body(view('whatsapp.edit',['r'=>$r]));
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

            $content->header('Whatsapp模块');
            $content->description('description');

            $content->body(view('whatsapp.index'));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Whatsapp::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);
            $grid->model()->whereNotNull('user_id');
            $grid->id('ID')->sortable();
            $grid->machine_code('机器码')->drop('whatsapp');
            if(Admin::user()->isRole('admin'))
            {
                $grid->column('模块')->display(function(){
                    return 'Whatsapp';
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
        return Admin::form(Whatsapp::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Whatsapp新增页面提交后，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $r = Whatsapp::where('machine_code',$request->data['machineCode'])->whereNotNull('user_id')->first();
        if($r)
            return response()->json(array([
                                              'code'=>'201'
                                              ,'msg'=>'机器码已存在'
                                          ]));
        $r = new Whatsapp();
        $r->machine_code = $request->data['machineCode'];
        $r->model = "Whatsapp";
        $r->user_id = Admin::user()->id;
        $r->note = $request->data['note'];
        $r->end_time = date('Y-m-d',time());
        $r->save();
        return response()->json(array([
                                          'code'=>'200',
                                      ]));
    }

    /**
     * Whatsapp编辑页面，保存数据到数据库
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editStore(Request $request)
    {
        $whatsapp = Whatsapp::where('id',$request->data['id'])->first();
        if(!Admin::user()->isRole('admin'))
        {
            if(($whatsapp && ($whatsapp->user_id != Admin::user()->id)))
            {
                return response()->json(array([
                                                  'code'=>'201'
                                                  ,'msg'=>'无权操作'
                                              ]));
            }
        }
        Whatsapp::where('id',$request->data['id'])
            ->update([
                         'machine_code' => $request->data['machineCode'],
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
            $this->msg = Whatsapp::where('id',$id)->first();
        else
            $this->msg = Whatsapp::where('id',$id)->where('user_id',Admin::user()->id)->first();

        if(is_null($this->msg))
            return abort('404');

        return Admin::content(function(Content $content) {
            $content->header('Whatsapp模块');
            $content->body(view('whatsapp.renewal',['msg'=>$this->msg,'id'=>$this->id]));
        });
    }

    public function renewalStore(Request $request)
    {
        $r = null;
        if(Admin::user()->isRole('admin'))
        {
            $r = Whatsapp::where('machine_code',$request->data['machine_code'])->first();
        }
        else
        {
            $r = Whatsapp::where('machine_code',$request->data['machine_code'])
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
        Whatsapp::where('id',$request->data['mc_id'])
            ->update([
                         'end_time' => $newEndTime
                     ]);

        return response()->json(array([
                                          'code' => 200
                                      ]));
    }

    /**
     * 根据机器码获取拥有的手机号码
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    protected $mc = null;
    protected $tel = null;
    public function getTelephones($id = null)
    {
        if(is_null($id))
            return abort(404);
        if(Admin::user()->isRole('admin'))
            $r = Whatsapp::where('id',$id)->first();
        else
            $r = Whatsapp::where('id',$id)->where('user_id',Admin::user()->id)->first();
        if(is_null($r))
            return redirect('error');
        $this->mc = $r;
        $this->tel = Whatsapp::where('machine_code',$r->machine_code)->whereNull('user_id')->get();
        return Admin::content(function (Content $content) {
            $content->header('Whatsapp模块');
            $content->body(view('whatsapp.detail',['mc'=>$this->mc,'tel'=>$this->tel]));
        });
    }
    
    public function exportTelephones(Request $request)
    {
        $id = $request->id;
        $r = null;
        $t = null;
        if(is_null($id))
            return abort(404);
        if(Admin::user()->isRole('admin'))
            $r = Whatsapp::where('id',$id)->first();
        else
            $r = Whatsapp::where('id',$id)->where('user_id',Admin::user()->id)->first();
        if(is_null($r))
            return redirect('error');
        $t = Whatsapp::where('machine_code',$r->machine_code)->whereNull('user_id')->get();

        //写文件操作
        $filename = 'export/'.time().'.txt';
        $file = fopen($filename, "a+") or die("Unable to open file!");
        $txt = "IMEI:$r->machine_code\r\nDATA_NUM:\r\n";
        foreach($t as $item)
        {
            $txt = $txt."$item->telephone\r\n";
        }
        fwrite($file, $txt);
        $this->download($filename);
        fclose($file);
    }

    public function download($filename){
        //检测是否设置文件名和文件是否存在
        if ((isset($filename))&&(file_exists($filename)))
        {
            header("Content-length: ".filesize($filename));
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile("$filename");
        }
        else
        {
            echo "文件不存在!";
        }
    }

    public function clearTelephones(Request $request)
    {
        $mc = $request->machineCode;
        $isBelong = Whatsapp::where('machine_code',$mc)->where('user_id',Admin::user()->id)->first();
        if(!$isBelong)
            return ['code'=>'201','msg'=>'无权操作'];
        Whatsapp::where('machine_code',$mc)->whereNull('user_id')->delete();
        return ['code'=>200,'msg'=>'删除成功'];
    }
}
