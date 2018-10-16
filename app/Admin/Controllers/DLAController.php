<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Purchase;
use App\AdminUser;
use App\DLA;

use App\DLAList;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class DLAController extends Controller
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

            $content->header('DLA模块');
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

            $content->header('DLA模块');
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

            $content->header('DLA模块');
            $content->description('新建');

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
        return Admin::grid(DLA::class, function (Grid $grid) {
            $this->that = $this;
//            $grid->id('ID')->sortable();
            $grid->title('标题');
            $grid->column('下载链接')->display(function(){
                $t_bool = DB::table('dla_list')->where('topic_id',$this->id)->where('user_id',Admin::user()->id)->first();
                if($t_bool) {
                    return '<a href='.$this->url.' style="color:blue;" target="_blank">'.'点击下载'.'</a>';
                }
                return '未购买';
            });
            $grid->price('价格');

            $grid->actions(function ($actions) {
                if(!Admin::user()->isRole('admin'))
                {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }
                // 添加操作
                $actions->append(new Purchase($actions->getKey()));
            });
            $grid->disableExport();
            $grid->disableFilter();
//            $grid->disableActions();
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
        return Admin::form(DLA::class, function (Form $form) {
            if(!Admin::user()->isRole('admin'))
            {
                return abort(404);
            }
            $form->text('title','标题');
            $form->text('url','链接')->value('http://')->help('链接请务必添加http://或者https://');
            $form->text('price','价格');
        });
    }

    public function purchase($id = null)
    {
        if(!$id) return abort(404);
        $l = DB::table('dla_list')->where('topic_id',$id)->where('user_id',Admin::user()->id)->first();
        if(!$l)
        {
            $user = Admin::user();
            $cost = DLA::find($id)->price;
            if($user->balance < $cost)
                return ['code' => 2001,'msg' => '余额不足'];
            else
            {
                AdminUser::where('id',$user->id)
                         ->update([
                             'balance' => $user->balance - $cost
                                  ]);
            }
            $li = new DLAList();
            $li->topic_id = $id;
            $li->status = 1;
            $li->user_id = Admin::user()->id;
            $li->save();
            return ['code' => 2000,'msg' => '购买成功'];
        }
        else
        {
            return ['code' => 2001,'msg' => '请勿重复购买'];
        }
    }
}
