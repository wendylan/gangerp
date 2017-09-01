@extends('backpack::layout')
@section("content")
	<style>
		.my-project-page{
			width:100%;
			padding:25px;
			background:#FFF;
		}
		#edit-bids-modal .form-group{
			height:59px;
		}
		html body .my-project-page .media button.multiselect{
			width: 100%;
			text-align: left;
		}
		html body .my-project-page .media .multiselect-native-select div.btn-group{
			width:100%;
		}
		.my-project-page .media, .my-project-page .media-body{
			overflow: visible;
		}
		.my-project-page .table>tbody>tr>td, .my-project-page .table>tbody>tr>th, .my-project-page .table>tfoot>tr>td, .my-project-page .table>tfoot>tr>th, .my-project-page .table>thead>tr>td, .my-project-page .table>thead>tr>th{
			vertical-align:initial;
		}
		.project_address>.form-group{
			float:left;
			width:25%;
		}
		.brands-box .form-group{
			float:left;
			width:30%;
		}

		.box-title{
			margin: 0px 0px 12px;
			font-weight: 500;
			text-transform: uppercase;
			font-size: 16px;
		}
		._box-title{
			margin: 0px 0px 50px;
			font-weight: 500;
			text-transform: uppercase;
			font-size: 16px;
			color:#8d9ea7;
		}
		#table_id_example{
			border:solid 1px #DEDEDE;
		}
		#table_id_example thead td{
			padding:15px 8px 15px 8px;
		}
		html body .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
			    padding: 15px 8px;
		}
		html body .table > tbody > tr > td{
			    font-size:14px;
		}
		#table_id_example tbody{
			color:#797979;
		}
		.table-btn{
			color:black;
			cursor:pointer;
		}
	</style>
	<div class="my-project-page">
		<a style="float:right;" class="btn btn-primary" href="/projects/create">新建项目</a>
		<h3 class="box-title">项目列表</h3>
		<h3 class="_box-title">可查看项目信息以及修改</h3>

		<table id="table_id_example" class="table table-condensed table-striped" width="100%">
			<thead>
				<tr>
					<td>序号</td>
					<td>招标项目名称</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
				@foreach($projects as $pk=>$pv)
					<tr>
						<td>{{$pk+1}}</td>
						<td>{{$pv->name}}</td>
						<td>
							<span class="table-btn check-bids" onclick="getProjectData(this)" data-id={{ $pv->id }} >详细</span> / 
							<span class="table-btn edit-bids" onclick="getEditorData(this)" data-id={{ $pv->id }} >编辑</span>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<!--  查看详情模态框  -->
		<div id="check-bids-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		    	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">项目标题</h4>
				</div>
				<div class="modal-body project-info">
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">项目信息:</div>
						<div class="media-body">
							<p class="media-heading project-name">项目名称：<span></span></p>
							<p class="media-heading project-address">项目地址：<span></span></p>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">材料信息:</div>
						<div class="media-body">
							<p class="media-heading brands-name">材料名称：<span></span></p>
							<p class="media-heading brands-range">品牌范围：<span></span></p>
							<p class="media-heading brands-measure">计量方式：<span></span></p>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">结       算: </div>
						<div class="media-body">
							<p class="media-heading settlement">结算条件：<span></span></p>
							<p class="media-heading pay-methods">付款方式：<span></span></p>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">报价要求:</div>
						<div class="media-body">
							<p class="media-heading requirement"><span></span></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
		    </div>
		  </div>
		</div>

		<!--  编辑内容模态框  -->
		<div id="edit-bids-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		    	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">项目标题</h4>
				</div>
				<form action="/api/tenderee/project/edit-form" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="modal-body">
						<div class="media">
							<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">项目信息:</div>
							<div class="media-body">
								<div class="form-group">
									<label for="exampleInputEmail1">项目名称</label>
									<input name="project_name" type="text" class="form-control _project_name" />
								</div>
							</div>
						</div>
						<div class="media">
							<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">项目地址:</div>
							<div class="media-body">
								<div class="project_address">
									<div class="form-group">
										<label for="exampleInputEmail1">省份</label>
										<select name="province" id="s_province" name="s_province" class="form-control"></select>  
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">城市</label>
									    <select name="city" id="s_city" name="s_city" class="form-control"></select>  
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">区域</label>
										<select name="area" id="s_county" name="s_county" class="form-control"></select>
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">详细地址</label>
										<input name="address" id="_address" name="tt2" type="text" class="form-control" placeholder="">
									</div>
								</div>
							</div>
						</div>
						<div class="media">
							<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">材料信息:</div>
							<div class="media-body">
								<div class="brands-box">
									<div class="form-group">
										<label for="exampleInputEmail1">品牌范围</label>
										<select name="brands_range[]" class="form-control more-select" multiple="multiple">
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">材料名称</label>
										<select name="brands_name" class="form-control">
											<option>钢筋</option>
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">计量方式</label>
										<select name="measure-methods" class="form-control metering">
											<option>过磅</option>
											<option>理计</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="media">
							<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">报价要求:</div>
							<div class="media-body">
								<div class="checkbox">
								    <label>
								    	<input name="requirement[]" type="checkbox" value="含17%增值税发票" /> 含17%增值税发票
								    </label>
								    <label>
								    	<input name="requirement[]" type="checkbox" value="含运费" /> 含运费
								    </label>
								    <label>
								    	<input name="requirement[]" type="checkbox" value="含卸车费" /> 含卸车费
								    </label>
								    <label>
								    	<input name="requirement[]" type="checkbox" value="含过磅费" /> 含过磅费
								    </label>
								    <label>
								    	<input name="requirement[]" type="checkbox" value="含资金占用费" /> 含资金占用费
								    </label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input name="id" id="editor-id" type="text" style="display:none;">
						<button type="submit" class="btn btn-danger">修改</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
				</form>
		    </div>
		  </div>
		</div>

	</div>

	<script>
		(function(){
			setPageTitle("我的项目");
			setOptionFocus("我的项目");
			//初始化datatables
			$('#table_id_example').DataTable({
				"oLanguage" : {
				"sLengthMenu": "每页显示 _MENU_ 行",
				"sZeroRecords": "抱歉， 没有找到",
				"sInfo": "共 _TOTAL_ 行",
				"sInfoEmpty": "没有数据",
				"sInfoFiltered": "(从 _MAX_ 条数据中检索)",
				"sZeroRecords": "没有检索到数据",
				"sSearch": "搜索:",
				"oPaginate": {
					"sFirst": "首页",
					"sPrevious": "前一页",
					"sNext": "后一页",
					"sLast": "尾页"
				}},
				"language": {
					"emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
					// "info":           "{{ trans('backpack::crud.info') }}",
					"info":           "{{ false }}",
					"infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
					"infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
					"infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
					"thousands":      "{{ trans('backpack::crud.thousands') }}",
					// "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
					"lengthMenu":     "{{ false }}",
					"loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
					"processing":     "{{ trans('backpack::crud.processing') }}",
					"search":         "{{ trans('backpack::crud.search') }}",
					"zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
					"paginate": {
						"first":      "{{ trans('backpack::crud.paginate.first') }}",
						"last":       "{{ trans('backpack::crud.paginate.last') }}",
						"next":       "{{ trans('backpack::crud.paginate.next') }}",
						"previous":   "{{ trans('backpack::crud.paginate.previous') }}"
					},
					"aria": {
						"sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
						"sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
					}
				}
			});

			//初始化选择城市控件
			_init_area(["s_province","s_city","s_county"]);
		})();

		function getProjectData(element){
			var projectID = $(element).attr("data-id");
			$.get("/api/tenderee/project/"+projectID+"",function(data){
				console.log(data);
				$(".project-name span").text(data.data[0].name);
				$(".project-address span").text(data.data[0].province+","+data.data[0].city+","+data.data[0].area+","+data.data[0].add);
				$(".brands-name span").text(data.data[0].m_name);
				$(".brands-range span").text(data.data[0].brands);
				$(".brands-measure span").text(data.data[0].c_type);
				$(".settlement span").text(data.data[0].settlement);
				$(".pay-methods span").text(data.data[0].paytype);
				$(".requirement span").text(data.data[0].quote_request);
				$("#check-bids-modal").modal();
			});
		}

		function getEditorData(element){
			var editroId = $(element).attr("data-id");
			$.get("/api/tenderee/project/edit/"+editroId+"",function(data){
				console.log(data);
				$("#editor-id").val(editroId);
				$("._project_name").val(data.data[0].name);
				//设置省份
				$("#s_province").val(data.data[0].province);
				change(1);
				//设置城市
				$("#s_city").val(data.data[0].city);
				change(2);
				//设置地区
				$("#s_county").val(data.data[0].area);
				$("#_address").val(data.data[0].add);

				//设置品牌范围
				var optionsArr = [];
				var selectedData = data.data[1];
				for(_data of selectedData){
					optionsArr.push({
						label : _data.name,
						title : _data.name,
						value : _data.id,
						selected : false
					});
				}
				for(brand of data.data[2]){
					for(_data of optionsArr){
						if(brand.value == _data.value){
							_data.selected = true;
						}
					}
				}
				$('.more-select').multiselect('rebuild');
				$(".more-select").multiselect('dataprovider', optionsArr);

				$(".metering option").each(function(){
					if($(this).text() == data.data[0].c_type){
						$(this).attr("selected", "true");
					}
				});

				var requestPay = data.data[0].quote_request.split(',');
				$(".checkbox input").each(function(){
					var e = this;
					for(data of requestPay){
						if($(e).val() == data){
							$(e).click();
						}
					}
				});
				$("#edit-bids-modal").modal();
			});
		}
	</script>

@endsection