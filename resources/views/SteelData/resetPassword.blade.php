<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>重置密码</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="/data/assets/css/font-awesome.min.css">
	<style type="text/css"> 
		.help-block{
			color : #da1111;
		}
		* {
		    padding: 0;
		    margin: 0;
		}

		html,body {
		    background-color: #f8f8f8;
		    width: 100%;
		    height: 100%;
		}

		a,
		a:hover,
		a:focus {
		    text-decoration: none; 
		    color: #fff;
		}

		.main_contianer {
		    width: 100%;
		    height: 100%;
		}

		.left_box {
		    width: 60%;
		    height: 100%;
		    float: left;
		    background-color: #61c1cf;
		}
		.left_vertial{
			width: 100%;
			height: 420px;
		    margin-top: 160px;
		}
		.left_box>.left_vertial{
			display:inline-block;
			vertical-align: middle;
		}
		.logo {
		    width: 120px;
		    height: 120px;
		    margin: 0 auto;
		    /*margin-top: 180px;*/
		}

		.logo img{
			width: 120px;
			height: 120px;
			display: inline-block;
		}

		.main_text {
		    padding-top: 50px;
		    width: 80%;
		    margin: 0 auto;
		    clear: both;
		    text-align: center;
		}

		.text_a {
		    display: inline-block;
		    width: 100px;
		    height: 100px;
		    margin: 0 30px;
		}

		.text_span {
		    display: inline-block;
		    width: 100px;
		    margin-top: 10px;
		    font-size: 16px;
		    font-weight: bold;
		}

		.same_box {
		    border: 2px solid #fff;
		    border-radius: 50%;
		    width: 100px;
		    height: 100px;
		    line-height: 100px;
		    float: left;
		}

		.same_box i {
		    height: 100px;
		    line-height: 100px;
		    color: #fff;
		}

		.right_box {
		    width: 40%;
		    height: 100%;
		    float: left;
		    background-color: #2c394c;
		    color: #fff;
		}

		.right_top {
		    margin-top: 10px;
		    margin-right: 20px;
		}

		.right_content {
		    width: 60%;
		    /*height: 98%;*/
		    margin: 160px auto;
		    /*margin-top: 220px;*/
		}
		.right_vertial{
			width: 100%;
			height: 420px;
		}
		.right_content>.right_vertial{
			display:inline-block;
			vertical-align: middle;
		}

		.right_main {
		    margin-top: 50px;
		}

		.right_main h2{
			margin-top: 20px;
		}
		.input_style {
		    outline: none;
		    background: none;
		    border: none;
		    border-bottom: 1px solid #536071;
		    width: 100%;
		    height: 30px;
		    line-height: 30px;
		    font-size: 16px;
		    color: #fff;
		    opacity: 0.8;
		  	-webkit-box-shadow: 40px 40px 40px 40px #2c394c inset !important;
		  	box-shadow: 40px 40px 40px 40px #2c394c inset !important;
		}

		.password_forget {
		    margin-top: 20px;
		}

		.password_forget a {
		    text-decoration: underline;
		    color: #536071;
		}

		.remember_box {
		    margin-top: 20px;
		    color: #536071;
		}

		.button_style {
			outline: none;
		    border: none;
		    border-radius: 20px;
		    width: 80%;
		    height: 45px;
		    background-color: #67bd62;
		    color: #fff;
		    font-size: 16px;
		    margin-top: 20px;
		}
	</style>
	<script>
		function clickFocus(){
			var text = document.getElementById("email");
			if(text.value == ''){
				alert('请登录你的账号');
				text.focus();
				return false;
			}
		}
	</script>
</head>
<body>
	<script src="./data/dist/vendor.js"></script>
	<script>
	</script>
	<div class="main_contianer">
		<div class="left_box">
			<div class="left_vertial">
				<div class="logo">
					<img src="/data/images/logoq.png" alt="">
				</div>
				<div style="color: #fff;text-align: center;margin-bottom: 30px;">
					<p style="font-size: 30px; margin-top: -15px;">六六钢铁</p>
				</div>
				<div class="main_text">
					<a href="#" class="text_a" onclick="clickFocus()">
						<div class="same_box"><i class="fa fa-line-chart fa-3x"></i></div>
						<span  class="text_span">现货价格</span>
					</a>
					<a href="#" class="text_a" onclick="clickFocus()">
						<div class="same_box"><i class="fa fa-shopping-cart fa-3x"></i></div>
						<span class="text_span" >买买买</span>
					</a>
					<a href="#" class="text_a" onclick="clickFocus()">
						<div class="same_box"><i class="fa fa-joomla fa-3x"></i></div>
						<span  class="text_span">资源推荐</span>
					</a>
					<a href="#" class="text_a" onclick="clickFocus()">
						<div class="same_box"><i class="fa fa-th fa-3x"></i></div>
						<span  class="text_span">下单管理</span>
					</a>
					<a href="#" class="text_a" onclick="clickFocus()">
						<div class="same_box"><i class="fa fa-table fa-3x"></i></div>
						<span  class="text_span">项目管理</span>
					</a>
				</div>
			</div>
		</div>
		<div class="right_box">
			<div class="right_top">
				<p style="float: right;">
					<a href="{{ url('/login') }}" >登录</a>
					<span>|</span>
					<a href="{{ url('/register') }}">注册</a>
				</p>
			</div>
			<div class="right_content">
				<div class="right_vertial">
					<form  method="POST" action="login">
						<h3>重置密码:</h3>
						<div class="right_main">
							<h3>账号:</h3>
							<input type="text" class="input_style" value="{{ old('email') }}" name="account" id="email" />
							@if ($errors->has('account'))
                                <span class="help-block">
                                    <font>{{ $errors->first('account') }}</font>
                                </span>
                            @endif
							<!-- {{ $errors->has('email')}} -->
							<h3 style="margin-top: 10px;">原有密码:</h3>
							<input type="password" class="input_style" name="password" type="password" id="password" />
							@if ($errors->has('password'))
                                <span class="help-block">
                                    <font>{{ $errors->first('password') }}</font>
                                </span>
                            @endif
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <font>{{ $errors->first('email') }}</font>
                                </span>
                            @endif
							<p class="password_forget">
								<a href="#">忘记密码?</a>
							</p>
						</div>
						<p class="remember_box">
							<input type="checkbox" name="remember" id="remember" class="remember">
							<label for="remember">记住密码</label>
						</p>
						<button class="button_style" type="submit">登录</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>