@extends('backpack::layout')
@section("content")
<style type="text/css">
	html body .warpper-main{
		width:100%;
		max-width:1024px;
		margin:auto;
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

	.form-for-4 .btn-group{
		width:100%;
	}
	.form-for-4 .btn-group button{
		width:100%;
	}

	.select-project select{
		float:left;
		width:60%;
	}
	.select-project>div div{
		float:right;
		width:38%;
	}

	.form-for-4 .form-group{
		float:left;
		width:24%;
		min-width:150px;
		padding-right:10px;
	}
	.form-for-3 .form-group{
		float:left;
		width:33%;
		min-width:150px;
		padding-right:10px;
	}
	.form-for-2 .form-group{
		float:left;
		width:33%;
		min-width:150px;
		padding-right:10px;
	}
	td label{
		width: 100%;
		height: 100%;
		text-align: center;
	}
</style>

<div class="warpper-main project-page">
	
	<form id="bids-form" role="form" action="/bids" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					第一步 : 基本信息
					</a>
				</h4>
			</div>
	    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
	        <div class="panel-body">
		      	<div class="route-page-bids-1">
		      		<p class="bg-success">选择您的项目与项目地址</p>
					<div class="form-group select-project">
						<label for="exampleInputEmail1">项目名称</label>
						<div>
							<select class="form-control" name="project_id" id="project-name" required>
								<option selected="true" disabled="disabled">选择项目</option>
	      				  		@foreach ($myprojects as $project)
								<option id="{{ $project['pid'] }}" value="{{ $project['pid'] }}">{{ $project['name'] }}</option>
						  		@endforeach
							</select>
							<div>
								<span>找不到项目?</span>&nbsp;&nbsp;&nbsp;
								<a href="/projects/create" class="btn btn-default btn-sm">新建</a>
							</div>
						</div>
					</div>
					<div class="form-for-2">
						<div class="form-group" select-connect>
							<label for="exampleInputPassword1" >采购联系人</label>
							<input name="contact_name" type="text" class="form-control" placeholder="请输入联系人姓名" required/>
						</div>
						<div class="form-group" select-connect>
							<label for="exampleInputPassword1" >联系人电话</label>
							<input name="contact_phone" type="text" class="form-control" placeholder="请输入联系人电话" number="true" minlength='11' maxlength="11" required />
						</div>
						<div style="clear:both;"></div>
					</div>

					<div class="form-for-4">
						<label>地址</label>
						<div style="clear:both;"></div>
						<div class="form-group">
							<select id="s_province" name="s_province" class="form-control" required></select>  
						</div>
						<div class="form-group">
						    <select id="s_city" name="s_city" class="form-control" required></select>  
						</div>
						<div class="form-group">
							<select id="s_county" name="s_county" class="form-control" required></select>
						</div>
						<div class="form-group">
							<input id="address" name="add" type="text" class="form-control" placeholder="详细地址"  required/>
						</div>
						<div style="clear:both;"></div>
					</div>
	      			

					<p class="bg-success">选择您所需要的材料</p>
					<div class="form-for-4">
						<div class="form-group">
							<label for="exampleInputEmail1">材料名称</label>
							<select name="m_name" class="form-control" required>
								<option selected="true">钢筋</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">品牌范围</label>
							<br>
							<select id="brands" name="brands[]" class="form-control more-select brand-select" multiple="multiple" >
									
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">计量方式</label>
							<select id="c_type" class="form-control" required>
								<option selected="true" disabled="disabled">请选择</option>
								<option value="过磅">过磅</option>
								<option value="理计">理计</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">材料总量(吨)</label>
							<input id="tamount" type="number" class="form-control" name="tamount" required />
						</div>
					</div>
		      	</div>
	    	</div>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingTwo">
			<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				第二步 : 具体信息
				</a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body">
				<div class="route-page-bids-2">
					{{-- <p class="bg-success">填写标书信息</p>
					<div class="form-for-3">
						<div class="form-group">
							<label for="exampleInputPassword1">标书价格</label>
							<input type="text" class="form-control" placeholder="请输入价格" required />
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">发售时间</label>
							<input type="text" class="form-control time-select" readonly="true" placeholder="" required />
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">发售地点</label>
							<input type="text" class="form-control" placeholder="请输入地点" required />
						</div>
						<div style="clear:both;"></div>
					</div> --}}

					<p class="bg-success">选择操作的时间</p>
					<div class="form-for-4">
						{{-- <div class="form-group">
							<label for="exampleInputPassword1">开放时间</label>
							<input type="text" class="form-control time-select" readonly="true" placeholder="" required>
						</div> --}}
							<div class="form-group select-time">
								<label for="exampleInputPassword1">截标时间</label>
								<input name="bid_deadline" type="text" class="form-control time-select" readonly="true" placeholder="" required>
							</div>
							<div class="form-group select-time">
								<label for="exampleInputPassword1">开标时间</label>
								<input name="bod" type="text" class="form-control time-select" readonly="true" placeholder="" required>
							</div>
							<div class="form-group select-time">
								<label for="exampleInputPassword1">供货时间</label>
								<input name="affords_time" type="text" class="form-control time-select" readonly="true" placeholder="" required>
							</div>
							<div class="form-group select-time">
								<label for="exampleInputPassword1">停止供货时间</label>
								<input name="end_time" type="text" class="form-control time-select" readonly="true" placeholder="" required>
							</div>
						<div style="clear:both;"></div>
					</div>

					<div class="form-group">
						<label for="exampleInputPassword1">投标方式</label>
						<input type="text" class="form-control" placeholder="" readonly="true" value="本平台投标" required>
					</div>

					<p class="bg-success">告诉投标方您的报价要求,以及结算要求</p>
					<div class="form-group" id="quote_request">
					<label style="display:block;max-width:100%; margin-bottom:5px;font-weight:700;padding:0px;">报价要求</label>
                          @foreach ($q_request as $r)
                            @if(qr_to_id($r) == 1)
                            	<label>
                            		<input name="q_request[]" type="checkbox" value="{{ qr_to_id($r) }}" data-name={{$r}} data-labelauty="{{ $r }}" checked="checked" disabled="true" />
                            	</label>
                            	<input name="q_request[]" type="hidden" value="{{ qr_to_id($r) }}" />
                            @else
                            	<label>
                            		<input name="q_request[]" type="checkbox" value="{{ qr_to_id($r) }}" data-name={{$r}} data-labelauty="{{ $r }}" />
                            	</label>
                            @endif
                          @endforeach
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">报价说明</label>
						<input name="pricetype" type="text" class="form-control" placeholder="" />
					</div>
					<div style="clear:both;"></div>
					
					<div class="form-for-2">
						<div class="form-group" style="width:100%;">
							<label for="exampleInputPassword1">结算条件</label>
							<textarea style="display:block;width:100%;height:150px;" name="settlement" type="text" class="form-control settlement" placeholder="" required></textarea>
						</div>
						<div style="clear:both;"></div>
						<div class="form-group pay-solution" style="margin-top: 120px;">
							<label for="exampleInputEmail1">付款方式</label>
								<select name="paytype" id="pay-type" class="form-control" required>
									<option disabled="true" selected="true">请选择</option>
									@foreach ($pay_type as $p)
										<option value="{{$p}}">{{ $p }}</option>
									@endforeach
								</select>
								<input class="form-control other-pay" name="other-pay" type="text" placeholder="填写其他付款方式" style="margin-top:10px;display:none;" />
						</div>
						<div style="clear:both;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingThree">
			<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				第三步 :  报价清单
				</a>
			</h4>
		</div>
		<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
			<div class="panel-body">
				<div class="route-page-bids-3">
					<!-- <div >
						<label for="exampleInputEmail1">是否要求缴纳保证金</label>
						<div class="form-group">
						    <label>
						    	<input type="radio" name="_radio" data-labelauty="是" onclick='$(".deposit").show(300);'/>
						    </label>
						    <label>
						    	<input type="radio" name="_radio" data-labelauty="否" onclick='$(".deposit").hide(300);'/>
						    </label>
						</div>
					</div>
					<div class="form-group deposit">
					<p class="bg-success">保证金缴纳方式 : 银行转账</p>
					</div>
						<div class="form-for-4">
							<div class="form-group deposit">
								<label for="exampleInputPassword1">保证金(元)</label>
								<input name="deposit" type="text" class="form-control" placeholder="请输入保证金">
							</div>
							<div class="form-group deposit">
								<label for="exampleInputPassword1">银行账号</label>
								<input name="deposit_account" type="text" class="form-control" placeholder="请输入银行账号">
							</div>
							<div class="form-group deposit">
								<label for="exampleInputPassword1">支行名称</label>
								<input name="deposit_bank_name" type="text" class="form-control" placeholder="请输入支行名称">
							</div>
							<div class="form-group deposit">
								<label for="exampleInputPassword1">无息退回保证金(天)</label>
								<input name="deposit_return" type="text" class="form-control" placeholder="请输入天数">
							</div>
						</div>
						<div style="clear:both;"></div> -->
					<p class="bg-success deposit-choose">请确认此次项目的报价清单</p>
					<div class="form-group labelauty-radio">
						<label style="display:block;float: none;">选择一种报价清单</label>
						<input type="radio" name="type" value="1" data-labelauty="统一价" onclick="showCostTable()">
						<input type="radio" name="type" value="2" data-labelauty="分品牌" onclick="showBrandTable()">
					</div>

					<table class="table table-bordered" id="project-table">
						<thead>
							<tr>
								<td>单价</td>
								<td>备注</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<select name="qtype">
										<option selected="" value="1">下单日我的钢铁网价格 上浮或下浮（）元/吨</option>
							            <option value="2">到货日我的钢铁网价格 上浮或下浮（）元/吨</option>
							            <option value="3">下单日广州钢材批发网价格 上浮或下浮（）元/吨</option>
							            <option value="4">到货日广州钢材批发网价格 上浮或下浮（）元/吨</option>
									</select>
								</td>
								<td>
									<input type="text" />
								</td>
							</tr>
						</tbody>
					</table>

					<table class="table table-bordered" id="project-table-2" width="100%">
						<thead>
							<tr>
								<td>
									<input onclick="$('#project-table-2 input').click();" type="checkbox" />
								</td>
								<td>品牌</td>
								<td>单价</td>
								<td>备注</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>

					<div class="form-group">
						<label for="exampleInputPassword1">备注</label>
						<input name="remark" type="text" class="form-control" placeholder="" />
					</div>

					<div class="form-group">
						<label style="display:block;">招标方式</label>
					    <label>
					    	<input type="radio" name="bid_to" value="all" data-labelauty="公开招标" onclick="$('.select-company').hide()" />
					    </label>
					    <label>
					    	<input type="radio" name="bid_to" value="some" data-labelauty="定向招标" onclick="$('.select-company').show()" />
					    </label>
					</div>
					<div class="form-group select-company">
						<label style="display:block;">选择指定的公司</label>
						<select name="companys[]" class="form-control more-select-2" multiple="multiple">
							
						@foreach ($companys as $cid=>$company)
								<option value={{$cid}}>{{ $company }}</option>
						@endforeach
						</select>
					</div>
					<button onclick="toSubmit()" type="button" id="project-route-btn" class="btn btn-success set-width-8" style="max-width:500px;display:block;margin:0px auto 10px auto;">确认信息</button>
				</div>
			</div>
		</div>
	</div>

	

	</form>
</div>

	

<script>
	setLeftBar("新建招标");
	setPageTitle("项目招标");
	setOptionFocus("项目招标");
	$('.collapse').collapse();

	jeDate({
	    dateCell:".time-select",
	    format:"YYYY-MM-DD hh:mm:ss",
	    isTime:true, 
	    minDate:"2014-09-19 00:00",
	    isToday:true
	});

	function toSubmit(){
		$('.collapse').collapse("show");
		$('form').submit();
	}


	//初始化左边导航
	setLeftBar("新建招标");

	//初始化选择城市控件
	_init_area(["s_province","s_city","s_county"]);

	//默认隐藏的DOM
	$('.select-company').hide();

	//设置表单的默认值
	var projectData = {!! json_encode($myprojects) !!};
	console.log(projectData);

	_initForm(projectData, $("#project-name").find("option:selected").text());

	$("#project-name").change(function(){
		_initForm(projectData, $(this).find("option:selected").text());
	});


	function _initForm(datas, string){
		for(key in datas){
			if(datas[key].name === string){
				//设置省份
				$("#s_province").val(datas[key].province);
				change(1);
				//设置城市
				$("#s_city").val(datas[key].city);
				change(2);
				//设置地区
				$("#s_county").val(datas[key].area);
				//set address
				$("#address").val(datas[key].add);
				//设置品牌范围
				var temp_arr = datas[key].brands.split(',');
				$('.more-select option').remove();
				var optionsArr = [];
				for(var i=0; i<temp_arr.length; i++){
					optionsArr.push({
						label : temp_arr[i],
						title : temp_arr[i],
						value : temp_arr[i],
						selected : true
					});
				}
				// for(brands of temp_arr){
				// 	optionsArr.push({
				// 		label : brands,
				// 		title : brands,
				// 		value : brands,
				// 		selected : true
				// 	});
				// }
				$('.more-select').multiselect('rebuild');
				console.log(optionsArr)
				$("#brands").multiselect('dataprovider', optionsArr);
				
				//设置计量方式
				$("#c_type").val(datas[key].c_type);
				//设置材料总量
				$("#tamount").val(datas[key].amount);
				//设置报价要求
				var temp_arr = datas[key].quote_request.split(',');
				$("#quote_request input").each(function(){
					if($(this).val() != 1){
						$(this).removeAttr("checked");
					}
				});
				$("#quote_request input").each(function(){
					for(var i=0; i<temp_arr.length; i++){
						if($(this).attr("data-name")==temp_arr[i]){
							$(this).click();
						}
					}
					// for(op of temp_arr){
					// 	if($(this).attr("data-name")==op){
					// 		$(this).click();
					// 	}
					// }
				});
				//设置结算条件
				$(".settlement").val(datas[key].settlement);
				//设置汇款方式
				$("#pay-type").val(datas[key].paytype);
				//设置报价清单分品牌table
				$("#project-table-2 tbody tr").remove();
				var brandsArr = datas[key].brands.split(',');
				for(var i=0; i<brandsArr.length; i++){
					if( i === 0){
						$("#project-table-2 tbody").append('<tr><td><input name="qbrands[]" value="'+brandsArr[i]+'" type="checkbox"/><td>'+brandsArr[i]+'</td><td valign="middle" class="center-td" rowspan="'+(parseInt(brandsArr.length))+'"><select name="qtype"><option selected="" value="1">下单日我的钢铁网价格 上浮或下浮（）元/吨</option><option value="2">到货日我的钢铁网价格 上浮或下浮（）元/吨</option><option value="3">下单日广州钢材批发网价格 上浮或下浮（）元/吨</option><option value="4">到货日广州钢材批发网价格 上浮或下浮（）元/吨</option></select></td><td><input name="qremark[]" type="text"></td></tr>');
					}else{
						$("#project-table-2 tbody").append('<tr><td><input name="qbrands[]" value="'+brandsArr[i]+'" type="checkbox"/><td>'+brandsArr[i]+'</td><td><input name="qremark[]" type="text"></td></tr>');
					}
				}
				$("#project-table-2 tbody :checkbox").labelauty().click();
				
			}
		}
	}
	
	//初始化jquery-labelauty
	$(document).ready(function(){
		$(".warpper-main :checkbox").labelauty();
		$(".warpper-main :radio").labelauty();
	});

	//表单验证
	// $("#project-route-btn").click(function(){
	// 	console.log($("#product-form").valid())
	// });

	//选择显示何种报价
	function showCostTable(){
		$("#project-table").show();
		$("#project-table-2").hide();
	}
	function showBrandTable(){
		$("#project-table-2").show();
		$("#project-table").hide();
	}

	$("form").validate({
		debug : false,
		rules : {
			bod : {
				bod : true
			},
			affords_time:{
				affords_time:true
			},
			end_time : {
				end_time:true
			}
		}
	});

	jQuery.validator.addMethod("bod", function(value, element) {
		var bid_deadline = Date.parse(new Date($("input[name='bid_deadline']").val()));
		var bod = Date.parse(new Date($("input[name='bod']").val()));
		console.log(bid_deadline , bod)
		console.log((bod-bid_deadline)/3000)
		if((bod-bid_deadline)/3000 >= 1200 ){
	    	return true;
		}else{
			return false;
		}
	}, "至少多于截标时间1小时");

	jQuery.validator.addMethod("affords_time", function(value, element) {
		var affordsTime = Date.parse(new Date($("input[name='affords_time']").val()));
		var bod = Date.parse(new Date($("input[name='bod']").val()));
		if((affordsTime-bod)/3000 >= 1200){
	    	return true;
		}else{
			return false;
		}
	}, "至少多与开标时间1小时");

	jQuery.validator.addMethod("end_time", function(value, element) {
		var affordsTime = Date.parse(new Date($("input[name='affords_time']").val()));
		var end_time = Date.parse(new Date($("input[name='end_time']").val()));
		if((end_time-affordsTime)/3000 >= 1200){
	    	return true;
		}else{
			return false;
		}
	}, "至少多与供货时间1小时");

	$("#pay-type").change(function(){
		if($(this).val() == "其他"){
			$(".pay-solution").css("height","100px");
			$(".other-pay").css("display", "block");
		}else{
			$(".pay-solution").css("height","60px");
			$(".other-pay").css("display", "none");
		}
	});


	//记录当前表单页数
	// var dataPage = 1;
	// $(".collapsed").click(function(){
	// 	if(dataPage > parseInt($(this).attr('data-page'))){
	// 		dataPage -= 1;
	// 		return true;
	// 	}else{
	// 		var elementId = $(this).attr("aria-controls");
	// 		if($("#bids-form").valid()){
	// 			//特殊控件验证
	// 			if(dataPage === 1){
	// 				if($(".multiselect").attr("title") == "请选择"){
	// 					$(".brand-select").next().children().eq(0).after('<label style="width:100px;" id="multiselect-error" class="error" for="m_name">这是必填字段</label>');
	// 					return false;
	// 				}else{
	// 					$("#multiselect-error").remove();
	// 					$(elementId).collapse();
	// 				}
	// 			}else if(dataPage === 2){
	// 				var isEmpty = true;
	// 				// var isSelected = false;

	// 				// $(".route-page-bids-2 .labelauty-unchecked").each(function(){
	// 				// 	if($(this).css("display") === "none"){
	// 				// 		isSelected = true;
	// 				// 		return false;
	// 				// 	}
	// 				// });

	// 				$("input[name='amount[]']").each(function(){
	// 					if($(this).val().length === 0){
	// 						$(this).after('<label id="amount-error" class="error" for="amount[]" style="display: block;">这是必填字段</label>');
	// 						isEmpty = false;
	// 						return false;
	// 					}
	// 				});

	// 				if(!isEmpty){
	// 					return false;
	// 				}else{
	// 					$("#amount-error").remove();
	// 					$(elementId).collapse();
	// 				}
	// 			}
	// 			dataPage = parseInt($(this).attr('data-page'));
	// 		}else{
	// 			return false;
	// 		}
	// 	}
		
	// });

</script>

@endsection