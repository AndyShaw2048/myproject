<style>
    .layui-form-label{
        width:164px;
    }
    .layui-input {
        width: 88%;
    }
</style>
<div class="layui-container">
    <div style="text-align: right">
        <a href="/admin/instagram" class="layui-btn layui-btn-primary">返回列表</a>
    </div>
    <div class="" style="font-size: 16px">
        <form class="layui-form" action="">
            {{csrf_field()}}
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">所属机器码</p>
            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">机器码</label>
                <div class="layui-input-block">
                    <input type="text" hidden value="{{$r->id}}" name="id">
                    <input type="text" name="machineCode" value="{{$r->machine_code}}" required  lay-verify="required" placeholder="请输入机器码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">筛选条件</p>
            <div class="layui-form-item">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <input type="checkbox" name="thumb_prime" title="点赞" {{$r->thumb_prime == 'true' ? 'checked' : ''}}>
                    <input type="checkbox" name="follow_prime" title="关注" {{$r->follow_prime == 'true' ? 'checked' : ''}}>
                    <input type="checkbox" name="message_prime" title="发动态" {{$r->message_prime == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">话题</label>
                <div class="layui-input-block">
                    <input value="{{$r->topic}}" type="text" name="topic" placeholder="要搜索的话题内容" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">点赞</label>
                <div class="layui-input-block">
                    <input value="{{$r->thumb_count}}" type="text" name="thumb_count"  placeholder="请输入点赞次数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">评论内容</label>
                <div class="layui-input-block">
                    <input value="{{$r->context}}" type="text" name="context"  placeholder="请输入评论内容" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图片数量</label>
                <div class="layui-input-block">
                    <input value="{{$r->pic_count}}" type="text" name="pic_count"  placeholder="请输入要分享的图片张数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">发帖</label>
                <div class="layui-input-block">
                    <input value="{{$r->message}}" type="text" name="message"  placeholder="请输入发帖内容" autocomplete="off" class="layui-input" max="10">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">间隔时间</label>
                <div class="layui-input-block">
                    <input value="{{$r->interval}}" type="text" name="interval" placeholder="请输入间隔时长（分钟）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="instagramForm">立即提交</button>
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

        form.on('submit(instagramForm)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.ajax({
                type: 'POST',
                url: '/admin/instagram/edit',
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