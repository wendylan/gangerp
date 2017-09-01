@extends('backpack::layout')
	
@section("content")
	<style>
		.warpper-main{
			width:100%;
			height:100%;
			margin:auto;
			padding:10px;
		}
		html body hr{
			border-bottom:solid 2px #FFF;
		}
		.form-box{
			width:300px;
			padding:15px;
			border-radius:5px;
			background-color:white;
		}
		.form-box input{
			display:block;
			margin:30px auto;
		}
		.form-box button{
			display: block;
			margin:auto;
		}
		.form-box h3{
			margin-bottom:15px;
			color:#999;
			text-align:center;
		}
	</style>

	<div class="warpper-main">
		<form action="/api/center/account-safe/password" method="post">
			{{ csrf_field() }}
			<div class="form-box">
				<h3>修改密码</h3>
				<input name="old_password" type="text" class="form-control" placeholder="输入旧密码" />
				<input name="new_password" type="text" class="form-control" placeholder="输入新密码" />
				<!-- <input name="old_password" type="text" class="form-control" placeholder="再次输入新密码" /> -->
				<button type="submit" class="btn btn-default">确定</button>
			</div>
		</form>
	</div>


	<script>
		setLeftBar("个人中心");
		setPageTitle("修改密码");
		setOptionFocus("修改密码");
	</script>

@endsection