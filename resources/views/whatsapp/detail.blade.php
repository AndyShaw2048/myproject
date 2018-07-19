<div class="layui-container">
    <div style="text-align: right;">
        <a href="/admin/whatsapp" class="layui-btn layui-btn-primary">返回列表</a>
    </div>
    <div class="" style="font-size: 16px">
        <form class="layui-form" action="" method="post">
            {{csrf_field()}}
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">所属机器码</p>
            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">机器码</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$mc->id}}" name="id" class="layui-input layui-hide">
                    <input type="text" value="{{$mc->machine_code}}" name="machineCode" class="layui-input" readonly disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备&nbsp;&nbsp;&nbsp;注</label>
                <div class="layui-input-block">
                    <input type="text" value="{{$mc->note}}" name="note" class="layui-input" readonly>
                </div>
            </div>
            <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;">电话号码</p>
            <hr>
            <table class="layui-table">
                <colgroup>
                    <col width="100">
                    <col width="600">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>序号</th>
                    <th>电话号码</th>
                    <th>添加时间</th>
                </tr>
                </thead>
                <tbody>
                @if($tel->isEmpty())
                    <tr>
                        <td colspan="3">暂无记录</td>
                    </tr>
                @else
                @foreach($tel as $i => $item)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$item->telephone}}</td>
                    <td>{{$item->created_at}}</td>
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>

        </form>
        <div class="layui-form-item">
            <div class="layui-input-block">
                {{--<button class="layui-btn" lay-submit lay-filter="defaultForm">下载记录</button>--}}
                <form action="/admin/whatsapp/telephones/export" method="post">
                    {{csrf_field()}}
                    <input type="text" hidden value="{{$mc->id}}" name="id">
                    <button type="submit" class="layui-btn layui-btn-primary">下载记录</button>
                </form>
            </div>
        </div>
    </div>
</div>


