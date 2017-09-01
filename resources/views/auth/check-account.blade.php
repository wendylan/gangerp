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
	.select-info{
		width:30%;
		min-width:150px;
		float:left;
		padding-right:10px;
	}

	.select-address select{
		float:left;
		width:20%;
		min-width:150px;
		margin-right:10px;
	}
	.select-address input{
		float:left;
		width:25%;
		min-width:150px;
		margin-right:10px;
	}

	.company-boss .form-group{
		float:left;
		width:33%;
		min-width:150px;
		padding-right:10px;
	}
</style>

@section("content")

<div class="warpper-main project-page">
	<h3 style="text-align:center;">审核信息</h3>
	<form id="project-form" role="form" action="/api/review" method="post" enctype="multipart/form-data">
		 {{ csrf_field() }}
	  	<div class="route-page-bids-1">
	  		<p class="bg-success">填写企业信息</p>
				<div>
					<div class="form-group select-info">
						<label for="exampleInputEmail1">账户名称</label>						  
						<input name="account" type="text" class="form-control" placeholder=""  />
					</div>
					<div class="form-group select-info">
						<label for="exampleInputEmail1">企业名称</label>						  
						<input name="company" type="text" class="form-control" placeholder=""  />
					</div>
					<div style="clear:both;"></div>
				</div>
	
				<div class="form-group select-address">
					<label for="exampleInputEmail1">企业地址</label>
					<div>
						<select id="_s_province" name="province" class="form-control"></select>  
					    <select id="_s_city" name="city" class="form-control"></select>  
						<select id="_s_county" name="county" class="form-control"></select>
						<input name="address" type="text" class="form-control" placeholder="详细地址" >
					</div>
				</div>

				<div class="form-group component-radio">
					<label for="exampleInputEmail1">企业类型</label>	
					<div>
						<label>
							<input type="radio" name="company_type" value="1" data-labelauty="投标方" />
						</label>
						<label>
							<input type="radio" name="company_type" value="2" data-labelauty="招标方" />
						</label>
					</div>				  
				</div>

				<div class="form-group component-radio">
					<label for="exampleInputEmail1">企业性质</label>	
					<div>
						<label>
							<input type="radio" name="company_attr" value="1" data-labelauty="国有企业" />
						</label>
						<label>
							<input type="radio" name="company_attr" value="2" data-labelauty="集体企业" />
						</label>
						<label>
							<input type="radio" name="company_attr" value="3" data-labelauty="独资企业" />
						</label>
						<label>
							<input type="radio" name="company_attr" value="4" data-labelauty="合资企业" />
						</label>
						<label>
							<input type="radio" name="company_attr" value="5" data-labelauty="民营企业" />
						</label>
					</div>				  
				</div>

				<div class="form-group component-radio">
					<label for="exampleInputEmail1">是否上市</label>	
					<div>
						<label>
							<input type="radio" name="is_listed" value="1" data-labelauty="是" />
						</label>
						<label>
							<input type="radio" name="is_listed" value="2" data-labelauty="否" />
						</label>
					</div>				  
				</div>

				<div class="form-group">
					<label for="exampleInputEmail1">营业执照号码</label>						  
					<input style="width:60%;min-width:150px;" name="company_number" type="text" class="form-control" placeholder=""  />
					<label for="exampleInputEmail1">营业执照号码</label>	
					<input type="file" name="company_file_path" class="btn btn-default">
				</div>
				<br/><br/><br/><br/>

	  			<p class="bg-success">填写法人信息</p>
	  			<div class="company-boss">
	  				<div class="form-group">
	  					<label>法定代表人</label>						  
	  					<input name="company_boss" type="text" class="form-control" placeholder=""  />
	  				</div>
	  				<div class="form-group">
	  					<label>联系电话</label>						  
	  					<input name="company_tel" type="text" class="form-control" placeholder=""  />
	  				</div>
	  				<div class="form-group">
	  					<label>身份证号码</label>						  
	  					<input name="idcard_number" type="text" class="form-control" placeholder=""  />
	  				</div>
	  				<div style="clear:both;"></div>
	  			</div>

	  			<p class="bg-success">子账号操作 <button class="btn btn-default btn-sm" type="button" onclick="addAccount()">新增一项</button></p>
	  			<div class="company-boss" id="use-account">
	  				<div class="add-account">
	  					<div class="form-group">
	  						<label>姓名</label>						  
	  						<input name="child_name[]" type="text" class="form-control" placeholder=""  />
	  					</div>
	  					<div class="form-group">
	  						<label>联系电话</label>						  
	  						<input name="tel[]" type="text" class="form-control" placeholder=""  />
	  					</div>
	  					<div class="form-group">
	  						<label>邮箱</label>						  
	  						<input name="email[]" type="text" class="form-control" placeholder=""  />
	  					</div>
	  					<div class="form-group">
	  						<label>密码</label>						  
	  						<input name="password[]" type="password" class="form-control" placeholder=""  />
	  					</div>
	  					<div class="form-group component-radio">
	  						<label for="exampleInputEmail1">职务</label>	
	  						<div>
	  							<select name="post[]" id="" class="form-control">
	  								<option value="3">采购经理</option>
	  								<option value="2">采购员</option>
	  								<option value="1">收货员</option>
	  							</select>
	  						</div>				  
	  					</div>
	  					<div style="clear:both;"></div>
	  				</div>
	  				
	  			</div>

	  			<p class="bg-success">近三年业绩 <button class="btn btn-default btn-sm" type="button" onclick="addRecord()">新增一项</button></p>
	  			<div class="company-boss" id="all-record">
	  				<div class="use-record">
	  					<div class="form-group">
	  						<label>项目名称</label>						  
	  						<input name="project_name[]" type="text" class="form-control" placeholder=""  />
	  					</div>
	  					<div class="form-group">
	  						<label>业主单位</label>						  
	  						<input name="main_company[]" type="text" class="form-control" placeholder=""  />
	  					</div>
	  					<div class="form-group">
	  						<label>施工单位</label>						  
	  						<input name="worked_company[]" type="text" class="form-control" placeholder=""  />
	  					</div>
	  				</div>
	  				<div style="clear:both;"></div>
	  			</div>

	  			
	  	</div>


		
		<button type="submit" id="project-route-btn" class="btn btn-success set-width-8" style="max-width:500px;display:block;margin:0px auto 10px auto;">提交信息</button>
		<button type="button" id="project-route-return-btn" class="btn btn-default set-width-8" style="max-width:500px;display:block;margin:auto;">返回上层</button>

	</form>
</div>

	

<script>
	//初始化选择城市控件
	_init_area(["_s_province","_s_city","_s_county"]);

	//初始化jquery-labelauty
	$(document).ready(function(){
		$(".warpper-main :checkbox").labelauty();
		$(".warpper-main :radio").labelauty();
	});

	//表单验证
	// $("#project-route-btn").click(function(){
	// 	console.log($("#product-form").valid())
	// });

	//
	var newAccount = $(".add-account").clone();
	function addAccount(){
		$(newAccount).clone().appendTo("#use-account");
	}

	//
	var newRecord = $('.use-record').clone();
	function addRecord(){
		$(newRecord).clone().appendTo('#all-record');
	}
	
</script>

@endsection