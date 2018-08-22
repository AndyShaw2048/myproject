<style>
    .layui-form-label{
        width:164px;
    }
    .layui-input {
        width: 88%;
    }
</style>
<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label">首次运行授权码</label>
                    <div class="layui-input-block">
                        <input type="text" name="authCode" required   placeholder="请输入授权码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">评论输入框</label>
                    <div class="layui-input-block">
                        <input type="text" name="comment" required   placeholder="输入要评论话语" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">搜索话题</label>
                    <div class="layui-input-block">
                        <input type="text" name="topic" required   placeholder="输入5个话题（用逗号隔开）" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">给粉丝发消息</label>
                    <div class="layui-input-block">
                        <input type="text" name="message" required   placeholder="输入给粉丝的消息" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">上传照片数量</label>
                    <div class="layui-input-block">
                        <input type="text" name="imagesNum" required   placeholder="输入数字，最多为10" autocomplete="off" class="layui-input" max="10">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">评论发布照片</label>
                    <div class="layui-input-block">
                        <input type="text" name="commentImages" required   placeholder="输入3句评论（用逗号隔开）" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">人物点击间隔时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="intervalTime" required   placeholder="请输入人物点击间隔时间" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">每轮运行间隔</label>
                    <div class="layui-input-block">
                        <input type="text" name="roundTime" required   placeholder="输入运行停止时间（分）" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="chargeForm">批量修改</button>
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
                    url: '/instagram',
                    data: {multi:check_val,
                        data:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/instagram'",2000);
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