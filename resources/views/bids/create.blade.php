@extends('backpack::layout')

@section("content")
<style type="text/css">
	html body a:link{
		text-decoration:none;
	}
	html body a:visited{
		text-decoration:none;
	}
	html body a:hover{
		text-decoration:none;
	}
	html body a:active{
		text-decoration:none;
	}
	html body .warpper-main{
		width: 100%;
		max-width: 1024px;
		margin: auto;
	}
	.route-page-bids-1, .route-page-bids-2, .route-page-bids-3, .route-page-bids-4{
		width:100%;
		padding:15px;
	}
	body,h3{
		/*font-family:"微软雅黑";*/
	}
	.set-width-8{
		width:80%;
	}
	.slide-bar{
		width:400px;
		margin:auto;
	}
	.slide-bar>div{
		float:left;
		padding:10px;
		margin-right:0px;
		border-radius:5px;
		background:#FFF;
	}
	.slide-bar>p{
		float:left;
		margin: 10px 0px 0px 0px;
		padding:0px;
	}
	html body .now-bar{
		color:#FFF;
		background:#5bc0de;
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
	.form-group{
		height: 60px;
	}

	#bids-table input, #bids-table select{
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
	#bids-form .table>tbody>tr>td, #bids-form .table>tbody>tr>th, #bids-form .table>tfoot>tr>td, #bids-form .table>tfoot>tr>th, #bids-form .table>thead>tr>td, .my-project-page .table>thead>tr>th{
		vertical-align:middle;
	}
	html body .bg-success{
		padding:15px;
	}
	.deposit{
		display:none;
	}
	.hide{
		display:none;
	}
	.select-project select{
		float:left;
		width:60%;
	}
	.select-project>div div{
		float:right;
		width:38%;
	}

	.select-address select{
		float:left;
		width:150px;
		margin-right:10px;
	}
	.select-address input{
		float:left;
		width:250px;
		margin-right:10px;
	}
	.select-products{
		float:left;
		width:24%;
		min-width:150px;
		padding:0px 10px 0px 0px;
	}
	.select-products select{
		width:100%;
	}
	.select-products .btn-group{
		width:100%;
	}
	.select-products .btn-group button{
		width:100%;
	}
	.select-connect{
		float:left;
		width:30%;
		min-width:150px;
	}

	.select-bid-file{
		float:left;
		width:33%;
		min-width:150px;
		padding-right:10px;
	}
	.select-time{
		float:left;
		width:24%;
		min-width:150px;
		padding-right:10px;
	}
	.bg-success{
		margin-bottom:20px;
	}

	.pay-solution{
		float:left;
		width:30%;
		min-width:150px;
		padding-right:10px;
	}
	.form-for-4 .form-group{
		float:left;
		width:24%;
		min-width:150px;
		padding-right:10px;
	}
	.form-for-2 .form-group{
		float:left;
		width:33%;
		min-width:150px;
		padding-right:10px;
	}
	html body .checkbox label, html body .radio label{
		padding: 0px;
		cursor: pointer;
	}
	label span{
		padding:10px;
	}
	html body input.labelauty + label{
		padding:0px;
	}
	.myself-error{
		    color: #d9534f;
	}

	.multiselect-container label.checkbox{
		/*padding:0px;*/
	}
	.multiselect-container label.checkbox label{
		/*padding:0px;*/
	}
	.multiselect-container label.checkbox label{
		/*display:inline;*/
		/*padding:0px;*/
	}
	.select-company .multiselect-container label.checkbox label span{
		padding:0px;
	}
	.select-company .multiselect-container label.checkbox label{
		float:left;
		margin-left:-20px;
	}
</style>

<div class="warpper-main">
	<form id="bids-form" role="form" action="/bids" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a class="collapsed" data-page='1' data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					  <i class="glyphicon glyphicon-hand-right"></i>  &nbsp;&nbsp;一 : 基本信息
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
								<select name="project_id" class="form-control" id="project-name" required>
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
								<input name="contact_name" type="text" class="form-control" placeholder="请输入联系人姓名" required />
							</div>
							<div class="form-group" select-connect>
								<label for="exampleInputPassword1" >联系人电话</label>
								<input name="contact_phone" type="text" class="form-control" placeholder="请输入联系人电话" number="true" minlength='11' maxlength="11" required />
							</div>
							<div style="clear:both;"></div>
						</div>

						<div class="form-group select-address" >
							<label for="exampleInputEmail1">地址</label>
							<div>
								<select id="s_province" name="s_province" class="form-control" required></select>  
							    <select id="s_city" name="s_city" class="form-control" required></select>  
								<select id="s_county" name="s_county" class="form-control" required></select>
								<input id="address" name="add" type="text" class="form-control" placeholder="详细地址" required>
							</div>
						</div>

						<p class="bg-success">选择您所需要的材料</p>
						<div class="form-group select-products">
							<label for="exampleInputEmail1">材料名称</label>
							<select name="m_name" class="form-control" required>
								<option selected="true">钢筋</option>
							</select>
						</div>
						<div class="form-group select-products">
							<label for="exampleInputEmail1">品牌范围</label>
							<div>
								<select id="brands" name="brands[]" class="form-control more-select brand-select" multiple="multiple" >

								</select>
							</div>

						</div>
						<div class="form-group select-products">
							<label for="exampleInputEmail1">计量方式</label>
							<select id="c_type" name="mtype" class="form-control" required>
								<option selected="true" disabled="disabled">请选择</option>
								<option value="过磅">过磅</option>
								<option value="理计">理计</option>
							</select>
						</div>
						<div class="form-group select-products">
							<label for="exampleInputPassword1">材料总量(吨)</label>
							<input id="tamount" type="number" class="form-control" name="tamount" required />
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" data-page='2' data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					  <i class="glyphicon glyphicon-hand-right"></i>  &nbsp;&nbsp;二 : 具体信息
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
					<div class="route-page-bids-2">
						{{-- <div class="bg-success">填写标书信息</div>
						<div style="margin-top:10px;">
							<div class="form-group select-bid-file">
								<label for="exampleInputPassword1">标书价格</label>
								<input name="tender_price" type="text" class="form-control" placeholder="请输入价格" required />
							</div>
							<div class="form-group select-bid-file">
								<label for="exampleInputPassword1">发售时间</label>
								<input name="tender_open_sale" type="text" class="form-control time-select" readonly="true" placeholder="" required />
							</div>
							<div class="form-group select-bid-file">
								<label for="exampleInputPassword1">发售地点</label>
								<input name="tender_add" type="text" class="form-control" placeholder="请输入地点" required />
							</div>
							<div style="clear:both;"></div>
						</div> --}}


						<p class="bg-success">选择投标流程的时间</p>
						<div>
							{{-- <div class="form-group select-time">
								<label for="exampleInputPassword1">开放投标时间</label>
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
							{{-- <div class="form-group select-time">
								<label for="exampleInputPassword1">供货时间</label>
								<input name="delivery_time" type="text" class="form-control time-select" readonly="true" placeholder="" required>
							</div>
							<div class="form-group select-time">
								<label for="exampleInputPassword1">停止供货时间</label>
								<input name="delivery_end_time" type="text" class="form-control time-select" readonly="true" placeholder="" required>
							</div> --}}
							<div class="form-group select-time">
								<label for="exampleInputPassword1">供货周期</label>
								<input name="delivery_day" type="text" class="form-control" placeholder="" required>
							</div>
							<div style="clear:both;"></div>
						</div>


						<p class="bg-success">告诉投标方您的报价要求,以及结算要求</p>
						<div id="quote_request" class="form-group checkbox">
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

						<div>
							<div class="form-group" style="height:auto;">
								<label for="exampleInputPassword1">结算条件</label>
								<textarea style="display:block;width:100%;height:150px;" class="settlement" name="settlement" type="text" class="form-control" placeholder="" required></textarea>
								<div style="clear:both;"></div>
							</div>

							<div class="form-group pay-solution">
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

						<label for="">报价清单</label>
						<table class="table table-bordered" id="bids-table">
							<thead>
								<tr>
									<td>
										<button type="button" class="btn btn-info bids-add-btn">添加</button>
									</td>
									<td>品名</td>
									<td>规格</td>
									<td>材质</td>
									<td>重量(吨)</td>
									<td>总重量(吨)</td>
									<td>备注</td>
									<td>操作</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>
										<select name="cname[]" class="frist-select" required>

										</select>
									</td>
									<td>
										<select name="size[]" class="" required>

										</select>
									</td>
									<td>
										<select name="material[]" class="three-select" required>

										</select>
									</td>
									<td>
										<input name="amount[]" type="number" required />
									</td>
									<td id="all-count" rowspan ="1">0</td>
									<td>
										<input name="mark[]" type="text" />
									</td>
									<td>
										<button type="button" class="btn btn-danger bids-dele-btn" disabled="true">删除</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="batch_amount" class="all-count" />

		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" data-page='3' data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					<i class="glyphicon glyphicon-hand-right"></i>  &nbsp;&nbsp;三 : 招标方式
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

					<div style="clear:both;"></div>
				</div>

				<button onclick="toSubmit()" type="button" id="bids-route-btn" class="btn btn-success set-width-8" style="max-width:500px;display:block;margin:30px auto 10px auto;">确定建立招标</button>
				<br /><br />
			</div>
		</div>
	</div>
	</form>


</div>




<script>
	// setLeftBar("新建招标");
	// setPageTitle("批次招标");
	// setOptionFocus("批次招标");
	$('.collapse').collapse();

	jeDate({
	    dateCell:".time-select",
	    format:"YYYY-MM-DD hh:mm:ss",
	    isTime:true,
	    minDate:"2014-09-19 00:00",
	    isToday:true,
	    isinitVal:false
	});

	function toSubmit(){
		$('.collapse').collapse("show");

		var domListData = $("#bids-table tbody tr");
		var listData = [];
		domListData.each(function(){
			listData.push($(this).find("select").eq(0).val() + $(this).find("select").eq(1).val() + $(this).find("select").eq(2).val());
		});

		var isReplay = false;
		var _listData = $.extend(true, {}, listData);
		for(var i=0; i<listData.length; i++){
			for(var j=0; j<listData.length; j++){
				if(listData[i]==listData[j] && i!==j){
					isReplay = true;
				}
			}
		}
		if(isReplay){
			$("#bids-table").after('<label id="myself-error" class="myself-error">无法提交相同的两条报价</label>');
			$("form").valid();
		}else{
			$(".myself-error").remove();
			$('form').submit();
		}
	}

	$(document).ready(function(){
		//初始化左边导航
		setLeftBar("新建招标");

		//DOM操作初始化
		$(".select-company").hide();

		//初始化选择城市控件
		_init_area(["s_province","s_city","s_county"]);

		//初始化jquery-labelauty
		$(document).ready(function(){
			$(".warpper-main :checkbox").labelauty();
			$(".warpper-main :radio").labelauty();
		});

		//设置表单的默认值
		var projectData = {!! json_encode($myprojects) !!};
		console.log(projectData);

		_initForm(projectData, $("#project-name").val());

		$("#project-name").change(function(){
			_initForm(projectData, $(this).val());
		});

		function _initForm(datas, string){
			for(key in datas){
				if(key === string){
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
						if(temp_arr[i].length){
							optionsArr.push({
								label : temp_arr[i],
								title : temp_arr[i],
								value : temp_arr[i],
								selected : true
							});
						}
					}
					// for(brands of temp_arr){
					// 	if(brands.length){
					// 		optionsArr.push({
					// 			label : brands,
					// 			title : brands,
					// 			value : brands,
					// 			selected : true
					// 		});
					// 	}
					// };
					$('.more-select').multiselect('rebuild');
					$("#brands").multiselect('dataprovider', optionsArr);

					//设置计量方式
					$("#c_type").val(datas[key].c_type);
					//设置材料总量
					$("#tamount").val(datas[key].amount);
					//设置报价要求
					var temp_arr = datas[key].quote_request.split(',');
					console.log(datas[key]);
					$("#quote_request input").each(function(){
						console.log($(this).val())
						if($(this).val() != 1){
							$(this).removeAttr("checked");
						}
					});
					$("#quote_request input").each(function(){
						for(var i=0; i<temp_arr.length; i++){
							if($(this).attr('data-name') == temp_arr[i]){
								$(this).click();
							}
						}
					});
					//设置结算条件
					$(".settlement").val(datas[key].settlement);
					//设置汇款方式
					$("#pay-type").val(datas[key].paytype);


				}
			}
		}

		(function(){
			//报价清单联动数据
			var cats = {!! json_encode($cats) !!};
			console.log(cats);

			//初始化页面上的一级联动
			$(".frist-select").append("<option disabled='disabled' selected='selected'>请选择</option>");
			for(var i=0; i<cats[0].child.length; i++){
				$(".frist-select").append("<option value='"+cats[0].child[i].id+"'>"+cats[0].child[i].name+"</option>");
			}
			var tagetElement = $("#bids-table>tbody>tr").last();
			var selectData = search(cats[0].child, $(tagetElement).find(".frist-select:first-child").val());
			console.log(selectData)
			// //设置二级下拉
			// for(data of selectData[0].child){
			// 	$(tagetElement).find(".frist-select").parents("td").next().children().append("<option value='"+data.id+"'>"+data.name+"</option>");
			// }
			// //设置三级下拉
			// for(data of selectData[1].child){
			// 	$(tagetElement).find(".frist-select").parents("td").next().next().children().append("<option value='"+data.id+"'>"+data.name+"</option>");
			// }


			//联动一级二级选项
			$(document).on("change",".frist-select", function(){
				// console.log($(this).val())
				var selectData = search(cats[0].child, $(this).val());
				console.log(selectData)
				$(this).parents("td").next().find("option").remove();
				$(this).parents("td").next().next().find("option").remove();
				//设置二级下拉
				// for(data of selectData[0].child){
				// 	$(this).parents("td").next().children().append("<option value='"+data.id+"'>"+data.name+"</option>");
				// }
				for(var i=0; i<selectData[0].child.length; i++){
					$(this).parents("td").next().children().append("<option value='"+selectData[0].child[i].id+"'>"+selectData[0].child[i].name+"</option>");
				}
				//设置三级下拉
				// for(data of selectData[1].child){
				// 	$(this).parents("td").next().next().children().append("<option value='"+data.id+"'>"+data.name+"</option>");
				// }
				for(var i=0; i<selectData[1].child.length; i++){
					$(this).parents("td").next().next().children().append("<option value='"+selectData[1].child[i].id+"'>"+selectData[1].child[i].name+"</option>");
				}
			});

			// console.log(search(cats[0].child, "20"));

			function search(arr, serachName){
				for(var i=0; i<arr.length; i++){
					if(arr[i].id == serachName){
						return arr[i].child;
					}
					if(arr[i].child){
						var returnData = search(arr[i].child, serachName);
						if(returnData){
							return returnData;
						}
					}else{
						console.log("over")
					}
				}
			}

			//添加报价清单DOM操作
			var count_list = 2;
			$(document).on("click", ".bids-add-btn", function(){
			    var htmlModel = "<tr>" +
			              "<td>"+(count_list++)+"</td>" +
			              "<td>" +
			                '<select name="cname[]" class="frist-select">' +
			                "</select>" +
			              "</td>" +
			              "<td>" +
			                '<select name="size[]" class="">' +
			                "</select>" +
			              "</td>" +
			              "<td>" +
			                '<select name="material[]">' +
			                "</select>" +
			              "</td>" +
			              "<td>" +
			                '<input name=amount[] type="number" required>' +
			              "</td>" +
			              "<td>" +
			                '<input name=mark[] type="text">' +
			              "</td>" +
			              "<td>" +
			                '<button type="button" class="btn btn-danger bids-dele-btn">删除</button>' +
			              "</td>" +
			            "</tr>";
			    $("#bids-table>tbody").append(htmlModel);

			    //初始化页面上的一级联动
			    console.log($("#bids-table>tbody>tr").last());
			    var tagetElement = $("#bids-table>tbody>tr").last();
			    //
			    $(tagetElement).find(".frist-select").append("<option disabled='disabled' selected='selected'>请选择</option>");
			    for(var i=0; i<cats[0].child.length; i++){
			    	$(tagetElement).find(".frist-select").append("<option value='"+cats[0].child[i].id+"'>"+cats[0].child[i].name+"</option>");
			    }

			    // var selectData = search(cats[0].child, $(tagetElement).find(".frist-select:first-child").val());
			    // //设置二级下拉
			    // for(data of selectData[0].child){
			    // 	$(tagetElement).find(".frist-select").parents("td").next().children().append("<option value='"+data.id+"'>"+data.name+"</option>");
			    // }
			    // //设置三级下拉
			    // for(data of selectData[1].child){
			    // 	$(tagetElement).find(".frist-select").parents("td").next().next().children().append("<option value='"+data.id+"'>"+data.name+"</option>");
			    // }

			   //
			   var allCount = parseInt($("#all-count").attr("rowspan")) + 1;
			   $("#all-count").attr("rowspan", allCount);
			});

			$(document).on("click", ".bids-dele-btn", function(){
				$(this).parents("tr").remove();

				var allCount = parseInt($("#all-count").attr("rowspan")) - 1;
				$("#all-count").attr("rowspan", allCount);

				var allCount = 0;
				$("#bids-table input[name!='mark[]']").each(function(){
					allCount += (parseInt($(this).val()) ? parseInt($(this).val()) : 0);
				});
				$("#all-count").text(allCount);
				$(".all-count").val(allCount);
			});

			$(document).on("change", "#bids-table input[name!='mark[]']", function(){
				var allCount = 0;
				$("#bids-table input[name!='mark[]']").each(function(){
					allCount += (parseInt($(this).val()) ? parseInt($(this).val()) : 0);
				});
				$("#all-count").text(allCount);
				$(".all-count").val(allCount);
			});


			$("#bids-form").validate({
				debug : false,
				rules : {
					bod : {
						bod : true
					},
					affords_time:{
						affords_time:true
					},
					end_time:{
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

		})();

		$("#pay-type").change(function(){
			if($(this).val() == "其他"){
				$(".pay-solution").css("height","100px");
				$(".other-pay").css("display", "block");
			}else{
				$(".pay-solution").css("height","60px");
				$(".other-pay").css("display", "none");
			}
		});

	});

</script>

@endsection
