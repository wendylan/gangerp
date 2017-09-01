@extends('backpack::layout')

@section("content")
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


	<div class="my-tender-page">
		<h3 class="box-title">平台上的招标项目</h3>
		<h3 class="_box-title">项目列表 : </h3>
		<table id="table_id_example" class="table table-condensed table-striped" width="100%">
			<thead>
				<tr>
					<td>序号</td>
					{{-- <td>招标编号</td> --}}
					<td>招标项目名称</td>
					<td>招标单位</td>
					<td>发布日期</td>
					<td>性质</td>
					<td>类型</td>
					<td>阶段</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
				@foreach ($bids as $k=>$bid)
					@if($bid->status!=-1)
					<tr>
						<td>{{$k+1}}</td>
						{{-- <td>编号</td> --}}
						<td>{{get_project_name_by_id($bid->pid)}}</td>
						<td>{{get_company_name_by_uid($bid->uid)}}</td>
						<td>{{$bid->created_at}}</td>
						<td>{{get_bid_opentype($bid->companys)}}</td>
						<td>{{get_bid_typename_by_id($bid->type)}}</td>
						<td>{{get_stage_name($bid->stage)}}</td>
						<td>
							<a href="allbids/{{$bid->id}}" class="check-bids">查看</a>
							{{-- <button class="btn btn-default edit-bids">废标</button> --}}
						</td>
					</tr>
					@endif
				@endforeach
			</tbody>
		</table>

	</div>

	<script>
		(function(){
			setLeftBar("投标信息");
			setPageTitle("招标公告");
			setOptionFocus("招标公告");
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

		})();
	</script>

@endsection