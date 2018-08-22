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
                <label class="layui-form-label">首次运行授权码</label>
                <div class="layui-input-block">
                    <input value="{{$r->auth_code}}" type="text" name="authCode" required  lay-verify="required" placeholder="请输入授权码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">评论输入框</label>
                <div class="layui-input-block">
                    <input value="{{$r->comment}}" type="text" name="comment" required  lay-verify="required" placeholder="输入要评论话语" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">搜索话题</label>
                <div class="layui-input-block">
                    <input value="{{$r->topic}}" type="text" name="topic" required  lay-verify="required" placeholder="输入5个话题（用逗号隔开）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">给粉丝发消息</label>
                <div class="layui-input-block">
                    <input value="{{$r->message}}" type="text" name="message" required  lay-verify="required" placeholder="输入给粉丝的消息" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上传照片数量</label>
                <div class="layui-input-block">
                    <input value="{{$r->images_num}}" type="text" name="imagesNum" required  lay-verify="required" placeholder="输入数字，最多为10" autocomplete="off" class="layui-input" max="10">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">评论发布照片</label>
                <div class="layui-input-block">
                    <input value="{{$r->comment_images}}" type="text" name="commentImages" required  lay-verify="required" placeholder="输入3句评论（用逗号隔开）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">人物点击间隔时间</label>
                <div class="layui-input-block">
                    <input value="{{$r->interval_time}}" type="text" name="intervalTime" required  lay-verify="required" placeholder="请输入人物点击间隔时间" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">每轮运行间隔</label>
                <div class="layui-input-block">
                    <input value="{{$r->round_time}}" type="text" name="roundTime" required  lay-verify="required" placeholder="输入运行停止时间（分）" autocomplete="off" class="layui-input">
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