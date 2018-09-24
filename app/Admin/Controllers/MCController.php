<?php

namespace App\Admin\Controllers;

use App\McInfo;

use App\Script;
use App\Serial;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MCController extends Controller
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

            $sr = Serial::where('user_id',0)->orderBy('id','desc')->paginate(10);
            $sc = Script::all();

            $num = array(Serial::where('status',1)->count());
            $money = array(0);
            foreach(Serial::where('status',1)->get() as $item)
            {
                $money[0] = $money[0] + $item->money;
            }
            array_push($num,Serial::where('status',0)->count());
            array_push($money,0);
            foreach(Serial::where('status',0)->get() as $item)
            {
                $money[1] = $money[1] + $item->money;
            }

            array_push($num,Serial::count());
            array_push($money,0);
            foreach(Serial::all() as $item)
            {
                $money[2] = $money[2] + $item->money;
            }
            $content->header('序列号操作');
            $content->body(view('generate',['sr'=>$sr,'sc'=>$sc,'num'=>$num,'money'=>$money]));
        });
    }

    public function store(Request $request)
    {
        if(!Admin::user()->isRole('admin'))
            return '无权操作';
        for($i=0;$i<$request->amount;$i++)
        {
            $uuid = substr(Uuid::uuid1()->getInteger(),0,15);
            $sr = new Serial();
            $sr->content = $uuid;
            $sr->user_id = 0;
            $sr->money = $request->money;
            $sr->created_at = date("Y-m-d H:i:s",time());
            $sr->status = 0;
            $sr->save();
        }
        return redirect()->back();
    }
    
    public function export()
    {
        if(!Admin::user()->isRole('admin'))
            return '无权操作';
        try
        {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', '序列号');
            $sheet->setCellValue('B1', '金额');
            $ascii = '67';
            $serials = DB::table('serials')->where('status','0')->get();
            foreach($serials as $i => $serial)
            {
                $sheet->setCellValue('A'.($i+2), $serial->content);
                $sheet->setCellValue('B'.($i+2), $serial->money);
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
