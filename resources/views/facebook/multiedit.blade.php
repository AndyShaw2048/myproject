<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">功能勾选(每次循环)</p>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="addFriendBool" title="加&nbsp;&nbsp;好&nbsp;友" value="on">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">好友数量：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="addFriendNum"  placeholder="请输入添加好友数量" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="acceptRequestBool" title="接受请求">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">请求数量：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="acceptRequestNum" placeholder="请输入接受请求数量" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="intoGroupBool" title="拉进小组">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">群&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="intoGroupName" placeholder="请输入小组名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" style="padding-left: 232px">
                    <label class="layui-form-label" style="width: 130px">拉群人数：</label>
                    <div class="layui-input-block">
                        <input style="width: 165px" type="text" name="intoGroupNumber" required  lay-verify="required" placeholder="请输入拉进群的人数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="pointZanBool" title="点&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;赞">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">点赞次数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="pointZanNum" placeholder="请输入点赞次数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>

                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">额外加好友条件</p>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="mutualFriendBool" title="共同好友">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">共同好友：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="mutualFriendNum" placeholder="超出该数量则检查地址" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>

                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">指定小组加好友条件</p>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="appointGroupBool" title="指定小组">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">小组名称：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="appointGroupName"   lay-verify="required" placeholder="请填写指定小组名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-inline" style="padding-left: 230px">
                    <label class="layui-form-label" style="width: 130px">小组人数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="appointGroupNumber"   lay-verify="required" placeholder="请填写每次加好友人数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">通讯录加好友条件</p>
                <hr>
                <div class="layui-inline">
                    <div class="layui-input-block">
                        <input type="checkbox" name="contactAddBool" title="加 好 友">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width: 130px">好友人数：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="contactAddNumber"   lay-verify="required" placeholder="请输入通讯录加好友人数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <br>
                <div class="layui-form-item">
                    <label class="layui-form-label">间隔时长</label>
                    <div class="layui-input-block">
                        <input type="text" name="intervalTimeNum" placeholder="请输入间隔时间（分钟）" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">匹配地区</label>
                    <div class="layui-input-block">
                        <select name="area">
                            <option value=""></option>
                            <option value="美国">美国</option>
                            <option value="台湾">台湾</option>
                            <option value="日本">日本</option>
                            <option value="香港、澳门">香港、澳门</option>
                            <option value="新加坡">新加坡</option>
                            <option value="马来西亚">马来西亚</option>
                            <option value="泰国">泰国</option>
                        </select>
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
                    url: '/facebook',
                    data: {multi:check_val,
                        detail:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/facebook'",2000);
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