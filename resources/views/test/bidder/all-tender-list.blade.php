@extends('backpack::layout')


<style>
	.my-tender-page{
		width:100%;
		padding:15px;
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

</style>

@section("content")
	<div class="my-tender-page">
		<br/><br/>
		<table id="table_id_example" class="table table-condensed table-bordered" width="100%">
			<thead>
				<tr>
					<td>序号</td>
					<td>招标编号</td>
					<td>招标项目名称</td>
					<td>招标单位</td>
					<td>发布日期</td>
					<td>性质</td>
					<td>阶段</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>NSR40556</td>
					<td>XXX项目钢筋招标</td>
					<td>ABC有限公司</td>
					<td>2033-11-19</td>
					<td>公开</td>
					<td>报名阶段</td>
					<td>
						<button class="btn btn-default check-bids">查看</button>
					</td>
				</tr>
			</tbody>
		</table>

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