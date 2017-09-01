@extends('backpack::layout')
	
@section("content")
	<style>
		.warpper-main{
			width:100%;
			height:100%;
			margin:auto;
			padding:10px;
		}
		.list-box, .account-box{
			width:100%;
		}
		.account-box{
			padding:13px;
			margin:10px 0px 10px 0px;
			border-radius:5px;
			background-color:#FFF;
			text-align: center;
		}
		html body .head-box{
			font-weight:700;
			background-color:#ecf0f5;
			text-align: center;
			color:#888;
		}
		.content-box{
			float:left;
			width:14%;
			padding:0px 10px 0px 10px;
			smargin-top: 3;
			font-size:14px;
			line-height: 2.5;
		}
		.my-input{
			border:none;
			text-align:center;
		}
		form{
			margin:0px;
			padding:0px;
		}
		html body hr{
			border-bottom:solid 2px #FFF;
		}
	</style>

	<div class="warpper-main">

		<div class="list-box">
			<h2>子账号管理<button class="btn btn-primary" style="float:right;" onclick="createNewAccount()">新建子账号</button></h2>
			<hr/>
				<div class="account-box head-box">
					<div class="content-box">序号</div>
					<div class="content-box">姓名</div>
					<div class="content-box">联系号码</div>
					<div class="content-box">电子邮件</div>
					<div class="content-box">职务</div>
					<div class="content-box">权限</div>
					<div class="content-box">操作</div>
					<div style="clear:both;"></div>
				</div>
			@if(count($accountList) !== 0)
				<?php $count = 1; ?>
				@foreach($accountList as $data)
					<form action="/api/center/accounts/update" method="post">
						{{ csrf_field() }}
						<div class="account-box">
							<div class="content-box">
								<input name="id" type="hidden" value="{{ $data->id }}" />{{ $count++ }}
							</div>
							<div class="content-box"><input name="name" class="my-input" type="text" value="{{ $data->name }}" /></div>
							<div class="content-box"><input name="mobile" class="my-input" type="text" value="{{ $data->mobile }}" /></div>
							<div class="content-box"><input name="email" class="my-input" type="text" value="{{ $data->email }}" /></div>
							<div class="content-box"><input class="my-input" type="text" /></div>
							<div class="content-box">
								 <select class="multiple-select" multiple="multiple" name="post[]" id="">
								   @foreach($permissions as $p)
								   		<option value="{{$p->name}}"
										   @if(in_array($p->id,$data->perids))
										   {{"selected=true"}}
										   @endif
										    >{{$p->name}}</option>
								   @endforeach

								 	{{-- <option value="4">知会(仅接受异常情况和重要通知)</option>
								 	@if($data->post == 3)
								 		<option value="3" selected="true">决策</option>
								 	@else
								 		<option value="3">决策</option>
								 	@endif

								 	@if($data->post == 2)
								 		<option value="2" selected="true">复核</option>
								 	@else
								 		<option value="2">复核</option>
								 	@endif

								 	@if($data->post == 1)
								 		<option value="1" selected="true">录入</option>
								 	@else
								 		<option value="1">录入</option>
								 	@endif --}}
								 </select>
							</div>
							<div class="content-box">
								<button type="submit" class="btn btn-default btn-sm">修改</button>
								<button type="button" class="btn btn-default btn-sm" onclick="deleteAccount({{ $data->id }})">删除</button>
							</div>
							<div style="clear:both;"></div>
						</div>
					</form>

					<form action="/api/center/accounts/delete" method="post" id="delete-form-{{ $data->id }}">
						{{ csrf_field() }}
						<input type="hidden" name="id" value="{{ $data->id }}" />
					</form>
				@endforeach
			@else
				<h3 style="text-align:center;">没有任何子账号信息</h3>
			@endif
		</div>
	</div>

	<script>
		setOptionFocus("子账号管理");
		$(document).ready(function() {
		       $('.multiple-select').multiselect({
		       		buttonWidth : '150px'
		       });
		   });

		function createNewAccount(){
			var htmlModel = 
				'<h2>新增账号</h2>'+
				'<hr />' +
				'<form action="/api/center/accounts/create" method="post">' +
						'<div class="account-box">' +
							'<div class="content-box">' +
								'{{ csrf_field() }}'+
								'<input name="id" type="hidden"/>' +
								'<input type="hidden" name="id_info" />' +
								'新建账号'+
							'</div>' +
							'<div class="content-box"><input name="name" class="my-input" type="text" placeholder="输入姓名" /></div>' +
							'<div class="content-box"><input name="mobile" class="my-input" type="text" placeholder="输入手机号码" /></div>' +
							'<div class="content-box"><input name="password" class="my-input" type="password" placeholder="输入密码" /></div>' +
							'<div class="content-box"><input class="my-input" type="text" placeholder="设置职务" /></div>' +
							'<div class="content-box">' +
								'<select name="post[]" class="multiple-select" multiple="multiple" >' +
										'<option value="知会">知会(仅接受异常情况和重要通知)</option>' +
										'<option value="决策">决策</option>' +
										'<option value="复核">复核</option>' +
										'<option value="录入">录入</option>' +
								'</select>' +
							'</div>' +
							'<div class="content-box"><button type="submit" class="btn btn-default btn-sm">提交</button></div>' +
							'<div style="clear:both;"></div>' +
						'</div>' +
					'</form>';
			$(".warpper-main").append(htmlModel);
			$('.account-box .multiple-select').multiselect({
				buttonWidth : '150px'
			});
			$("input[name='name']").focus();
		}

		function deleteAccount(id){
			$("#delete-form-"+id).submit();
		}

		$(".slider-title-7").addClass("active");

	</script>

@endsection