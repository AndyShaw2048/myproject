<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\Export;
use App\Withdraw;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WithdrawController extends Controller
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

            $content->header('佣金提现');
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
//            return abort(404);
            $content->header('header');
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
            return abort(404);
            $content->header('header');
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
        return Admin::grid(Withdraw::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user_id('用户');
            $grid->name('支付宝姓名');
            $grid->account('支付宝账号');
            $grid->money('金额');
            $grid->status('状态')->sortable()->display(function($i){
                return $i == 0 ? '未转账' : '已转账';
            });
            $grid->created_at('提现时间');
            $grid->disableExport();
            $grid->disableActions();
            $grid->disableFilter();
            $grid->disableCreateButton();
            $grid->tools(function ($tools) {
                $tools->append(new Export());
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
        return Admin::form(Withdraw::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    protected function export(){
        if(!Admin::user()->isRole('admin'))
            return '无权操作';
        try
        {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', '用户ID');
            $sheet->setCellValue('C1', '支付宝姓名');
            $sheet->setCellValue('D1', '支付宝账号');
            $sheet->setCellValue('E1', '提现金额');
            $sheet->setCellValue('F1', '状态');
            $sheet->setCellValue('G1', '提现时间');
            $ascii = '67';
            $lists = DB::table('withdraw')->where('status','0')->get();
            foreach($lists as $i => $list)
            {
                $sheet->setCellValue('A'.($i+2), $list->id);
                $sheet->setCellValue('B'.($i+2), $list->user_id);
                $sheet->setCellValue('C'.($i+2), $list->name);
                $sheet->setCellValue('D'.($i+2), $list->account);
                $sheet->setCellValue('E'.($i+2), $list->money);
                $sheet->setCellValue('F'.($i+2), $list->status);
                $sheet->setCellValue('G'.($i+2), $list->created_at);
                $ascii++;
            }
            $writer = new Xlsx($spreadsheet);
            $filename = 'export/'.md5(time()).'.xlsx';
            $writer->save($filename);
        }
        catch(\Exception $e)
        {
            return '导出失败';
        }
        return redirect(url($filename));
    }
}
