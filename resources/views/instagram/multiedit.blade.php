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
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="thumb_prime" title="点赞">
                        <input type="checkbox" name="follow_prime" title="关注">
                        <input type="checkbox" name="message_prime" title="发动态">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">话题</label>
                    <div class="layui-input-block">
                        <input type="text" name="topic" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">点赞</label>
                    <div class="layui-input-block">
                        <input type="text" name="thumb_count"   autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">评论内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="context"   autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">图片数量</label>
                    <div class="layui-input-block">
                        <input type="text" name="pic_count"  autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">发帖</label>
                    <div class="layui-input-block">
                        <input type="text" name="message"  autocomplete="off" class="layui-input" max="10">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">间隔时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="interval" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="editedForm">批量修改</button>
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
        form.on('submit(editedForm)', function(data){
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