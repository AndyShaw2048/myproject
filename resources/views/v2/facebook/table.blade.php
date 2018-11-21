<div style="padding-left: 50px;width: auto;float: left">
    <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
        <button class="am-btn am-btn-primary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>操作<span class="am-icon-caret-down"></span></button>
        <ul class="am-dropdown-content">
            <li><a href="#">删除</a></li>
        </ul>
    </div>
    <a href="" class="am-btn am-btn-primary am-btn-sm tools-btn">刷新</a>
    <a href="" class="am-btn am-btn-primary am-btn-sm tools-btn">添加到分组</a>
    <a href="" class="am-btn am-btn-primary am-btn-sm tools-btn">批量修改</a>
    <a href="" class="am-btn am-btn-primary am-btn-sm tools-btn">移动到</a>
</div>
<div style="position: absolute;right: 20px;float: right;display: inline-block">
    <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
        <button class="am-btn am-btn-primary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>显示操作<span class="am-icon-caret-down"></span></button>
        <ul class="am-dropdown-content">
            <li><a href="#">显示全部机器码</a></li>
            <li><a href="#">显示未分组机器码</a></li>
        </ul>
    </div>
    <a href="" class="am-btn am-btn-primary am-btn-sm tools-btn">筛选</a>
    <a href="" class="am-btn am-btn-primary am-btn-sm tools-btn">新建</a>
</div>

<div style="clear: both"></div>
<div style="padding-top: 14px;padding-left: 10px;">
    <table class="am-table am-table-bordered am-table-radius am-table-striped">
        <thead>
        <tr>
            <th width="40"><input id="checkAllRow" type="checkbox" class="checkbix" data-text=""></th>
            <th width="60">序号</th>
            <th width="160">机器码</th>
            <th width="100">模块</th>
            <th width="90">所属用户</th>
            <th width="200">备注</th>
            <th>过期时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input id="12" type="checkbox" class="checkbix" data-text=""></td>
            <td>1</td>
            <td>2012</td>
            <td>2012</td>
            <td>2012</td>
            <td>2012</td>
            <td>2012-10-01 13:24:22</td>
            <td>2012-10-01 13:24:22</td>
            <td><a class="am-icon-edit"></a> <a class="am-icon-remove"></a></td>
        </tr>
        </tbody>
    </table>
</div>
{{--分页--}}
<div style="position: absolute;bottom: 0px;right: 20px;">
    <div class="tcdPageCode"></div>
</div>
<script>
    $(".tcdPageCode").createPage({
        pageCount:5,
        current:1,
        backFn:function(p){
            console.log(p);
        }
    });
</script>