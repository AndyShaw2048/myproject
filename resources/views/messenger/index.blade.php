<div class="layui-container">
    <div style="text-align: right">
        <a href="/admin/messenger" class="layui-btn layui-btn-primary">返回列表</a>
    </div>
    <div class="" style="font-size: 16px">
        <form class="layui-form" action="">
            {{csrf_field()}}
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">所属机器码</p>
            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">机器码</label>
                <div class="layui-input-block">
                    <input type="text" name="machineCode" required  lay-verify="required" placeholder="请输入机器码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">筛选条件</p>
            <hr>
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
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="facebookForm">立即提交</button>
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

        form.on('submit(facebookForm)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.ajax({
                type: 'POST',
                url: '/admin/messenger',
                data: {data:data.field},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data[0]['code'] == 200)
                    {
                        $.message('添加成功');
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