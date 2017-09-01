@extends('backpack::layout')
<style>
	.warpper-main{
		background-color:white;
		padding:25px;
	}

	.modal-body p{
		color:#999;
		font-size:16px;
		font-weight:700;
		margin:0px;
	}
	html body .modal-body p span{
		color:#555;
		font-size:16px;
		font-weight:0;
	}
	#title{
		font-size: 18px;
		display: inline-block;
	}
	html body div.modal ul{
		margin:0px;
	}
	html body div.modal .label-default{
		background-color:#DEDEDE;
		color:#789;
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
	#table_id_example thead th{
		padding:15px 8px 15px 8px;
		outline:none;
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

	html body .table>tbody>tr>td, html body .table>tbody>tr>th, html body .table>tfoot>tr>td, html body .table>tfoot>tr>th, html body .table>thead>tr>td, html body .table>thead>tr>th{
		    vertical-align: inherit;
	}

	html body .table>thead>tr>th{
		 border-bottom: none;
	}
</style>
@section("content")

	<div class="warpper-main">
		<h3 class="box-title">项目列表</h3>
		<h3 class="_box-title">可查看项目信息以及修改</h3>
		<table id="table_id_example" class="table table-condensed table-striped">
			<thead>
				<tr>
					<th>序号</th>
					<th>公司名</th>
					<th>联系人</th>
					<th>联系方式</th>
					<th>申请时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($companyInfoList as $data)
					<tr>
						<td>{{ $data->id }}</td>
						<td>{{ $data->name }}</td>
						<td>{{ $data->company_boss }}</td>
						<td>{{ $data->company_tel }}</td>
						<td>暂无此字段</td>
						<td>
							@if($data->is_review == 0)
								<span class="table-btn" data-id="{{ $data->id }}" onclick="getReviewData(this)" style="display:block;margin:auto;">审核</span>
							@else
								<span class="table-btn" data-id="{{ $data->id }}" onclick="getReviewData(this)" style="display:block;margin:auto;">已审核</span>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">公司审核</h4>
				</div>
				<div class="modal-body">
					<div class="ajax-result">
						<h4 id="title" class="label label-default">企业信息:</h4>
						<ul class="list-group">
							<li class="list-group-item"><p>账户名称 : <span class="data-company"></span></p></li>
							<li class="list-group-item"><p>公司类型 : <span class="data-company"></span></p></li>
							<li class="list-group-item"><p>公司名称 : <span class="data-company"></span></p></li>
							<li class="list-group-item"><p>公司地址 : <span class="data-company"></span></p></li>
							<li class="list-group-item"><p>企业性质 : <span class="data-company"></span></p></li>
							<li class="list-group-item"><p>注册资本 : <span class="data-company"><img src="/images/09236bb53156a64d2dd6f33d6373e87b.png" alt="" /></span></p></li>
							<li class="list-group-item"><p>营业执照号 : <span class="data-company"></span></p></li>
					<!-- 		<li class="list-group-item">Vestibulum at eros</li>
							<li class="list-group-item">Vestibulum at eros</li> -->
						</ul>
						
						<h4 id="title" class="label label-default">法人信息 : </h4>
						<ul class="list-group">
							<li class="list-group-item"><p>法定代表人 : <span class="data-company"></span></p></li>
						</ul>
						<h4 id="title" class="label label-default">联系人信息 : </h4>
						<div class="record-box">
							<ul class="list-group">
								<li class="list-group-item"><p>姓名 : <span class="data-content"></span></p></li>
								<li class="list-group-item"><p>联系电话 : <span class="data-content"></span></p></li>
								<li class="list-group-item"><p>邮箱 : <span class="data-content"></span></p></li>
								<li class="list-group-item"><p>职务 : <span class="data-content"></span></p></li>
							</ul>
						</div>
					</div>
				<!-- 	<div class="ajax-loading">
						<img style="display:block;margin:50px auto;" src="http://loading.io/assets/img/hourglass.svg" alt="">
					</div> -->
				</div>
				<div class="modal-footer">
					<form action="/api/pass-review" method="post" style="display:inline;">
						{{ csrf_field() }}
						<input type="text" name="infoId" style="display:none;" class="pass-input" />
						<button type="submit" class="btn btn-primary pass-btn">审核通过</button>
					</form>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready( function () {
		    $('.table').DataTable();
		} );

		// ajaxAnimate(false);

		function getReviewData(element){
			// ajaxAnimate(true);
			
			var fieldId = $(element).attr("data-id");
			$.post('/api/get-review-data', {fieldId : fieldId}, function(data){
				console.log(data);
				var company_type;
				switch(data.data[0].company_attr){
					case '1':
						company_type = "国有企业";
						break;
					case '2':
						company_type = "集体企业";
						break;
					case '3':
						company_type = "独资企业";
						break;
					case '4':
						company_type = "合资企业";
						break;
					case '5':
						company_type = "民营企业";
						break;
				}
				$(".data-company").eq(1).text(data.data[0].company_attr==1?"招标方":"投标方");
				$(".data-company").eq(2).text(data.data[0].name);
				$(".data-company").eq(3).text(data.data[0].province+","+data.data[0].city+","+data.data[0].county+","+data.data[0].address);
				$(".data-company").eq(4).text(company_type);
				$(".data-company").eq(5).find("img").attr("src","/images/"+data.data[0].company_file_path.replace("..\\..\\public\\images/",""));
				$(".data-company").eq(6).text(data.data[0].company_number);
				$(".data-company").eq(7).text(data.data[0].company_boss);
				$(".pass-input").val(data.data[0].id);
				data.data[0].is_review==1 ? $(".pass-btn").hide() : $(".pass-btn").show();

				// var html = "";
				// $(".records-box ul").remove();
				// if(data.data[1].length>0){
				// 	html += '<ul class="list-group">';
				// 	for(_data of data.data[1]){
				// 		html += '<li class="list-group-item"><p>项目名称 : <span class="data-content">'+_data.project_name+'</span></p><p>业主/施工单位 : <span class="data-content">'+_data.worked_company+'</span></p></list>'
				// 	}
				// 	html += '</ul>'
				// 	$(".records-box").append(html);
				// }else{
				// 	$(".records-box").append('<ul class="list-group"><li class="list-group-item"><p>项目名称 : <span class="data-content">无任何业绩</span></p></li></ul>');
				// }

				// var html = "";
				// $(".record-box").empty();
				// if(data.data[2]){
				// 	for(data of data.data[2]){
				// 		console.log(data);
				// 		html += '<ul class="list-group">';
				// 		html += ' <li class="list-group-item"><p>姓名 : <span class="data-content">'+data.name+'</span></p></li>';
				// 		html += ' <li class="list-group-item"><p>联系电话 : <span class="data-content">'+data.mobile+'</span></p></li>';
				// 		html += ' <li class="list-group-item"><p>邮箱 : <span class="data-content">'+data.email+'</span></p></li>';
				// 		html += ' <li class="list-group-item"><p>职务 : <span class="data-content">'+data.post+'</span></p></li>';
				// 		html += '</ul>';
				// 	}
				// 	$(".record-box").append(html);
				// }else{
				// 	$(".record-box").append('<ul class="list-group"><li class="list-group-item"><p>姓名 : <span class="data-content">无详细联系人</span></p></li></ul>');
				// }

				$(".modal").modal();
				// ajaxAnimate(false);
			})
		}

		function ajaxAnimate(isAjax){
			// if(isAjax){
			// 	$(".ajax-loading").show();
			// 	$(".ajax-result").hide();
			// }else{
			// 	$(".ajax-result").show(300);
			// 	$(".ajax-loading").hide();
			// }
		}

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
	</script>
@endsection