<h1 style="font-size: 24px;">佣金提现<small style="padding-left: 4px">列表</small></h1>
<blockquote class="layui-elem-quote" style="margin: 10px 0">您当前佣金余额为： {{$rebate_money}} 元
    <button class="layui-btn layui-btn-default" id="withdraw_btn">提现</button></blockquote>
<div>
    <table class="layui-table">
        <colgroup>
            <col width="100">
            <col width="200">
            <col width="300">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>序号</th>
            <th>支付宝姓名</th>
            <th>支付宝账号</th>
            <th>提现金额</th>
            <th>状态</th>
            <th>提现时间</th>
        </tr>
        </thead>
        <tbody>
        @if($withdraw->isEmpty())
            <tr>
                <td colspan="6">暂无提现记录</td>
            </tr>
        @else
            @foreach($withdraw as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->account}}</td>
                    <td>{{$item->money}}</td>
                    <td>{{$item->status == 0 ? '提现中' : '已提现'}}</td>
                    <td>{{$item->created_at}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>

<div id="PopContent" hidden>
    <div style="margin: 10px 10px">
        <form class="layui-form" action="">
            <div class="layui-inline">
                <label class="layui-form-label">支付宝姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" required  lay-verify="required"  autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">支付宝账号</label>
                <div class="layui-input-inline">
                    <input type="text" name="account" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">提现金额</label>
                <div class="layui-input-inline">
                    <input type="text" name="money" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <br>
                *当前可提现 {{$rebate_money}} 元
            </div>
            <div style="text-align: center;margin-top: 10px">
                <button class="layui-btn" lay-submit lay-filter="withdrawForm">提现</button>
            </div>
        </form>
    </div>

</div>

<script>
    layui.use(['layer','form'], function(){
        var layer = layui.layer;
        var form = layui.form;
        form.render();

        $('#withdraw_btn').click(function(){
            layer.open({
                type: 1,
                title: false,
                closeBtn: 1,
                shade:false,
                shadeClose: false,
                skin: 'yourclass',
                content: $('#PopContent').html()
            });

            form.on('submit(withdrawForm)', function(data){
                console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
                $.ajax({
                    type: 'POST',
                    url: '/admin/rebate/withdraw',
                    data: {data:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        if(data['code'] == 200)
                        {
                            $.message('提现成功');
                            window.setTimeout('location.reload()',3000);
                        }
                        if(data['code'] == 201)
                        {
                            $.message({
                                message:data['msg'],
                                type:'error'
                            });
                        }
                    },
                    error: function(xhr, type){
                        toastr.error('提现');
                    }
                });

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });
        });

    });
</script>