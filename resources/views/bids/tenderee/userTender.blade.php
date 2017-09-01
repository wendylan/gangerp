@extends('backpack::layout')

@section("content")
	<style>
		.my-tender-page{
			width:100%;
			padding:25px;
			background:#FFF;
		}
		#edit-bids-modal .form-group{
			height:59px;
		}
		html body .my-tender-page .media button.multiselect{
			width: 100%;
			text-align: left;
		}
		html body .my-tender-page .media .multiselect-native-select div.btn-group{
			width:100%;
		}
		.my-tender-page .media, .my-tender-page .media-body{
			overflow: visible;
		}
		.my-tender-page .table>tbody>tr>td, .my-tender-page .table>tbody>tr>th, .my-tender-page .table>tfoot>tr>td, .my-tender-page .table>tfoot>tr>th, .my-tender-page .table>thead>tr>td, .my-tender-page .table>thead>tr>th{
			vertical-align:initial;
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
		html body #edit-bids-modal .form-group{
			height:auto;
		}
	</style>

	<div class="my-tender-page">
		<h3 class="box-title">招标列表</h3>
		<h3 class="_box-title">可查看招标项目信息以及删除</h3>
		<table id="table_id_example" class="table table-condensed table-striped" width="100%">
			<thead>
				<tr>
					<td>序号</td>
					{{-- <td>招标编号</td> --}}
					<td>招标项目名称</td>
					<td>发标时间</td>
					<td>类型</td>
					<td>状态</td>
					<td>阶段</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
			@if(!$bids->isEmpty())
			@foreach ($bids as $k=>$bid)
				<tr>
					<td>{{$k+1}}</td>
					{{-- <td>编号</td> --}}
					<td>{{get_project_name_by_id($bid->pid)}}</td>
					<td>{{$bid->created_at}}</td>
					<td>{{get_bid_opentype($bid->companys)}}{{get_bid_typename_by_id($bid->type)}}</td>

					@if(get_audit_status($bid) == '待复核' || get_audit_status($bid) == '待审核')
						<td style="color:#d43f3a;">{{ get_audit_status($bid) }}</td>
					@else
						<td>{{ get_audit_status($bid) }}</td>
					@endif

					<td>{{get_stage_name($bid->stage)}}</td>
					<td>
						<a href="my/{{$bid->id}}" class="table-btn check-bids">查看</a> / 
						<span class="table-btn edit-bids" onclick="deleteTender({{$bid->id}})">删除</span>
					</td>
				</tr>
				
			@endforeach
			@endif
			</tbody>
		</table>

		<!--  编辑内容模态框  -->
		<div id="edit-bids-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		    	<form action="../api/tenderee/delete-bid" method="post">
		    		{{ csrf_field() }}
    		    	<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    					<h4 class="modal-title" id="myModalLabel">废标</h4>
    				</div>
    				<div class="modal-body">
    					<!--<div class="form-group">
    						<label for="exampleInputPassword1">招标项目</label>
    						<input type="text" class="form-control" placeholder="" required>
    					</div>
    					<div class="form-group">
    						<label for="exampleInputPassword1">招标编号</label>
    						<input type="text" class="form-control" placeholder="" required>
    					</div>-->
    					<div class="form-group">
    						<label for="exampleInputPassword1">删除原因</label>
    						<input type="hidden" name="bid_id" />
    						<textarea name="remove_text" style="height:130px;" class="form-control" required></textarea>
    					</div>
    				</div>
    				<div class="modal-footer">
    					<button type="submit" class="btn btn-danger">确定</button>
    					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    				</div>
		    	</form>
		    </div>
		  </div>
		</div>

	</div>

	<script>
		(function(){
			setLeftBar("个人中心");
			setPageTitle("我的招标");
			setOptionFocus("我的招标");
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
					"sNext": "下一页",
					"sLast": "尾页"
				}},
				"language": {
					"emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
					// "info":           "{{ trans('backpack::crud.info') }}",
					"info":           "{{ true }}",
					"infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
					"infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
					"infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
					"thousands":      "{{ trans('backpack::crud.thousands') }}",
					// "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
					"lengthMenu":     "{{ true }}",
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
		})();

		function deleteTender(id){
			$("input[name='bid_id']").val(id);
			$("#edit-bids-modal").modal();
		}
	</script>

@endsection