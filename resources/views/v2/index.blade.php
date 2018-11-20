<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>云控系统</title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="assets/i/app-icon72x72@2x.png">
    <meta name="msapplication-TileColor" content="#0e90d2">
    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->
    <link rel="stylesheet" href="assets/css/amazeui.min.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="css/checkbix.min.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
{{--Header--}}
<header class="am-topbar am-topbar-inverse" style="margin: 0;">
    <h1 class="am-topbar-brand">
        <a href="#">云控平台</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse am-topbar-right" id="doc-topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav">
            <li class="am-active"><a href="#">管理员后台</a></li>
            <li><a href="#">充值</a></li>
            <li><a href="#">余额:500元</a></li>
        </ul>

        <div class="am-topbar-right">
            <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
                <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>我的<span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="#">模块清单</a></li>
                    <li><a href="#">修改密码</a></li>
                    <li><a href="#">用户退出</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="am-g">

{{--左侧模块导航--}}
<div style="display: inline-block;float: left;padding: 0;" class="autoHeight am-u-sm-1 am-u-md-1 am-u-lg-1">
    <ul class="am-nav">
        <li class="am-nav-header" style="font-size: 14px;">模块清单</li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Instagram</a></li>
        <li class="am-nav-divider"></li>
        <li><a href="#">下载空间</a></li>
    </ul>
</div>

{{--分组模块--}}
<div style="display: inline-block;border:solid 1px lightgray;float: left;text-align: center;position: relative;padding: 0" class="autoHeight am-u-sm-2 am-u-md-2 am-u-lg-2">
    <div class="am-panel am-panel-primary" style="border: none;padding: 0px  16px">
        <div class="am-panel-hd" style="background-color: white;color: black">
            <div style="float: left"><input id="1" type="checkbox" class="checkbix" data-text=""></div>
            分组列表 <a class="rename-btn" style="padding-left: 32px"></a></div>
        <div class="am-panel-bd">
            <div class="group">
                <div style="float: left"><input id="1" type="checkbox" class="checkbix" data-text=""></div>
                分组一
                <a class="am-btn am-btn-primary am-btn-xs rename-btn" style="float: right">重命名</a>
            </div>
            <div class="group">
                <div style="float: left;"><input id="2" type="checkbox" class="checkbix" data-text=""></div>
                分组一
                <a class="am-btn am-btn-primary am-btn-xs rename-btn" style="float: right">重命名</a>
            </div>
            <div class="group">
                <div style="float: left"><input id="3" type="checkbox" class="checkbix" data-text=""></div>
                分组一
                <a class="am-btn am-btn-primary am-btn-xs rename-btn" style="float: right">重命名</a>
            </div>
        </div>
    </div>
    <div style="position: absolute;bottom: 0px;height: 36px;border-top: solid 1px lightgray;width: 100%;padding: 10px auto;">
        <a href="" class="am-btn am-btn-success am-btn-xs">添加分组</a>
        <a href="" class="am-btn am-btn-warning am-btn-xs">删除分组</a>
    </div>
</div>


{{--表格主体--}}
<div style="float: left;position: relative;height: 100px;" class="autoHeight am-u-sm-9 am-u-md-9 am-u-lg-9">
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
                <th width="40"><input id="2" type="checkbox" class="checkbix" data-text=""></th>
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
                <td><input id="2" type="checkbox" class="checkbix" data-text=""></td>
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
        <ul class="am-pagination am-pagination-right" style="margin: 0px;font-size: 12px;">
            <li class="am-disabled"><a href="#">&laquo;</a></li>
            <li class="am-active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&raquo;</a></li>
        </ul>
    </div>
</div>

</div>



<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="assets/js/amazeui.min.js"></script>

<script src="js/checkbix.min.js"></script>

{{--获取浏览器高度并设置左侧导航高度--}}
<script type="text/javascript">
    autodivheight();
    function autodivheight(){ //函数：获取尺寸
        //获取浏览器窗口高度
        var winHeight=0;
        if (window.innerHeight)
            winHeight = window.innerHeight;
        else if ((document.body) && (document.body.clientHeight))
            winHeight = document.body.clientHeight;
        //通过深入Document内部对body进行检测，获取浏览器窗口高度
        if (document.documentElement && document.documentElement.clientHeight)
            winHeight = document.documentElement.clientHeight;
        //DIV高度为浏览器窗口的高度
        elements = document.getElementsByClassName("autoHeight");
        for(i=0,len=elements.length;i<len;i++)
        {
            elements[i].style.height= winHeight-51 +"px";
        }

    }
    window.onresize=autodivheight; //浏览器窗口发生变化时同时变化DIV高度
    Checkbix.init();
</script>
</body>
</html>