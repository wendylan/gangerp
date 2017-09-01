@extends('backpack::layout')


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

</style>

@section("content")
	<div class="my-project-page">
		<a href="/projects/create" class="btn btn-danger">新建项目</a>
		<br/><br/>
		<table id="table_id_example" class="table table-condensed table-bordered" width="100%">
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
							<button class="btn btn-default check-bids">详细</button>
							<button class="btn btn-default edit-bids">编辑</button>
						</td>
					</tr>
				@endforeach
				{{-- <tr>
					<td>1</td>
					<td>XXX项目钢筋招标</td>
					<td>
						<button class="btn btn-default check-bids">详细</button>
						<button class="btn btn-default edit-bids">编辑</button>
					</td>
				</tr>
				<tr>
					<td>1</td>
					<td>XXX项目钢筋招标</td>
					<td>
						<button class="btn btn-default check-bids">详细</button>
						<button class="btn btn-default edit-bids">编辑</button>
					</td>
				</tr>
				<tr>
					<td>1</td>
					<td>XXX项目钢筋招标</td>
					<td>
						<button class="btn btn-default check-bids">详细</button>
						<button class="btn btn-default edit-bids">编辑</button>
					</td>
				</tr> --}}
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
				<div class="modal-body">
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">项目信息:</div>
						<div class="media-body">
							<p class="media-heading">项目名称：X X X 项目</p>
							<p class="media-heading">项目地址：广东省广州市天河区XXX路999号</p>
							<p class="media-heading">采购联系人：刘XX（13300000000）</p>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">材料信息:</div>
						<div class="media-body">
							<p class="media-heading">材料名称：钢筋</p>
							<p class="media-heading">品牌范围：广钢、韶钢、粤钢、湘钢、桂鑫</p>
							<p class="media-heading">计量方式：过磅</p>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">结       算: </div>
						<div class="media-body">
							<p class="media-heading">结算条件：货到30天付款</p>
							<p class="media-heading">付款方式：现金转账</p>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">报价要求:</div>
						<div class="media-body">
							<p class="media-heading">含17%增值税发票、含运费、含资金占用费</p>
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
				<div class="modal-body">
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">项目信息:</div>
						<div class="media-body">
							<div class="form-group">
								<label for="exampleInputEmail1">项目名称</label>
								<select class="form-control">
									<option>Temp Select 1</option>
									<option>Temp Select 2</option>
									<option>Temp Select 3</option>
									<option>Temp Select 4</option>
									<option>Temp Select 5</option>
								</select>
							</div>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">项目地址:</div>
						<div class="media-body">
							<div class="form-group">
								<label for="exampleInputEmail1">省份</label>
								<select id="s_province" name="s_province" class="form-control"></select>  
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">城市</label>
							    <select id="s_city" name="s_city" class="form-control"></select>  
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">区域</label>
								<select id="s_county" name="s_county" class="form-control"></select>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">详细地址</label>
								<input name="tt2" type="text" class="form-control" placeholder="" required>
							</div>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">材料信息:</div>
						<div class="media-body">
								<div class="form-group">
									<label for="exampleInputEmail1">品牌范围</label>
									<select class="form-control more-select" multiple="multiple">
										<option value="广钢">广钢</option>
							            <option value="韶钢">韶钢</option>
							            <option value="湘钢">湘钢</option>
							            <option value="粤钢">粤钢</option>
							            <option value="裕丰">裕丰</option>
							            <option value="桂鑫">桂鑫</option>
							            <option value="达味">达味</option>
							            <option value="圣力">圣力</option>
							            <option value="马钢">马钢</option>
							            <option value="新抚顺">新抚顺</option>
							            <option value="三闽">三闽</option>
							            <option value="德源">德源</option>
							            <option value="德润">德润</option>
									</select>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">材料名称</label>
									<select class="form-control" required>
										<option>Temp Select 1</option>
										<option>Temp Select 2</option>
										<option>Temp Select 3</option>
										<option>Temp Select 4</option>
										<option>Temp Select 5</option>
									</select>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">计量方式</label>
									<select class="form-control" required>
										<option>Temp Select 1</option>
										<option>Temp Select 2</option>
										<option>Temp Select 3</option>
										<option>Temp Select 4</option>
										<option>Temp Select 5</option>
									</select>
								</div>
						</div>
					</div>
					<div class="media">
						<div style="float:left;padding-right:20px;font-weight:700;font-size:16px;">报价要求:</div>
						<div class="media-body">
							<div class="checkbox">
							    <label>
							    	<input type="checkbox" required /> 含17%增值税发票
							    </label>
							    <label>
							    	<input type="checkbox" required /> 含运费
							    </label>
							    <label>
							    	<input type="checkbox" required /> 含卸车费
							    </label>
							    <label>
							    	<input type="checkbox" required /> 含过磅费
							    </label>
							    <label>
							    	<input type="checkbox" required /> 含资金占用费
							    </label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">修改</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
		    </div>
		  </div>
		</div>

	</div>

	<script>
		(function(){
			//初始化datatables
			$('#table_id_example').DataTable({
				"oLanguage" : {
				"sLengthMenu": "",
				"sZeroRecords": "抱歉， 没有找到",
				"sInfo": "",
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

			$(".check-bids").click(function(){
				$("#check-bids-modal").modal();
			});

			$(".edit-bids").click(function(){
				$("#edit-bids-modal").modal();
			});
		})();
	</script>

@endsection