<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量充值（<span style="color: darkcyan">请确保余额充足</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <div class="layui-inline">
                    <label class="layui-form-label" style="font-weight: bold">脚本费率</label>
                    <div class="layui-input-inline">
                        <span style="line-height: 38px;color: red">{{$r->rate}} 元/天</span>
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label" style="font-weight: bold">续费天数</label>
                    <div class="layui-input-inline">
                        <input type="text" name="amount" required  lay-verify="required" placeholder="请输入续费天数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="chargeForm">充值</button>
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
        form.on('submit(chargeForm)', function(data){
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
                    url: '/wish/multiCharge',
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