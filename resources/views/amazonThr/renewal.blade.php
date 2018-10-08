<p style="font-size: 20px;margin-top: 10px;margin-left: 20px;">续费</p>
<hr>
<div class="" style="font-size: 16px">
    <form class="layui-form" action="" method="post">
            {{csrf_field()}}
        <input type="text" value="amazon" name="model" hidden>
            <div class="layui-inline">
                <label class="layui-form-label" style="font-weight: bold">机器码</label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$r->machine_code}}" name="amount" required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-inline">
                <label class="layui-form-label" style="font-weight: bold">脚本费率</label>
                <div class="layui-input-inline">
                    <span style="line-height: 38px;color: red">{{$r->ScriptInfo->rate}} 元/天</span>
                </div>
            </div>

            <div class="layui-inline">
                <label class="layui-form-label" style="font-weight: bold">续费天数</label>
                <div class="layui-input-inline">
                    <input name="mc_id" hidden value="{{$id}}">
                    <input name="machine_code" hidden value="{{$r->machine_code}}">
                    <input type="text" name="amount" required  lay-verify="required" placeholder="请输入续费天数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline" style="margin-left: 50px">
                    <button class="layui-btn layui-btn-sm" type="submit" lay-submit lay-filter="chargeForm" >充值</button>
                </div>
            </div>
        </form>

</div>

<script>

    //Demo
    layui.use('form', function(){
        var form = layui.form;
        form.render();

        form.on('submit(chargeForm)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}

            $.ajax({
                type: 'POST',
                url: '/admin/amazonThr/renewal',
                data: {data:data.field},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data[0]['code'] == 200)
                    {
                        $.message('成功');
                        window.setTimeout("location.href='/admin/amazonThr'",3000);
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