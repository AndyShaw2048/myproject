<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Wish;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function getInfo($id = null)
    {
        if ( !$id )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '查询机器码不能为空'
                                     ]), JSON_UNESCAPED_UNICODE);

        $msg = Wish::where('machine_code', $id)->first();
        if ( !$msg )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '该机器码不存在'
                                     ]), JSON_UNESCAPED_UNICODE);
        if($msg->end_time <= date('Y-m-d',time()))
            return json_encode(array(
                                   'code' => '203'
                                   ,'msg' => '该机器码已过期，请续费'
                               ),JSON_UNESCAPED_UNICODE);
        return '未知格式';
//        return json_encode(array([
//                                     "Model" => $msg->model
//                                     //                                     , "Area" => $msg->area
//                                     , "AcceptRequest" => array([
//                                                                    "PitchOn" => $msg->acceptrequest_bool == 'true' ? true : false
//                                                                    , "Number" => $msg->acceptrequest_num
//                                                                ])
//                                     , "SendMessage" => array([
//                                                                  "PitchOn" => $msg->sendmessage_bool == 'true' ? true : false
//                                                                  , "Number" => $msg->sendmessage_num
//                                                              ])
//                                     , "AddFriend" => array([
//                                                                "PitchOn" => $msg->addfriend_bool == 'true' ? true : false
//                                                                , "Number" => $msg->addfriend_num
//                                                            ])
//                                     , "Content" => $msg->content
//                                     , "IntervalTime" => $msg->intervaltime
//                                     , "MutualFriend" => $msg->mutualfriend_num
//                                 ]), JSON_UNESCAPED_UNICODE);
    }

    public function multiedit(Request $request)
    {
        $isRegister = isset($request->data['isRegister']) ? 'true' : 'false' ;
        $lastName = $request->data['lastName'];
        $firstName = $request->data['lastName'];
        $email = $request->data['lastName'];
        $password = $request->data['lastName'];
        $isAddAddress = isset($request->data['isRegister']) ? 'true' : 'false' ;
        $address = $request->data['lastName'];
        $state = $request->data['lastName'];
        $city = $request->data['lastName'];
        $code = $request->data['lastName'];
        $telephone = $request->data['lastName'];
        $isAutoBuy = isset($request->data['isRegister']) ? 'true' : 'false' ;
        $goodsName = $request->data['lastName'];
        $goodsList = $request->data['lastName'];
        $cardNumber = $request->data['lastName'];
        $CW = $request->data['lastName'];
        $term = $request->data['lastName'];
        $intervalTime = $request->data['intervalTime'];
        $note = $request->data['note'];
        $multiArray = $request->multi;

        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $msg = Wish::find($item);
                if ( !is_null($isRegister) )
                    $msg->isRegister = $isRegister;
                if ( !is_null($lastName) )
                    $msg->lastName = $lastName;
                if ( !is_null($firstName) )
                    $msg->firstName = $firstName;
                if ( !is_null($email) )
                    $msg->email = $email;
                if ( !is_null($password) )
                    $msg->password = $password;
                if ( !is_null($isAddAddress) )
                    $msg->isAddAddress = $isAddAddress;
                if ( !is_null($address) )
                    $msg->address = $address;
                if ( !is_null($state) )
                    $msg->state = $state;
                if ( !is_null($city) )
                    $msg->city = $city;
                if ( !is_null($code) )
                    $msg->code = $code;
                if ( !is_null($telephone) )
                    $msg->telephone = $telephone;
                if ( !is_null($isAutoBuy) )
                    $msg->isAutoBuy = $isAutoBuy;
                if ( !is_null($goodsList) )
                    $msg->goodsList = $goodsList;
                if ( !is_null($goodsName) )
                    $msg->goodsName = $goodsName;
                if ( !is_null($cardNumber) )
                    $msg->cardNumber = $cardNumber;
                if ( !is_null($CW) )
                    $msg->CW = $CW;
                if ( !is_null($term) )
                    $msg->term = $term;
                if ( !is_null($intervalTime) )
                    $msg->intervalTime = $intervalTime;
                if ( !is_null($note) )
                    $msg->note = $note;
                $msg->save();
            } else
                try {
                    $msg = Wish::where('user_id',Admin::user()->id)->find($item);
                    if ( !is_null($isRegister) )
                        $msg->isRegister = $isRegister;
                    if ( !is_null($lastName) )
                        $msg->lastName = $lastName;
                    if ( !is_null($firstName) )
                        $msg->firstName = $firstName;
                    if ( !is_null($email) )
                        $msg->email = $email;
                    if ( !is_null($password) )
                        $msg->password = $password;
                    if ( !is_null($isAddAddress) )
                        $msg->isAddAddress = $isAddAddress;
                    if ( !is_null($address) )
                        $msg->address = $address;
                    if ( !is_null($state) )
                        $msg->state = $state;
                    if ( !is_null($city) )
                        $msg->city = $city;
                    if ( !is_null($code) )
                        $msg->code = $code;
                    if ( !is_null($telephone) )
                        $msg->telephone = $telephone;
                    if ( !is_null($isAutoBuy) )
                        $msg->isAutoBuy = $isAutoBuy;
                    if ( !is_null($goodsList) )
                        $msg->goodsList = $goodsList;
                    if ( !is_null($goodsName) )
                        $msg->goodsName = $goodsName;
                    if ( !is_null($cardNumber) )
                        $msg->cardNumber = $cardNumber;
                    if ( !is_null($CW) )
                        $msg->CW = $CW;
                    if ( !is_null($term) )
                        $msg->term = $term;
                    if ( !is_null($intervalTime) )
                        $msg->intervalTime = $intervalTime;
                    if ( !is_null($note) )
                        $msg->note = $note;
                    $msg->save();
                } catch (Exception $e) {
                    return response()->json(['status' => 'error', 'msg' => '无权操作']);
                }
        }
        return response()->json(['status'=>'ok'],200);
    }
}
