<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Renewal;
use App\AdminUser;
use App\MCInfo;
use App\Mode;

use App\Script;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;

class MCInfoController extends Controller
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

            $content->header('Amazon模块');

//            $content->body(view('filter'));
            $content->body($this->grid());
            $content->body(view('multiedit'));
            $r = Script::where('name','amazon')->first();
            $content->body(view('multicharge',compact('r')));
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

            $content->header('Amazon模块');
            $content->description('编辑');

            $content->body($this->editedForm()->edit($id));
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

            $content->header('Amazon模块');
            $content->description('新增');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(MCInfo::class, function (Grid $grid) {

            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('user_id',Admin::user()->id);

            $grid->id('ID')->sortable();
            $grid->column('机器码')->drop('amazon');
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
            $grid->updated_at('修改时间')->sortable();

            $grid->disableExport();

            $grid->actions(function ($actions) {

                // 添加操作
                $actions->append(new Renewal($actions->getKey()));
            });

            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->equal('machine_code','机器码');
                $filter->like('note','备注');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(MCInfo::class, function (Form $form) {
            $form->display('id', '唯一ID');
            $form->hidden('model')->value('amazon');
            $form->select('mode','模式')->options(Mode::all()->pluck('name', 'id'))->rules('required', [
                'required' => '该项为必填项'
            ]);
            $form->text('machine_code','机器码')->rules('required|regex:/^\d+$/|min:14|max:15', [
                'required' => '该项为必填项',
                'regex' => '机器码必须全部为数字',
                'min'   => '机器码不能少于14个字符',
                'max'   => '机器码不能多于15个字符',
            ]);
            $form->text('keyword','关键词')->rules('required', [
                'required' => '该项为必填项'
            ]);
            $form->text('relation_kw','关联关键词');
            $form->text('matching_name','匹配商品名')->rules('required', [
                'required' => '该项为必填项'
            ]);
            $states = [
                'on'  => ['value' => 'true', 'text' => 'True', 'color' => 'success'],
                'off' => ['value' => 'false', 'text' => 'False', 'color' => 'danger'],
            ];
            $form->switch('m_prime','匹配_prime')->states($states);
            $form->hidden('end_time')->value(date('Y-m-d',time()));
            $form->text('relation_name','关联商品名')->help('填写该项需选择<span style="color: red">强制关联</span>模式');
            $form->switch('r_prime','关联_prime')->states($states);
            if(Admin::user()->isRole('admin'))
                $form->select('user_id','所属用户ID')->options(AdminUser::all()->pluck('username', 'id'))->rules('required', [
                'required' => '该项为必填项'
            ]);
            else
                $form->hidden('user_id')->value(Admin::user()->id);
            $form->text('interval_time','间隔时间');
            $form->text('note','备注');

            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();
            });

            $form->saving(function ($form) {
                $mc = MCInfo::where('machine_code',$form->machine_code)->first();
                if($mc && ($mc->user_id != Admin::user()->id))
                {
                    $error = new MessageBag([
                                                'title' => '机器码已存在',
                                            ]);
                    return back()->with(compact('error'))->withInput();
                }

                if(!is_null($form->relation_name))
                {
                    if(!($form->mode == 2))
                    {
                        $error = new MessageBag([
                                                    'title' => '填写关联商品名，请先选择-强制关联-模式',
                                                ]);

                        return back()->with(compact('error'))->withInput();
                    }
                }

                if($form->mode == 2)
                {
                    if(is_null($form->relation_name))
                    {
                        $error = new MessageBag([
                                                    'title' => '-强制关联-模式下，关联商品名 不能为空',
                                                ]);

                        return back()->with(compact('error'))->withInput();
                    }
                }
            });

        });
    }

    protected function editedForm()
    {
        return Admin::form(MCInfo::class, function (Form $form) {
            $form->display('id', '唯一ID');
            $form->text('machine_code','机器码');
            $form->select('mode','模式')->options(Mode::all()->pluck('name', 'id'));
            $form->text('keyword','关键词');
            $form->text('relation_kw','关联关键词');
            $form->text('matching_name','匹配商品名');
            $states = [
                'on'  => ['value' => 'true', 'text' => 'True', 'color' => 'success'],
                'off' => ['value' => 'false', 'text' => 'False', 'color' => 'danger'],
            ];
            $form->switch('m_prime','匹配_prime')->states($states);
            $form->text('relation_name','关联商品名');
            $form->switch('r_prime','关联_prime')->states($states);
            if(Admin::user()->isRole('admin'))
                $form->select('user_id','所属用户ID')->options(AdminUser::all()->pluck('username', 'id'));
            $form->text('interval_time','间隔时间');
            $form->text('note','备注');
            $form->display('updated_at', '更新时间');

            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();

            });
        });
    }


}
