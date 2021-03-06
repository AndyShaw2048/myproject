<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">筛选条件</h2>
        <div class="layui-colla-content">
            <div style="width: 600px;margin: 0 auto">
                <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">模式</label>
                    <div class="layui-input-block">
                        <select name="mode" id="mode1" lay-filter="mode">
                            <option value=""></option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">机器码</label>
                    <div class="layui-input-block">
                        <input type="text" name="machineCode" placeholder="请输入机器码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-block">
                        <input type="text" name="note" placeholder="请输入备注" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="filterForm">立即搜索</button>
                        <a href="{{url('admin/mcinfo')}}" class="layui-btn layui-btn-primary">撤销</a>
                    </div>
                </div>
            </form>
            </div>
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
        form.on('submit(filterForm)', function(data){
//            layer.msg(JSON.stringify(data.field['mode']));

            var url = window.location.href;
            url = url.split('?')[0] + "?";

            if(data.field['mode'] != '')
            {
                url = url + "&mode=" + data.field['mode'];
            }
            if(data.field['machineCode'] != '')
            {
                url = url + "&machineCode=" + data.field['machineCode'];
            }
            if(data.field['note'] != '')
            {
                url = url + "&note=" + data.field['note'];
            }

            window.location.href=url;
            return false;
        });

        form.on('submit(clearBtn)', function(data){
            alert(1);
            var url = window.location.href;
            url = url.split('?')[0] + "?";
            window.location.href=url;
            return false;
        });

        form.on('select(mode)',function(data){
            if(data.value == 2)
            {
                $('#relation_name').css('display','block');
            }
            else
            {
                $('#relation_name').css('display','none');
                $('#relationName').val("");
            }
        });
    });


</script>
