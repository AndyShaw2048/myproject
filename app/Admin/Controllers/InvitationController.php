<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use App\Invitation;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
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

            $content->header('邀请码');
            $content->description('列表');

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

            $content->header('邀请码');
            $content->description('编辑');
            $content->body($this->form()->edit($id));
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

            $content->header('邀请码');
            $content->description('创建');
            $content->body(view('invitation'));
//            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Invitation::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->code('邀请码');
            $grid->user_id('使用者 ( ID ) ')->display(function($id){
                if(!$id) return '未使用';
                return AdminUser::find($id)->name.' ( '.$id.' ) ';
            });
            $grid->disableFilter();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Invitation::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function generate(Request $request)
    {
        if(!Admin::user()->isRole('admin')) return '无权操作';
        $str = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $decimal = $request->data['decimal'];
        $number = $request->data['number'];
        if($decimal>10 || $number>1000)
            return ['code'=>201,'msg'=>'位数请小于10位，数量请少于1000个'];

        for($i=0;$i<$number;$i++)
        {
            str_shuffle($str);
            $code = substr(str_shuffle($str),26,$decimal);
            $r = DB::insert("insert into invitation(code) VALUES(?)",[$code]);
            if(!$r) return ['code'=>201,'msg'=>'生成失败'];
        }
        return ['code'=>200];
    }
}
