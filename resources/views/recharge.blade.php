<p style="font-size: 20px;margin-top: 10px;margin-left: 20px;">充值</p>
<hr>
<div class="">
    <form class="layui-form" action="" method="post">
        {{csrf_field()}}
        <br>
        <div class="layui-inline">
            <label class="layui-form-label">当前余额</label>
            <div class="layui-input-inline">
                <span style="line-height: 36px;font-size: 16px;color: #02c3dd;font-weight: bold">{{\Encore\Admin\Facades\Admin::user()->balance}} 元</span>
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">序列号</label>
            <div class="layui-input-inline">
                <input type="text" name="number" required  lay-verify="required" placeholder="请输入序列号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline" style="text-align: center;">
            <div class="layui-input-block">
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
                url: '/admin/recharge',
                data: {serial:data.field},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data[0]['code'] == 200)
                    {
                        $.message('成功');
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


{{--表格--}}
<p style="font-size: 20px;margin-top: 50px;margin-left: 20px;">消费记录</p>
<hr>
<table class="layui-table">
    <colgroup>
        <col>
        <col>
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>流水号</th>
        <th>序列号</th>
        <th>金额</th>
        <th>充值时间</th>
    </tr>
    </thead>
    <tbody>
    @if($logs->isEmpty())
        <tr>
            <td colspan="10" style="text-align: center">暂无数据</td>
        </tr>
    @else
    @foreach($logs as $item)
    <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->serial}}</td>
        <td>{{$item->money}}</td>
        <td>{{$item->pay_time}}</td>
    </tr>
    @endforeach
    @endif
    </tbody>
</table>
<div style="text-align: center">
    {{$logs->links()}}
</div>

