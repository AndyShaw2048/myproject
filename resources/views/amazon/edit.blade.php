<div class="layui-container">
    <div style="text-align: right">
        <a href="/admin/amazon2" class="layui-btn layui-btn-primary">返回列表</a>
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
                    <input type="text" name="machineCode" required  lay-verify="required" placeholder="请输入机器码" autocomplete="off" class="layui-input" value="{{$r->machine_code}}">
                </div>
            </div>

            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">功能勾选</p>
            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">模式</label>
                <div class="layui-input-block">
                    <select name="mode" lay-verify="required">
                        <option value=""></option>
                        <option value="1" {{$r->mode == 1 ? 'selected': ''}}>自动购买</option>
                        <option value="2" {{$r->mode == 2 ? 'selected': ''}}>强制关联</option>
                        <option value="3" {{$r->mode == 3 ? 'selected': ''}}>点击广告</option>
                        <option value="4" {{$r->mode == 4 ? 'selected': ''}}>关键词上首页</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">关键词</label>
                <div class="layui-input-block">
                    <input value="{{$r->keyword}}" type="text" name="keyword" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input {{$r->m_prime == 'true' ? 'checked' : ''}}  type="checkbox" name="mPrime" title="匹配商品" value="on">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">匹配商品名：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->matching_name}}"  type="text" name="matchingName"  placeholder="请输入匹配商品名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline">
                <div class="layui-input-block">
                    <input {{$r->r_prime == 'true' ? 'checked' : ''}} type="checkbox" name="rPrime" title="关联商品" value="on">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 130px">关联商品名：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->relation_name}}" type="text" name="relationName"  placeholder="请输入关联商品名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <br>
            <div class="layui-inline" style="padding-left: 230px;">
                <label class="layui-form-label" style="width: 130px">间隔时长：</label>
                <div class="layui-input-inline">
                    <input value="{{$r->interval_minute}}" style="width: 70px" type="text" name="intervalMinute"  placeholder="" autocomplete="off" class="layui-input">
                </div>
                分
                <div class="layui-input-inline">
                    <input value="{{$r->interval_second}}" style="width: 70px" type="text" name="intervalSecond"  placeholder="" autocomplete="off" class="layui-input">
                </div>
                秒
            </div>
            <br>
            <div class="layui-form-item">
                <label class="layui-form-label">上网工具</label>
                <div class="layui-input-block">
                    <select name="vpn" lay-verify="required">
                        <option value=""></option>
                        <option value="不指定" {{$r->vpn == '不指定' ? 'selected': ''}}>不指定</option>
                        <option value="SSR" {{$r->vpn == 'SSR' ? 'selected': ''}}>SSR</option>
                        <option value="NordVPN" {{$r->vpn == 'NordVPN' ? 'selected': ''}}>NordVPN</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">街道</label>
                <div class="layui-input-block">
                    <input value="{{$r->street}}" type="text" name="street" required  lay-verify="required" placeholder="请输入街道" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">城市名</label>
                <div class="layui-input-block">
                    <input value="{{$r->city}}" type="text" name="city" required  lay-verify="required" placeholder="请输入城市名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">州名</label>
                <div class="layui-input-block">
                    <input value="{{$r->state}}" type="text" name="state" required  lay-verify="required" placeholder="请输入州名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">邮编</label>
                <div class="layui-input-block">
                    <input value="{{$r->zip}}" type="text" name="zip" required  lay-verify="required" placeholder="请输入邮编" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">联系方式</label>
                <div class="layui-input-block">
                    <input value="{{$r->contact}}" type="text" name="contact" required  lay-verify="required" placeholder="请输入联系方式" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">卡号</label>
                <div class="layui-input-block">
                    <input value="{{$r->card_num}}" type="text" name="cardNum" required  lay-verify="required" placeholder="请输入卡号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">到期月</label>
                <div class="layui-input-block">
                    <input value="{{$r->end_month}}" type="text" name="endMonth" required  lay-verify="required" placeholder="请输入到期月" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">到期年</label>
                <div class="layui-input-block">
                    <input value="{{$r->end_year}}" type="text" name="endYear" required  lay-verify="required" placeholder="请输入到期年" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注</label>
                <div class="layui-input-block">
                    <input value="{{$r->note}}" type="text" name="note" placeholder="请输入备注" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitForm">立即提交</button>
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

        form.on('submit(submitForm)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.ajax({
                type: 'POST',
                url: '/admin/amazon2/edit',
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