<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="isRegister" title="注 册 新 账号">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">姓：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="lastName" placeholder="请输入  姓" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="firstName" placeholder="请输入  名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px;margin-left: 260px">邮箱：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="email" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">密码：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="isAddAddress" title="添加收货地址">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">收货地址：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="address" placeholder="请输入收货地址" autocomplete="off" class="layui-input" style="width: 508px">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px;margin-left: 260px">州名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="state" placeholder="请输入州名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">城市名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="city" placeholder="请输入城市名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px;margin-left: 260px">邮政编码：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="code" placeholder="请输入邮政编码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">手机号：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="telephone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="isRegister" title="自&nbsp;&nbsp;动&nbsp;&nbsp;购&nbsp;&nbsp;买">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">商品名称：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="goodsName" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">商品列表：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="goodsList" placeholder="请输入商品列表" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px;margin-left: 260px">银行卡号：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="cardNumber" placeholder="请输入银行卡号" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">CVV：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="CW" placeholder="请输入CVV" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px;margin-left: 260px">期限：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="term" placeholder="请输入期限" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="isAutoLike" title="自&nbsp;&nbsp;动&nbsp;&nbsp;点&nbsp;&nbsp;赞">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">点赞个数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="likeAmount" placeholder="请输入点赞个数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">商品名称：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="likeGoodsName" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">间隔时长</label>
                    <div class="layui-input-block">
                        <input type="text" name="intervalTime" placeholder="请输入间隔时间" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注</label>
                    <div class="layui-input-block">
                        <input type="text" name="note" placeholder="请输入备注" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="editForm">批量修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        var element = layui.element;
        element.render();
        //…
    });
    //Demo
    layui.use('form', function(){
        var form = layui.form;
        form.render();
        //监听提交
        form.on('submit(editForm)', function(data){
//            layer.msg(JSON.stringify(data.field));
            //获取多选框的值
            obj = document.getElementsByClassName('grid-row-checkbox');
            check_val = [];
            for(k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].getAttribute('data-id'));
            }
            console.log(check_val);

            if (check_val.length == 0)
            {
                toastr.warning('请勾选需要修改的信息');
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: '/wish',
                    data: {multi:check_val,
                        data:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/wish'",2000);
                        toastr.success('更新成功');
                    },
                    error: function(xhr, type){
                        toastr.error('更新失败');
                    }
                });
            }

            return false;
        });
    });
</script>