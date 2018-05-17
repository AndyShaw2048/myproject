<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <div class="layui-inline">
                    <label class="layui-form-label">模式</label>
                    <div class="layui-input-inline">
                        <select name="mode" id="mode1" lay-filter="mode">
                            <option value=""></option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">关键词</label>
                    <div class="layui-input-inline">
                        <input type="text" name="keyword" placeholder="请输入关键词（不为空）" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">匹配商品名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="matchingName" placeholder="请输入匹配商品名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline" id="relation_name">
                    <label class="layui-form-label">关联商品名</label>
                    <div class="layui-input-inline">
                        <input style="width: 197px" type="text" id="relationName" name="relationName" placeholder="请输入关联商品名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-inline">
                        <input type="text" name="note" placeholder="请输入备注" autocomplete="off" class="layui-input">
                    </div>
                </div>
                {{--<input type="text" hidden name="multi" id="multiedit" value="">--}}
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
    //Demo
    layui.use('form', function(){
        var form = layui.form;

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
                    url: '/mcinfo',
                    data: {multi:check_val,
                        detail:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/mcinfo'",2000);
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