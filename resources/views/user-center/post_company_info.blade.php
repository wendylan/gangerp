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
		.info-content{
			padding:0px 20px 0px 20px;
			clear:both;
		}
		.layer-1-2{
			float:left;
			width:30%;
			margin:0px 15px 0px 0px;
		}
		html body .layer-1-4{
			float:left;
			width:20%;
			margin:0px 15px 0px 0px ;
		}
		.company-boss>div{
			float:left;
			width:30%;
			margin:0px 15px 0px 0px;
		}
		.component-radio{
			float:left;
			margin:0px 55px 0px 0px;
		}

		label.error{
			color:red;
			background-color:#ecf0f5;
		}
	</style>
	
	<div class="warpper-main">
		<form action="/api/review" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="info-content">
				<div>
					<div class="form-group layer-1-2">
						<label for="exampleInputEmail1">企业名称</label>						  
						<input name="company" type="text" class="form-control" placeholder="" required />
					</div>
					<div style="clear:both;"></div>
				</div>
				
				<div class="form-group select-address">
					<label for="exampleInputEmail1">企业地址</label>
					<div>
						<select id="_s_province" name="province" class="form-control layer-1-4" required></select>  
					    <select id="_s_city" name="city" class="form-control layer-1-4" required></select>  
						<select id="_s_county" name="county" class="form-control layer-1-4" required></select>
						<input name="address" type="text" class="form-control layer-1-4" placeholder="详细地址" />
					</div>
				</div>

				<br/>
				<div>
					<div class="form-group component-radio">
						<label for="exampleInputEmail1">企业类型</label>	
						<div>
							<label>
								<input type="radio" name="company_type" value="1" data-labelauty="投标方" checked="true" />
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
								<input type="radio" name="company_attr" value="1" data-labelauty="国有企业" checked="true"/>
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
								<input type="radio" name="is_listed" value="1" data-labelauty="是" checked="true"/>
							</label>
							<label>
								<input type="radio" name="is_listed" value="2" data-labelauty="否" />
							</label>
						</div>				  
					</div>
					<div style="clear:both;"></div>
				</div>
				

				<div class="form-group">
					<div class="layer-1-2">
						<label for="exampleInputEmail1">营业执照号码</label>						  
						<input style="width:100%;min-width:150px;" name="company_number" type="text" class="form-control" placeholder="" required/>
					</div>
					<div class="layer-1-2">
						<label for="exampleInputEmail1">注册资本(元):</label>
						<input name="register_money" type="number" class="form-control" required />
					</div>
					<div class="layer-1-2">
						<label for="exampleInputEmail1">营业执照</label>	
						<input type="file" name="company_file_path" class="btn btn-default" required/>
					</div>
				</div>
				<br/><br/><br/><br/>

	  			<div class="company-boss">
	  				<div class="form-group">
	  					<label>法定代表人</label>						  
	  					<input name="company_boss" type="text" class="form-control" placeholder="" required/>
	  				</div>
	  				<div class="form-group">
	  					<label>联系电话</label>						  
	  					<input name="company_tel" type="text" class="form-control" placeholder="" number="true" minlength='11' maxlength="11" required/>
	  				</div>
	  				<div class="form-group">
	  					<label>身份证号码</label>						  
	  					<input name="idcard_number" type="text" class="form-control" placeholder="" minlength='18' maxlength="18" required/>
	  				</div>
	  				<div style="clear:both;"></div>
	  			</div>
	  			<div style="clear:both;"></div>
	  			<br/><br/>
	  			<button class="btn btn-primary" style="display:block;">提交信息</button>
			</div>
		</form>
	</div>

	<script>
		$(document).ready(function(){
			setLeftBar("个人中心");
			setPageTitle("企业信息");
			setOptionFocus("企业信息");

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
		});

		$("form").validate({
			debug : false,
			rules : {
				// name : {
					select : {
						min : 1
					}
				// 	required : true,
				// 	pattern : /^[^-~]{0,20}$/
				// },
				// q_request : {
				// 	required : true
				// }
			},
			messages : {
				select : {
					min : "这是必填字段"
				}
			},
			// errorElement : "span",
			// errorElement : "em"
		});
	</script>

@endsection