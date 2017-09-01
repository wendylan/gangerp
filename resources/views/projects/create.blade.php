@extends('backpack::layout')


<style type="text/css">
	html body .warpper-main{
		width:100%;
		max-width:1024px;
		margin:auto;
		padding:15px;
		border-radius:5px;
		background:#FFF;
	}
	.route-page-bids-1, .route-page-bids-2, .route-page-bids-3{
		width:100%;
		padding:15px;
	}
	body,h3{
		/*font-family:"微软雅黑";*/
	}
	.set-width-8{
		width:80%;
	}
	.clear-float{
		clear:both;
	}
	.row>div{
		border-radius:5px;
	}
	.box{
		max-width:1024px;
		margin:auto;
	}
	label.error{
		color:#d9534f;
	}
	.project-page .form-group{
		height: 60px;
	}
	#project-table, #project-table-2{
		display:none;
	}
	html body .multiselect-clear-filter{
		padding: 9px;
	}
	html body .warpper-main .box button.multiselect{
		width: 100%;
		text-align: left;
	}
	html body .warpper-main .box .multiselect-native-select div.btn-group{
		width:100%;
	}
	html body div.warpper-main .center-td{
		vertical-align:middle;
	}
	html body #project-table-2{
		border-bottom:none;
	}
	.labelauty-radio label{
		float:left;
		margin:5px;
	}
	.warpper-main hr{
		border-top: solid 1px #FFF;
	}
	html body .bg-success{
		padding:15px;
	}
	.deposit{
		display:none;
	}

	html body .project-page .table>tbody>tr>td, html body .project-page .table>tbody>tr>th, html body .project-page .table>tfoot>tr>td, html body .project-page .table>tfoot>tr>th, html body .project-page .table>thead>tr>td, html body .project-page .table>thead>tr>th{
	    vertical-align: middle;
	}

	.project-table-2 select, .project-table-2 input{
		border:solid 1px #DEDEDE;
	}

	#project-table input,#project-table-2 input, #project-table select, #project-table-2 select{
		height: 25px;
		padding: 0px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s
	}
	#project-table select{

	}
	.select-address select{
		float:left;
		width:150px;
	}
	.select-address input{
		float:left;
		width:150px;
	}
	.select-products select{
		float:left;
		width:150px;
	}
	.select-products input{
		float:left;
		width:150px;
	}
</style>

@section("content")

<div class="warpper-main project-page">
	<h3 style="text-align:center;">新建项目</h3>
	<form id="project-form" role="form" action="/projects" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	  	<div class="route-page-bids-1">
	  		<p class="bg-success">选择您的项目与项目地址</p>
				<div class="form-group">
					<label for="exampleInputEmail1">项目名称</label>						  
				<input name="name" type="text" class="form-control" placeholder="" required />
				</div>

				<div class="form-group select-address">
					<label for="exampleInputEmail1">地址</label>
					<div>
						<select id="_s_province" name="s_province" class="form-control" required></select>  
					    <select id="_s_city" name="s_city" class="form-control" required></select>  
						<select id="_s_county" name="s_county" class="form-control" required></select>
						<input name="add" type="text" class="form-control" placeholder="详细地址" required>
					</div>
				</div>

			<p class="bg-success">选择您所需要的材料</p>
				<div class="form-group">
					<label for="brands">品牌范围</label>
					<br>
					<select name="brands[]" class="form-control more-select" multiple="multiple">
					@foreach ($brands as $brand)
							<option value="{{$brand->id}}">{{ $brand->name }}</option>
					@endforeach
					</select>
				</div>
				<div class="form-group select-products">
					<label for="mtype">选择材料相关</label>
					<div>
						<select name="m_name" class="form-control" required>
							<option disabled="disabled" selected="true">选择材料名称</option>
							<option selected="true">钢筋</option>
						</select>
						<select name="c_type" class="form-control" required>
							<option disabled="disabled" selected="true">选择计量方式</option>
							<option>过磅</option>
							<option>理计</option>
						</select>
						<input name="amount" type="text" class="form-control" placeholder="材料总量(吨)" required />
					</div>
				</div>
	  	</div>

	  	<div class="route-page-bids-2">
	  		<p class="bg-success">告诉投标方您的报价要求,以及结算要求</p>
	  		<label for="exampleInputPassword1">结算要求</label>
	  		<div class="form-group pay-require">
			@foreach ($q_request as $r)
				@if(qr_to_id($r) == 1)
					<label>
						<input name="q_request[]" type="checkbox" value="{{ $r }}" data-name={{$r}} data-labelauty="{{ $r }}" checked="checked" disabled="true" />
					</label>
					<input name="q_request[]" type="hidden" value="{{ $r }}" />
				@else
					<label>
						<input name="q_request[]" type="checkbox" value="{{ $r }}" data-name={{$r}} data-labelauty="{{ $r }}" />
					</label>
				@endif
			@endforeach
	  		</div>
	  		<div style="clear:both;"></div>
	  		{{-- <div class="form-group">
	  			<label for="exampleInputPassword1">报价说明</label>
	  			<input  type="text" class="form-control" placeholder="" required>
	  		</div> --}}
	  		<div class="form-group">
	  			<label for="exampleInputPassword1">结算条件</label>
	  			<textarea style="height:200px;" name="settlement" type="text" class="form-control" placeholder="" required ></textarea>
	  			<div style="clear:both;"></div>
	  		</div>
	  		<div class="form-group" style="margin-top:190px;">
	  			<label for="exampleInputEmail1">付款方式</label>
	  			<select name="paytype" class="form-control paytype" required>
	  			  @foreach ($pay_type as $p)
	  				<option>{{ $p }}</option>
	  			  @endforeach
	  			</select>
	  			<input type="text" class="form-control other-pay" style="margin-top:10px;display:none;" placeholder="填写其他付款方式" required>
	  		</div>
	  	</div>
			
		<div style="clear:both;"></div>
		<br><br>
		<button type="button" id="project-route-btn" class="btn btn-success set-width-8" style="max-width:500px;display:block;margin:0px auto 10px auto;">新建项目</button>

	</form>
</div>

	

<script>
	//初始化选择城市控件
	_init_area(["_s_province","_s_city","_s_county"]);
	$("#_s_province").val("广东省");
	change(1);

	
	//初始化jquery-labelauty
	$(document).ready(function(){
		$(".warpper-main :checkbox").labelauty();
		$(".warpper-main :radio").labelauty();
		

		$(".paytype").change(function(){
			if($(this).val() == "其他"){
				$(".other-pay").css("display","block");
			}else{
				$(".other-pay").css("display","none");
			}
		});
	});


	//表单验证
	$("#project-route-btn").click(function(){
		var checkboxValue = false;
		$(".pay-require>label>label").each(function(){
			if($(this).attr("aria-checked")=="true"){
				checkboxValue = true;
			}
		});
		console.log($("select[name='brands[]']").selected)
		if($(".multiselect-container li.active").length>0){
			if(checkboxValue){
				$("#project-form").submit();
			}else{
				alert("请选择结算要求");
			}
		}else{
			alert("请选择品牌范围");
		}
		
		
	});
	//表单验证配置
	$("#project-form").validate({
		debug : false,
		rules : {
			name : {
				required : true,
				pattern : /^[^-~]{0,20}$/
			},
			q_request : {
				required : true
			}
		},
		messages : {
			name : {
				required : "请输入项目名称",
				pattern : "文字在20个字符以内"
			}
		}
		// errorElement : "em"
	});
	

	//选择是否需要保证金
	$(".deposit-pay").click(function(){
		$(".deposit").show(300);
		$(this).parents(".deposit-choose").html("选择缴纳保证金所需的信息");
	});
	$(".no-pay").click(function(){
		$(this).parents(".deposit-choose").hide(300);
	});

	//选择显示何种报价
	function showCostTable(){
		$("#project-table").show();
		$("#project-table-2").hide();
	}
	function showBrandTable(){
		$("#project-table-2").show();
		$("#project-table").hide();
	}
</script>

@endsection