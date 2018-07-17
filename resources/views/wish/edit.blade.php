<div class="layui-container">
    <div style="text-align: right">
        <a href="/admin/wish" class="layui-btn layui-btn-primary">返回列表</a>
    </div>
    <div class="" style="font-size: 16px">
        <form class="layui-form" action="">
            {{csrf_field()}}
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">所属机器码</p>
            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">机器码</label>
                <div class="layui-input-block">
                    <input type="text" name="machineCode" value="{{$r->machine_code}}" required  lay-verify="required" placeholder="请输入机器码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">筛选条件</p>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="isRegister" title="注 册 新 账号" {{$r->isRegister == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">姓：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->lastName}}" type="text" name="lastName" placeholder="请输入  姓" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">名：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->firstName}}" type="text" name="firstName" placeholder="请输入  名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px;margin-left: 260px">邮箱：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->email}}" type="text" name="email" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">密码：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->password}}" type="text" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="isAddAddress" title="添加收货地址" {{$r->isAddAddress == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">收货地址：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->address}}" type="text" name="address" placeholder="请输入收货地址" autocomplete="off" class="layui-input" style="width: 508px">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px;margin-left: 260px">州名：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->state}}" type="text" name="state" placeholder="请输入州名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">城市名：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->city}}" type="text" name="city" placeholder="请输入城市名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px;margin-left: 260px">邮政编码：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->code}}" type="text" name="code" placeholder="请输入邮政编码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">手机号：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->telephone}}" type="text" name="telephone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="isRegister" title="自&nbsp;&nbsp;动&nbsp;&nbsp;购&nbsp;&nbsp;买" {{$r->isAutoBuy == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">商品名称：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->goodsName}}" type="text" name="goodsName" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">商品列表：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->goodsList}}" type="text" name="goodsList" placeholder="请输入商品列表" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px;margin-left: 260px">银行卡号：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->cardNumber}}" type="text" name="cardNumber" placeholder="请输入银行卡号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">CVV：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->CW}}" type="text" name="CW" placeholder="请输入CVV" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px;margin-left: 260px">期限：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->term}}" type="text" name="term" placeholder="请输入期限" autocomplete="off" class="layui-input">
                </div>
            </div>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="isAutoLike" title="自&nbsp;&nbsp;动&nbsp;&nbsp;点&nbsp;&nbsp;赞" {{$r->isAutoLike == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">点赞个数：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->likeAmount}}" type="text" name="likeAmount" placeholder="请输入点赞个数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">商品名称：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->likeGoodsName}}" type="text" name="likeGoodsName" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">间隔时长</label>
                <div class="layui-input-block">
                    <input value="{{$r->intervalTime}}" type="text" name="intervalTime" placeholder="请输入间隔时间" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注</label>
                <div class="layui-input-block">
                    <input value="{{$r->note}}" type="text" name="note" placeholder="请输入备注" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="wishForm">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>

    //Demo
    layui.use('form', function(){
        var form = layui.form;
        form.render();

        form.on('submit(wishForm)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.ajax({
                type: 'POST',
                url: '/admin/wish/edit',
                data: {data:data.field},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data[0]['code'] == 200)
                    {
                        $.message('修改成功');
                        window.setTimeout('location.reload()',3000);
                    }
                    if(data[0]['code'] == 201)
                    {
                        $.message({
                            message:data[0]['msg'],
                            type:'error'
                        });
                    }
                },
                error: function(xhr, type){
                    toastr.error('充值失败');
                }
            });

            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>