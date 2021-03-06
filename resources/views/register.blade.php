<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <meta name="description" content="" />
    <title>云控平台-注册</title>
    <link rel="stylesheet" href="{{url('css/jq22.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/amazeui.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/app.css')}}">
</head>
<body>
<!-- begin -->
<div id="login">
    <div class="wrapper">
        <div class="login">
            <form action="" method="post" class="container offset1 loginform" data-am-validator>
                <div style="text-align: center;font-size: 24px;margin-top: 10px;color: grey">注册</div>
                {{csrf_field()}}
                <div id="owl-login">
                    <div class="hand"></div>
                    <div class="hand hand-r"></div>
                    <div class="arms">
                        <div class="arm"></div>
                        <div class="arm arm-r"></div>
                    </div>
                </div>
                <div class="pad" style="padding-top: 10px">
                    @if(!$errors->isEmpty() && ($errors->has('username')||$errors->has('password')))
                        <div class="am-alert am-alert-warning" data-am-alert style="width: 338px;margin: 0 auto;height: 40px;line-height: 20px;margin-bottom: 10px">
                            <button type="button" class="am-close">&times;</button>
                            <p>{{$errors->has('username') ? $errors->first('username') : ($errors->has('password') ? $errors->first('password') : null)}}</p>
                        </div>
                    @endif
                    @if($errors->has('error'))
                        <div class="am-alert am-alert-warning" data-am-alert style="width: 338px;margin: 0 auto;height: 40px;line-height: 20px;margin-bottom: 10px">
                            <button typeerror="button" class="am-close">&times;</button>
                            <p>{{$errors->first('error')}}</p>
                        </div>
                    @endif
                    @if($errors->has('msg'))
                        <div class="am-alert am-alert-success" data-am-alert style="width: 338px;margin: 0 auto;height: 40px;line-height: 20px;margin-bottom: 10px">
                            <button type="button" class="am-close">&times;</button>
                            <p>{{$errors->first('msg')}}</p>
                        </div>
                    @endif
                    <div class="control-group">
                        <div class="controls">
                            <label for="telephone" class="control-label fa fa-user"></label>
                            <input id="telephone" required  type="text" name="username" placeholder="账号" tabindex="1" autofocus="autofocus" class="form-control input-medium" value="{{old('username')}}">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label for="password" class="control-label fa fa-asterisk"></label>
                            <input id="password" required type="password" name="password" placeholder="密码" tabindex="2" class="form-control input-medium">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label for="password" class="control-label fa fa-asterisk"></label>
                            <input id="password" required type="password" name="password_confirmation" placeholder="确认密码" tabindex="2" class="form-control input-medium">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label for="password" class="control-label fa fa-envelope-o"></label>
                            <input id="invitation" required type="text" name="invitation" placeholder="邀请码" tabindex="2" class="form-control input-medium">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="/admin" tabindex="6" class="btn btn-link text-muted">登录</a>
                    <button type="submit" tabindex="4" class="btn btn-primary">注册</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{url('assets/js/jquery.min.js')}}"></script>
    <script src="{{url('assets/js/amazeui.min.js')}}"></script>
    <script>
        $(function() {
            $('#login #password').focus(function() {
                $('#owl-login').addClass('password');
            }).blur(function() {
                $('#owl-login').removeClass('password');
            });
        });
    </script>
</div>
<!-- end -->
</body>
</html>