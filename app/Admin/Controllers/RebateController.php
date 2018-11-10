<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use App\Rebate;

use App\Withdraw;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class RebateController extends Controller
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

            $content->header('佣金返利');
            $content->description('列表');
            $code = Admin::user()->invitation_code;
            $rate = Admin::user()->rate;
            $content->body(view('rebate.code',compact('code','rate')));
            $content->body($this->grid());
            $rebate_money = Admin::user()->rebate_money;
            $withdraw = Withdraw::where('user_id',Admin::user()->id)->get();
            $content->body(view('rebate.withdraw',compact('rebate_money','withdraw')));
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
            return abort('404');
            $content->header('佣金返利');
            $content->description('description');

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
            return abort('404');
            $content->header('佣金返利');
            $content->description('description');
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
        return Admin::grid(Rebate::class, function (Grid $grid) {
            if(!Admin::user()->isRole('admin'))
                $grid->model()->where('up_id',Admin::user()->id);
            $grid->id('ID')->style('width:100px;');
            $grid->up_id('上级用户')->display(function($id){
                return AdminUser::find($id)->name;
            });
            $grid->down_id('下级用户')->display(function($id){
                return AdminUser::find($id)->name;
            });;
            $grid->real_money('花费');
            $grid->return_money('返利');
            $grid->created_at('消费时间');
            $grid->disableExport();
            $grid->disableActions();
            $grid->disableFilter();
            $grid->disableCreateButton();
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
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
        return Admin::form(Rebate::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    protected function withdraw(Request $request){
        $name = $request->data['name'];
        $account = $request->data['account'];
        $money = $request->data['money'];
        $rebate_money = Admin::user()->rebate_money;
        if($money > $rebate_money)
            return ['code'=>201,'msg'=>'余额不足，无法提现'];

        $w = new Withdraw();
        $w->user_id = Admin::user()->id;
        $w->name = $name;
        $w->account = $account;
        $w->money = $money;
        $w->status = 0;
        $w->save();
        DB::update('update admin_users set rebate_money = ? where id = ?',[$rebate_money-$money,Admin::user()->id]);
        return ['code'=>200];
    }
}
