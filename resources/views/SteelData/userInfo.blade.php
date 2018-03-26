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
	<link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/bootstrap/css/bootstrap.vertical-tabs.min.css">
    

    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/bootstrap/css/bootstrap.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <!-- <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/dist/css/skins/_all-skins.min.css"> -->

    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/morris/morris.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/backpack/pnotify/pnotify.custom.min.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/public-css/jedate.css">
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/public-css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/public-css/jquery-labelauty.css" type="text/css"/>
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/adminlte/public-css/tooltip.css" type="text/css"/>
    <link href="http://www.gangerp-local.com/vendor/adminlte/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="http://www.gangerp-local.com/vendor/backpack/backpack.base.css">


    <!-- jQuery 2.2.0 -->
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/jquery-2.2.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="http://www.gangerp-local.com/vendor/adminlte/plugins/jQuery/jQuery-2.2.0.min.js"><\/script>')</script>
    <!-- Bootstrap 3.3.5 -->
    <script src="http://www.gangerp-local.com/vendor/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/plugins/pace/pace.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/plugins/fastclick/fastclick.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/dist/js/app.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/jedate.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/area.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/echarts.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/jquery-labelauty.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/jquery.validate.min.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/public-js/bootstrap-multiselect.js"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="http://www.gangerp-local.com/vendor/adminlte/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="http://www.gangerp-local.com/vendor/sms/laravel-sms.js"></script>
    <script src="http://www.gangerp-local.com/js/vue.min.js"></script>
<div class="warpper-main">
	<form action="/api/review" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="info-content">
			<div>
				<div class="form-group layer-1-2">
					<label for="exampleInputEmail1">企业名称</label>						  
					<input name="company" type="text" class="form-control" placeholder="" value="{{ $companyData->name }}" required />
				</div>
				<div style="clear:both;"></div>
			</div>
			
			<div class="form-group select-address">
				<label for="exampleInputEmail1">企业地址</label>
				<div>
					<select id="_s_province" name="province" class="form-control layer-1-4" required></select>  
				    <select id="_s_city" name="city" class="form-control layer-1-4" required></select>  
					<select id="_s_county" name="county" class="form-control layer-1-4" required></select>
					<input name="address" type="text" class="form-control layer-1-4" placeholder="详细地址" value="{{ $companyData->address }}" required/>
				</div>
			</div>

			<br/>
			<div>
				<div class="form-group component-radio">
					<label for="exampleInputEmail1">企业类型</label>	
					<div>
						<label>
							<input type="radio" name="company_type" value="1" data-labelauty="投标方" {{ $companyData->company_type==1 ? "checked='checked'" : "" }} />
						</label>
						<label>
							<input type="radio" name="company_type" value="2" data-labelauty="招标方" {{ $companyData->company_type==1 ? "" : "checked='checked'" }} />
						</label>
					</div>				  
				</div>

				<div class="form-group component-radio">
					<label for="exampleInputEmail1">企业性质</label>	
					<div>
						<label>
							<input type="radio" name="company_attr" value="1" data-labelauty="国有企业" {{ $companyData->company_attr==1? "checked='checked'" : "" }}/>
						</label>
						<label>
							<input type="radio" name="company_attr" value="2" data-labelauty="集体企业" {{ $companyData->company_attr==2? "checked='checked'" : "" }}/>
						</label>
						<label>
							<input type="radio" name="company_attr" value="3" data-labelauty="独资企业" {{ $companyData->company_attr==3? "checked='checked'" : "" }}/>
						</label>
						<label>
							<input type="radio" name="company_attr" value="4" data-labelauty="合资企业" {{ $companyData->company_attr==4? "checked='checked'" : "" }}/>
						</label>
						<label>
							<input type="radio" name="company_attr" value="5" data-labelauty="民营企业" {{ $companyData->company_attr==5? "checked='checked'" : "" }}/>
						</label>
					</div>				  
				</div>

				<div class="form-group component-radio">
					<label for="exampleInputEmail1">是否上市</label>	
					<div>
						<label>
							<input type="radio" name="is_listed" value="1" data-labelauty="是" {{ $companyData->is_listed==1 ? "checked='checked'" : "" }}/>
						</label>
						<label>
							<input type="radio" name="is_listed" value="2" data-labelauty="否" {{ $companyData->is_listed==1 ? "" : "checked='checked'" }}/>
						</label>
					</div>				  
				</div>
				<div style="clear:both;"></div>
			</div>
			

			<div class="form-group">
				<div class="layer-1-2">
					<label for="exampleInputEmail1">营业执照号码</label>						  
					<input style="width:100%;min-width:150px;" name="company_number" type="text" class="form-control" placeholder="" value="{{ $companyData->company_number }}" required/>
				</div>
				<div class="layer-1-2">
					<label for="exampleInputEmail1">注册资本(元):</label>
					<input name="register_money" type="number" class="form-control" value="{{$companyData->register_money}}" required />
				</div>
				<div class="layer-1-2">
					<label for="exampleInputEmail1">营业执照</label>
					<div class="btn-group" style="display:block;">
						<button type="button" class="btn btn-default" onclick="$('.modal').modal()">查看</button>
						<button type="button" class="btn btn-default" onclick="$('.upload').click()">修改</button>
					</div>
					<input type="file" name="company_file_path" class="btn btn-default upload" style="display:none;" required />
				</div>
			</div>
			<div style="clear:both;"></div>
			<br/>

  			<div class="company-boss">
  				<div class="form-group">
  					<label>法定代表人</label>						  
  					<input name="company_boss" type="text" class="form-control" placeholder="" value="{{ $companyData->company_boss }}" required/>
  				</div>
  				<div class="form-group">
  					<label>联系电话</label>						  
  					<input name="company_tel" type="text" class="form-control" placeholder="" value="{{ $companyData->company_tel }}" number="true" minlength='11' maxlength="11" required/>
  				</div>
  				<div class="form-group">
  					<label>身份证号码</label>						  
  					<input name="idcard_number" type="text" class="form-control" placeholder="" value="{{ $companyData->idcard_number }}" minlength='18' maxlength="18"/>
  				</div>
  				<div style="clear:both;"></div>
  			</div>
  			<div style="clear:both;"></div>
  			<br/><br/>
  			<button class="btn btn-primary" style="display:block;">提交修改信息</button>
		</div>

		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title">公司营业执照</h4>
				 </div>
					<img src="/images/{{str_replace('..\\..\\public\\images/','',$companyData->company_file_path)}}" alt="" style="display:block;width:100%;">
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
				</div>
			</div>
		</div>

	</form>
</div>
<script>
	$(document).ready(function(){

		//初始化选择城市控件
		_init_area(["_s_province","_s_city","_s_county"]);

		//初始化jquery-labelauty
		$(document).ready(function(){
			$(".warpper-main :checkbox").labelauty();
			$(".warpper-main :radio").labelauty();
		});

		//设置省份
		$("#_s_province").val("{{ $companyData->province }}");
		change(1);
		//设置城市
		$("#_s_city").val("{{ $companyData->city }}");
		change(2);
		//设置地区
		$("#_s_county").val("{{ $companyData->county }}");

		//表单验证
		$("form").valid();

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