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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="{{url('assets/css/amazeui.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/app.css')}}">
    <link rel="stylesheet" href="{{url('css/checkbix.min.css')}}">
    <link rel="stylesheet" href="{{url('css/home.css')}}">
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="{{url('assets/js/jquery.min.js')}}"></script>
    <script src="{{url('js/common.js')}}"></script>
    <script src="{{url('js/jquery.page.js')}}"></script>
</head>
<body>
{{--Header--}}
@include('partials.header')

{{--左侧模块导航--}}
@include('partials.navbar',['nav'=>'facebook'])

{{--分组模块--}}
<div id="group" style="display: inline-block;border:solid 1px lightgray;float: left;text-align: center;position: relative;padding: 0" class="autoHeight am-u-sm-2 am-u-md-2 am-u-lg-2">
    @include('v2.facebook.group')
</div>


{{--表格主体--}}
<div id="table" style="float: left;position: relative;height: 100px;" class="autoHeight am-u-sm-9 am-u-md-9 am-u-lg-9">
    @include('v2.facebook.table')
</div>

</div>




<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="{{url('http://libs.baidu.com/jquery/1.11.3/jquery.min.js')}}"></script>
<script src='{{url("http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js")}}'></script>
<script src="{{url('assets/js/amazeui.ie8polyfill.min.js')}}"></script>
<![endif]-->
<script src="{{url('assets/js/amazeui.min.js')}}"></script>

<script src="{{url('js/checkbix.min.js')}}"></script>

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

    //分组多选
    function changeState(isChecked)
    {
        var chk_list=document.getElementsByClassName('checkbox-group');
        for(var i=0;i<chk_list.length;i++)
        {
            if(chk_list[i].type=="checkbox")
            {
                chk_list[i].checked=isChecked;
            }
        }
    }
    var obj = $(".checkbox-group")
    obj.click(function(){
        if($("#checkAllGroup").prop('checked'))
        {
            console.log(true)
            $("#checkAllGroup").prop("checked", false)
        }
    })

</script>
</body>
</html>