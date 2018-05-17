<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use App\MCInfo;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
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

            $content->header('机器码管理');
            $content->description('列表');

            $content->body(view('filter'));
            $content->body($this->grid());
            $content->body(view('multiedit'));
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

            $content->header('机器码管理');
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

            $content->header('机器码管理');
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

            $grid->id('序号')->sortable();
            $grid->column('机器码')->drop();
            $grid->note('备注')->sortable();
            $grid->updated_at('修改时间')->sortable();

            $grid->disableFilter();
            $grid->disableExport();

            //过滤
            $grid->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                $filter->equal('mode');
                $filter->equal('machine_code');
                $filter->like('keyword');
                $filter->like('matching_name');
                $filter->like('relation_name');
                $filter->equal('note');
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
            $form->display('id', '序号');
            $form->select('mode','模式')->options([
                                                    '1' => '自动购买',
                                                    '2' => '强制关联',
                                                    '3' => '点击广告',
                                                    '4' => '关键词上首页'
                                                ]);
            $form->text('machine_code','机器码')->rules('required|regex:/^\d+$/|min:14|max:15', [
                'regex' => '机器码必须全部为数字',
                'min'   => '机器码不能少于14个字符',
                'max'   => '机器码不能多于15个字符',
            ]);
            $form->text('keyword','关键词');
            $form->text('matching_name','匹配商品名');
            $form->text('relation_name','关联商品名');
            $form->select('user_id','所属用户ID')->options(AdminUser::all()->pluck('username', 'id'));
            $form->text('note','备注');
            $form->display('updated_at', '更新时间');

            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();
            });
        });
    }

    protected function editedForm()
    {
        return Admin::form(MCInfo::class, function (Form $form) {
            $form->display('id', '序号');
            $form->display('machine_code','机器码');
            $form->select('mode','模式')->options([
                '1' => '自动购买',
                '2' => '强制关联',
                '3' => '点击广告',
                '4' => '关键词上首页'
                                                ]);
            $form->text('keyword','关键词');
            $form->text('matching_name','匹配商品名');
            $form->text('relation_name','关联商品名');
            $form->select('user_id','所属用户ID')->options(AdminUser::all()->pluck('username', 'id'));
            $form->text('note','备注');
            $form->display('updated_at', '更新时间');

            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();

            });
        });
    }

}
