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
                    <input type="text" name="machineCode" required  lay-verify="required" placeholder="请输入机器码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">筛选条件</p>
            <div class="layui-form-item">
                <label class="layui-form-label">首次运行授权码</label>
                <div class="layui-input-block">
                    <input type="text" name="authCode" placeholder="请输入授权码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">评论输入框</label>
                <div class="layui-input-block">
                    <input type="text" name="comment"  placeholder="输入要评论话语" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">搜索话题</label>
                <div class="layui-input-block">
                    <input type="text" name="topic"  placeholder="输入5个话题（用逗号隔开）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">给粉丝发消息</label>
                <div class="layui-input-block">
                    <input type="text" name="message"  placeholder="输入给粉丝的消息" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上传照片数量</label>
                <div class="layui-input-block">
                    <input type="text" name="imagesNum"  placeholder="输入数字，最多为10" autocomplete="off" class="layui-input" max="10">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">评论发布照片</label>
                <div class="layui-input-block">
                    <input type="text" name="commentImages" placeholder="输入3句评论（用逗号隔开）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">人物点击间隔时间</label>
                <div class="layui-input-block">
                    <input type="text" name="intervalTime" placeholder="请输入人物点击间隔时间" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">每轮运行间隔</label>
                <div class="layui-input-block">
                    <input type="text" name="roundTime" placeholder="输入运行停止时间（分）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <hr>
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
                url: '/admin/instagram',
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
                    toastr.error('添加失败');
                }
            });

            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>