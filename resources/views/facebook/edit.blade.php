<div class="layui-container">
    <div style="text-align: right">
        <a href="/admin/facebook" class="layui-btn layui-btn-primary">返回列表</a>
    </div>
    <div class="" style="font-size: 16px">
        <form class="layui-form" action="">
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">所属机器码</p>
            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">机器码</label>
                <div class="layui-input-block">
                    <input type="text" hidden value="{{$fb->id}}" name="id">
                    <input value="{{$fb->machine_code}}" type="text" name="machineCode" required  lay-verify="required" placeholder="请输入机器码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">功能勾选(每次循环)</p>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="addFriendBool" title="加&nbsp;&nbsp;好&nbsp;友" {{$fb->addfriend_bool == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">好友数量：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->addfriend_num}}" type="text" name="addFriendNum"  placeholder="请输入添加好友数量" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="acceptRequestBool" title="接受请求"  {{$fb->acceptrequest_bool == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">请求数量：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->acceptrequest_num}}" type="text" name="acceptRequestNum" placeholder="请输入接受请求数量" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="intoGroupBool" title="拉进小组"  {{$fb->intogroup_bool == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">群&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->intogroup_groupname}}" type="text" name="intoGroupName" placeholder="请输入小组名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="padding-left: 232px">
                <label class="layui-form-label" style="width: 130px">拉群人数：</label>
                <div class="layui-input-block">
                    <input value="{{$fb->intogroup_number}}"  style="width: 184px" type="text" name="intoGroupNumber" placeholder="请输入拉进群的人数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="pointZanBool" title="点&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;赞"  {{$fb->pointzan_bool == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">点赞次数：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->pointzan_num}}" type="text" name="pointZanNum" placeholder="请输入点赞次数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">额外加好友条件</p>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input type="checkbox" name="mutualFriendBool" title="共同好友"  {{$fb->mutualfriend_bool == 'true' ? 'checked' : ''}}>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">共同好友：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->mutualfriend_num}}" type="text" name="mutualFriendNum" placeholder="超出该数量则检查地址" autocomplete="off" class="layui-input">
                </div>
            </div>
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">指定小组加好友条件</p>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input  {{$fb->appointgroup_bool == 'true' ? 'checked' : ''}} type="checkbox" name="appointGroupBool" title="指定小组">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">小组名称：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->appointgroup_name}}" type="text" name="appointGroupName"  placeholder="请填写指定小组名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline" style="padding-left: 230px">
                <label class="layui-form-label" style="width: 130px">小组人数：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->appointgroup_number}}" type="text" name="appointGroupNumber"  placeholder="请填写每次加好友人数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">通讯录加好友条件</p>
            <hr>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input {{$fb->contactadd_bool == 'true' ? 'checked' : ''}} type="checkbox" name="contactAddBool" title="加 好 友">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">好友人数：</label>
                <div class="layui-input-inline">
                    <input value="{{$fb->contactadd_number}}" type="text" name="contactAddNumber"  placeholder="请输入通讯录加好友人数" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-form-item">
                <label class="layui-form-label">间隔时长</label>
                <div class="layui-input-block">
                    <input value="{{$fb->intervaltime_num}}" type="text" name="intervalTimeNum" placeholder="请输入间隔时间（分钟）" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">匹配地区</label>
                <div class="layui-input-block">
                    <select name="area">
                        <option value=""></option>
                        <option value="美国" {{$fb->area=='美国' ? 'selected':''}}>美国</option>
                        <option value="德国" {{$fb->area=='德国' ? 'selected':''}}>美国</option>
                        <option value="英国" {{$fb->area=='英国' ? 'selected':''}}>英国</option>
                        <option value="台湾" {{$fb->area=='台湾' ? 'selected':''}}>台湾</option>
                        <option value="日本" {{$fb->area=='日本' ? 'selected':''}}>日本</option>
                        <option value="泰国" {{$fb->area=='泰国' ? 'selected':''}}>泰国</option>
                        <option value="新加坡" {{$fb->area=='新加坡' ? 'selected':''}}>新加坡</option>
                        <option value="马来西亚" {{$fb->area=='马来西亚' ? 'selected':''}}>马来西亚</option>
                        <option value="香港、澳门" {{$fb->area=='香港、澳门' ? 'selected':''}}>香港、澳门</option>
                    </select>
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
                url: '/admin/facebook/edit',
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