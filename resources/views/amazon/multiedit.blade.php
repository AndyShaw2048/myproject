<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">功能勾选</p>
                <hr>
                <div class="layui-form-item">
                    <label class="layui-form-label">模式</label>
                    <div class="layui-input-block">
                        <select name="mode"  >
                            <option value=""></option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">关键词</label>
                    <div class="layui-input-block">
                        <input type="text" name="keyword" required    placeholder="请输入关键词" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="mPrime" title="匹配商品" value="on">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">匹配商品名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="matchingName"  placeholder="请输入匹配商品名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="rPrime" title="关联商品" value="on">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">关联商品名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="relationName"  placeholder="请输入关联商品名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline" style="padding-left: 230px;">
                    <label class="layui-form-label" style="width: 130px">间隔时长：</label>
                    <div class="layui-input-inline">
                        <input style="width: 70px" type="text" name="intervalMinute"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    分
                    <div class="layui-input-inline">
                        <input style="width: 70px" type="text" name="intervalSecond"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    秒
                </div>
                <br>
                <div class="layui-form-item">
                    <label class="layui-form-label">上网工具</label>
                    <div class="layui-input-block">
                        <select name="vpn"  >
                            <option value=""></option>
                            <option value="不指定">不指定</option>
                            <option value="SSR">SSR</option>
                            <option value="NordVPN">NordVPN</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">街道</label>
                    <div class="layui-input-block">
                        <input type="text" name="street" required    placeholder="请输入街道" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">城市名</label>
                    <div class="layui-input-block">
                        <input type="text" name="city" required    placeholder="请输入城市名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">州名</label>
                    <div class="layui-input-block">
                        <input type="text" name="state" required    placeholder="请输入州名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">邮编</label>
                    <div class="layui-input-block">
                        <input type="text" name="zip" required    placeholder="请输入邮编" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">联系方式</label>
                    <div class="layui-input-block">
                        <input type="text" name="contact" required    placeholder="请输入联系方式" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">卡号</label>
                    <div class="layui-input-block">
                        <input type="text" name="cardNum" required    placeholder="请输入卡号" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">到期月</label>
                    <div class="layui-input-block">
                        <input type="text" name="endMonth" required    placeholder="请输入到期月" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">到期年</label>
                    <div class="layui-input-block">
                        <input type="text" name="endYear" required    placeholder="请输入到期年" autocomplete="off" class="layui-input">
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
                    url: '/amazon2',
                    data: {multi:check_val,
                        data:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/facebook'",2000);
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