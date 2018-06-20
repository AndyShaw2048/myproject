<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="acceptRequestBool" title="接受请求">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">接受条数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="acceptRequestNum" placeholder="请输入接受条数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="sendMessageBool" title="发送消息">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">发送条数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="sendMessageNum" placeholder="请输入发送条数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="hailBool" title="打&nbsp;&nbsp;招&nbsp;呼">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">次&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="hailNum" placeholder="请输入次数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="addFriendBool" title="添加好友">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">添加人数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="addFriendNum" placeholder="请输入添加人数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>

                <div class="layui-form-item">
                    <label class="layui-form-label">发送内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="content" placeholder="请输入发送内容" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">间隔时长</label>
                    <div class="layui-input-block">
                        <input type="text" name="intervalTime" placeholder="请输入间隔时间" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">所&nbsp;&nbsp;在&nbsp;地</label>
                    <div class="layui-input-block">
                        <input type="text" name="area" placeholder="请输入所在地" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">共同好友</label>
                    <div class="layui-input-block">
                        <input type="text" name="mutualFriend" placeholder="请输入共同好友数量" autocomplete="off" class="layui-input">
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
                    url: '/messenger',
                    data: {multi:check_val,
                        detail:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/messenger'",2000);
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