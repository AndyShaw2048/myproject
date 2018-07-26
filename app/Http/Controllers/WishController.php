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

        $r = Wish::where('machine_code', $id)->first();
        if ( !$r )
            return json_encode(array([
                                         'code' => 202
                                         , 'msg' => '该机器码不存在'
                                     ]), JSON_UNESCAPED_UNICODE);
        if($r->end_time <= date('Y-m-d',time()))
            return json_encode(array(
                                   'code' => '203'
                                   ,'msg' => '该机器码已过期，请续费'
                               ),JSON_UNESCAPED_UNICODE);
        return json_encode(array([
                                        'Model' => $r->model,
                                        'isRegister' => $r->isRegister,
                                        'lastName' => $r->lastName,
                                        'firstName' => $r->firstName,
                                        'email' => $r->email,
                                        'password' => $r->password,
                                        'isAddAddress' => $r->isAddAddress,
                                        'address' => $r->address,
                                        'state' => $r->state,
                                        'city' => $r->city,
                                        'code' => $r->code,
                                        'telephone' => $r->telephone,
                                        'isAutoBuy' => $r->isAutoBuy,
                                        'goodsName' => $r->goodsName,
                                        'goodsList' => $r->goodsList,
                                        'cardNumber' => $r->cardNumber,
                                        'CVV' => $r->CW,
                                        'term' => $r->term,
                                        'isAutoLike' => $r->isAutoLike,
                                        'likeAmount' => $r->likeAmount,
                                        'likeGoodsName' => $r->likeGoodsName,
                                        'intervalTime' => $r->intervalTime,
                                        'note' => $r->note
                                 ]), JSON_UNESCAPED_UNICODE);
    }

    public function multiedit(Request $request)
    {
        $isRegister = isset($request->data['isRegister']) ? 'true' : 'false' ;
//        $lastName = $request->data['lastName'];
//        $firstName = $request->data['firstName'];
//        $email = $request->data['email'];
//        $password = $request->data['password'];
        $isAddAddress = isset($request->data['isAddAddress']) ? 'true' : 'false' ;
//        $address = $request->data['address'];
//        $state = $request->data['state'];
//        $city = $request->data['city'];
//        $code = $request->data['code'];
//        $telephone = $request->data['telephone'];
        $isAutoBuy = isset($request->data['isAutoBuy']) ? 'true' : 'false' ;
        $goodsName = $request->data['goodsName'];
        $goodsList = $request->data['goodsList'];
//        $cardNumber = $request->data['cardNumber'];
//        $CW = $request->data['CW'];
//        $term = $request->data['term'];
        $isAutoLike = isset($request->data['isAutoLike']) ? 'true' : 'false' ;
        $likeAmount = $request->data['likeAmount'];
        $likeGoodsName = $request->data['likeGoodsName'];
        $intervalTime = $request->data['intervalTime'];
        $note = $request->data['note'];
        $multiArray = $request->multi;

        foreach ($multiArray as $item) {
            if ( Admin::user()->isRole('admin') ) {
                $r = Wish::find($item);
                if ( !is_null($isRegister) )
                    $r->isRegister = $isRegister;
//                if ( !is_null($lastName) )
//                    $r->lastName = $lastName;
//                if ( !is_null($firstName) )
//                    $r->firstName = $firstName;
//                if ( !is_null($email) )
//                    $r->email = $email;
//                if ( !is_null($password) )
//                    $r->password = $password;
                if ( !is_null($isAddAddress) )
                    $r->isAddAddress = $isAddAddress;
//                if ( !is_null($address) )
//                    $r->address = $address;
//                if ( !is_null($state) )
//                    $r->state = $state;
//                if ( !is_null($city) )
//                    $r->city = $city;
//                if ( !is_null($code) )
//                    $r->code = $code;
//                if ( !is_null($telephone) )
//                    $r->telephone = $telephone;
                if ( !is_null($isAutoBuy) )
                    $r->isAutoBuy = $isAutoBuy;
                if ( !is_null($goodsList) )
                    $r->goodsList = $goodsList;
                if ( !is_null($goodsName) )
                    $r->goodsName = $goodsName;
//                if ( !is_null($cardNumber) )
//                    $r->cardNumber = $cardNumber;
//                if ( !is_null($CW) )
//                    $r->CW = $CW;
//                if ( !is_null($term) )
//                    $r->term = $term;
                if ( !is_null($isAutoLike) )
                    $r->isAutoLike = $isAutoLike;
                if ( !is_null($likeAmount) )
                    $r->likeAmount = $likeAmount;
                if ( !is_null($likeGoodsName) )
                    $r->likeGoodsName = $likeGoodsName;
                if ( !is_null($intervalTime) )
                    $r->intervalTime = $intervalTime;
                if ( !is_null($note) )
                    $r->note = $note;
                $r->save();
            } else
                try {
                    $r = Wish::where('user_id',Admin::user()->id)->find($item);
                    if ( !is_null($isRegister) )
                        $r->isRegister = $isRegister;
//                    if ( !is_null($lastName) )
//                        $r->lastName = $lastName;
//                    if ( !is_null($firstName) )
//                        $r->firstName = $firstName;
//                    if ( !is_null($email) )
//                        $r->email = $email;
//                    if ( !is_null($password) )
//                        $r->password = $password;
                    if ( !is_null($isAddAddress) )
                        $r->isAddAddress = $isAddAddress;
//                    if ( !is_null($address) )
//                        $r->address = $address;
//                    if ( !is_null($state) )
//                        $r->state = $state;
//                    if ( !is_null($city) )
//                        $r->city = $city;
//                    if ( !is_null($code) )
//                        $r->code = $code;
//                    if ( !is_null($telephone) )
//                        $r->telephone = $telephone;
                    if ( !is_null($isAutoBuy) )
                        $r->isAutoBuy = $isAutoBuy;
                    if ( !is_null($goodsList) )
                        $r->goodsList = $goodsList;
                    if ( !is_null($goodsName) )
                        $r->goodsName = $goodsName;
//                    if ( !is_null($cardNumber) )
//                        $r->cardNumber = $cardNumber;
//                    if ( !is_null($CW) )
//                        $r->CW = $CW;
//                    if ( !is_null($term) )
//                        $r->term = $term;
                    if ( !is_null($isAutoLike) )
                        $r->isAutoLike = $isAutoLike;
                    if ( !is_null($likeAmount) )
                        $r->likeAmount = $likeAmount;
                    if ( !is_null($likeGoodsName) )
                        $r->likeGoodsName = $likeGoodsName;
                    if ( !is_null($intervalTime) )
                        $r->intervalTime = $intervalTime;
                    if ( !is_null($note) )
                        $r->note = $note;
                    $r->save();
                } catch (Exception $e) {
                    return response()->json(['status' => 'error', 'msg' => '无权操作']);
                }
        }
        return response()->json(['status'=>'ok'],200);
    }
}
