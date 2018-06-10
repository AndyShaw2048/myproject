<p style="font-size: 20px;margin-top: 10px;margin-left: 20px;">统计</p>
<hr>
<div style="font-size: 18px;text-align: center">
    <span style="padding-left: 56px">已使用序列号 {{$num[0]}} 个，总金额 {{$money[0]}} 元</span>
    <span style="padding-left: 56px">未使用序列号 {{$num[1]}} 个，总金额 {{$money[1]}} 元</span>
    <span style="padding-left: 56px">序列号总数 {{$num[2]}} 个，总金额 {{$money[2]}} 元</span>
</div>

<p style="font-size: 20px;margin-top: 10px;margin-left: 20px;">条件</p>
<hr>
<div class="">
    <form class="layui-form" action="" method="post">
        {{csrf_field()}}

        <br>
        <div class="layui-inline">
            <label class="layui-form-label">金额</label>
            <div class="layui-input-inline">
                <input type="text" name="money" required  lay-verify="required" placeholder="请输入金额" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">生成数量</label>
            <div class="layui-input-inline">
                <input type="text" name="amount" required  lay-verify="required" placeholder="请输入生成数量" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline" style="text-align: center;">
            <div class="layui-input-block">
                <button class="layui-btn" type="submit" lay-submit >立即生成</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;
        form.render();

//        //监听提交
//        form.on('submit(formDemo)', function(data){
//            layer.msg(JSON.stringify(data.field));
//            return false;
//        });

    });

    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#endTime' //指定元素
        });
    });
</script>


{{--表格--}}
<p style="font-size: 20px;margin-top: 10px;margin-left: 20px;">列表(未使用)</p>
<hr>
<table class="layui-table">
    <colgroup>
        <col>
        <col>
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>唯一ID</th>
        <th>序列号</th>
        <th>金额</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>过期时间</th>
    </tr>
    </thead>
    <tbody>
    @if($sr->isEmpty())
        <tr>
            <td colspan="10" style="text-align: center">暂无数据</td>
        </tr>
    @else
    @foreach($sr as $item)
    <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->content}}</td>
        <td>{{$item->money}}</td>
        <td>{{$item->status ? '已使用':'未使用'}}</td>
        <td>{{$item->created_at}}</td>
        <td>{{$item->end_time}}</td>
    </tr>
    @endforeach
    @endif
    </tbody>
</table>
<div style="text-align: center">
    {{$sr->links()}}
</div>
