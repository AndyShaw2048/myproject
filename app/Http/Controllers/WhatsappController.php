<?php

namespace App\Http\Controllers;

use App\Whatsapp;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function store(Request $request)
    {
        try
        {
            $imei = $request->IMEI;
            $telephones = $request->Data_Num;
            $array = explode('|',$telephones);
            $r = Whatsapp::where('machine_code',$imei)->whereNotNull('user_id')->first();
            if(is_null($r))
                return array('code'=>201,'msg'=>'该机器码不存在');

            foreach($array as $item)
            {
                $r = new Whatsapp();
                $r->model = 'whatsapp';
                $r->machine_code = $imei;
                $r->telephone = $item;
                $r->save();
            }
            return array('code'=>200,'msg'=>'上传成功');
        }
        catch(\Exception $e)
        {
            return array('code'=>202,'msg'=>'上传失败');
        }
    }
}
