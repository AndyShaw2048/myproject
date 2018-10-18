<div class="layui-container">
    <div style="text-align: right">
        <a href="/admin/invitation" class="layui-btn layui-btn-primary">返回列表</a>
    </div>
    <div class="" style="font-size: 16px;">
        <form class="layui-form" action="">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">位数</label>
                <div class="layui-input-block">
                    <input type="number" max="8" name="decimal" autocomplete="off" lay-verify="required" class="layui-input" style="width: 900px">
                </div>
            </div>
            <br>
            <div class="layui-form-item">
                <label class="layui-form-label">数量</label>
                <div class="layui-input-block">
                    <input type="number" max="1000" name="number" autocomplete="off" lay-verify="required" class="layui-input" style="width: 900px">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitForm">立即提交</button>
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

        form.on('submit(submitForm)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.ajax({
                type: 'POST',
                url: '/admin/invitation',
                data: {data:data.field},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data['code'] == 200)
                    {
                        $.message('生成成功');
                        window.setTimeout('location.reload()',3000);
                    }
                    if(data['code'] == 201)
                    {
                        $.message({
                            message:data['msg'],
                            type:'error'
                        });
                    }
                },
                error: function(xhr, type){
                    toastr.error('生成失败');
                }
            });

            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>