@extends('backpack::layout')

@section("content")
		<style>
		html body .warpper-main{
			width: 100%;
			margin: auto;
			padding:25px;
		}
		.slider-bar{
		}
		.slider-bar>.big-icon{
			display:inline-block;
		}
		.slider-bar>div{
			float:left;
		}
		.slider-bar p{
			font-size:18px;
			color:#EEE;
			font-weight:600;
		}
		.set-center-middle{
			margin-top:22px;
		}
		.step-1{

		}
		.icon-box{
			width:80px;
			height:80px;
			margin:5px auto;
			line-height:80px;
			background:#FFF;
			text-align:center;
			border-radius:100px;
			font-weight:700;
			font-size:30px; 
			color:#000;
		}
		.icon-box p{
			margin-top:8px;
		}
		.active-bar{
			color:#FFF;
			background: #5cb85c;
		}
		.active-bar p{
			color:#FFF;
		}
		.title-animate{
			animation:change-title 2s  infinite linear;
			-moz-animation:change-title 2s  infinite linear; /* Firefox */
			-webkit-animation:change-title 2s  infinite linear; /* Safari and Chrome */
			-o-animation:change-title 2s  infinite linear; /* Opera */
		}
		@-webkit-keyframes change-title{
			0%  {margin-right:-25px; ;}
			6%  {margin-right:0px; ;}
			12% {margin-right:-25px; ;}
			18% {margin-right:0px; ;}
			100%{margin-right:0px; ;}
		}
		.no-one{
			display:none;
			width:100%;
			float:left;
			margin-bottom:-100px;
			text-align: center;
		}
		.box-content{
			width:100%;
			min-height:300px;
			float:left;
			padding: 80px 25px 25px 25px;
			background-color:#FFF;
		}
		.box-content .title{
			color:#54667a;
			font-size:18px;
			text-align:center;
		}
		.box-content thead{
			font-weight:700;
		}
		html body .table>tbody>tr>td, html body .table>tbody>tr>th, html body .table>tfoot>tr>td, html body .table>tfoot>tr>th, html body .table>thead>tr>td, html body .table>thead>tr>th{
			vertical-align:middle;
		}
		html body .warpper-main table{
			    margin-bottom: 0px;
		}
		.company-list{
			width:300px;
			margin:auto;
			font-size:20px;
		}
		textarea{
			width:100%;
		}


		.page-warpper{
			padding-right:380px;
			margin-top: -20px;
		}
		.content-info{
			float:left;
			width:100%;
			padding:20px;
			background-color:#FFF;
			border-radius:5px;
		}
		.project-info{
			float:right;
			width:350px;
			height:auto;
			margin-right:-380px;
			border-radius:5px;
		}
		.info-content{
			padding:20px;
			background-color: #FFF;
			border-radius:5px;
		}
		.bid-edit-text{
			width:100%;
			height:200px;
			margin-top:20px;
			background-color:#FFF;
			border-radius:5px;
		}
		html body pre{
			font-family:"微软雅黑";
			display:block;
			width:100%;
			padding:0px 25px;
			overflow:auto;
			border:none;
			background-color:#FFF;
			white-space: pre-wrap;       
			white-space: -moz-pre-wrap;  
			white-space: -pre-wrap;      
			white-space: -o-pre-wrap;    
			word-wrap: break-word;
		}

		.prompt{
			color:#54667a;
		}
		.prompt-title{
			font-weight:100;
			text-align:center;
			font-size:30px;
			color:#00c292;
		}
		.my-question{
			color:black;
			font-size:16px;
		}
		.prompt-box{
			cursor:pointer;
		}
		html body .bids-icon{
			display:block;
			float:right;
			margin:auto 10px;
			font-size:20px;
			line-height:4.3;
		}
		.modal-body{
			width:100%;
		}
		.controller-box{
			float:left;
			width:50%;
			margin-bottom:15px;
		}

		.table-blue{
			border:solid 1px #DEDEDE;
		}
		.table-blue thead td{
			padding:15px 8px 15px 8px;
		}
		html body .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
			    padding: 15px 8px;
		}
		html body .table > tbody > tr > td{
			    font-size:14px;
		}
		.table-blue tbody{
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
		<div class="warpper-main">
			<div class="page-warpper">
				<div class="box-content">
					@if(!empty($bid->whowin))
					<h3 style="color:#54667a;text-align: center;">本次投标中标单位为: </h3>
					<h3 class="title" style="color:#fb9678;font-weight:700;font-size:18px;">{{get_company_name_by_uid($bid->whowin)}}</h3>
					@role('bidder')
					<p style="text-align:center;color:#54667a;margin-top:50px;">您的报价 : </p>
					@if ($bid->type == 0)
						<table class="table table-condensed table-striped table-blue" width="100%">
							<thead>
								<tr>
									<td>序号</td>
									<td>品名</td>
									<td>规格</td>
									<td>材质</td>
									<td>品牌</td>
									<td>重量(吨)</td>
									<td>首轮报价</td>
									<td>招标方理想价</td>
									<td>二次报价</td>
								</tr>
							</thead>
							<tbody>
								@foreach($my_fqb as $k=>$data)
									<tr>
										<td>{{ $k+1 }}</td>
										<td>{{ get_cname_by_id($data->cname_cid) }}</td>
										<td>{{get_size_by_id($data->size_cid)}}</td>
										<td>{{get_material_by_id($data->material_cid)}}</td>
										<td>{{get_brand_name_by_id($data->brand_id)}}</td>
										<td>{{$data->amount}}</td>
										<td>{{$data->price}}</td>
										<td>{{$bid->want_price[$k]}}</td>
										<td>{{$data->second_price}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@elseif ($bid->type == 1)
						<div class="table-box">
							<table class="table table-condensed table-striped table-blue">
								<tr>
									<th>首轮报价</th>
									<th>招标方理想价格</th>
									<th>二次报价</th>
									<th>备注</th>
								</tr>
								@foreach ($prices as $k=>$item)
								<tr>
								
									<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{$item->price}}元/吨</td>								
									<td>{{get_updown_name($bid->up_down)}}{{$bid->want_price}}元/吨</td>
									<td>{{get_updown_name($item->sup_down)}}{{$item->second_price}}元/吨</td>
									<td>{{$bid->remark}}</td>
								</tr>
								@endforeach
							</table>
						</div>
					@else
						<div class="table-box">
							<table class="table table-condensed table-striped table-blue">
								<tr>
									<th>品牌</th>
									<th>首轮报价</th>
									<th>招标方理想价格</th>
									<th>二次报价</th>
								</tr>
								<?php $count = 0; ?>
								@foreach ($prices as $k=>$item)
								<tr>
									<td>{{get_brand_name_by_id($item->brand_id)}}</td>

									<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{abs($item->price)}}元/吨</td>
									<td>{{get_updown_name($bid->up_down)}}{{ $bid->want_price[$count] }}元/吨</td>
									<?php $count++; ?>
									{{-- <td>
										<select name="sup_down[]">
											<option value="1">上浮</option>
											<option value="0">下浮</option>
										</select>
										<input name="second_price[]" type="text" /><span>元/吨</span>
									</td>
									<input name="brand_id[]" type="hidden" value="{{$item->brand_id}}"> --}}
									<td>{{get_updown_name($item->sup_down)}}{{abs($item->second_price)}}元/吨</td>
								</tr>
								@endforeach
							</table>
						</div>
					@endif
					@endrole	
					@else
					<h3 class="title">暂未开标</h3>
					@endif
					
				</div>
				
					{{-- <div class="bg-success">
						<h3 class="title">本次招标到此结束</h3>
						<button class="btn btn-default" style="display:block;margin:auto;">招标汇总</button>
					</div> --}}
					<div class="project-info">
						<div class="info-content">
							<div class="prompt-box">
								<p class="prompt">目前的投标状态 : </p>
								
								@if(!empty($firstq_cids))
									<p class="prompt-title">投标进行中</p>
								@else
									<p class="prompt-title">投标结束</p>
								@endif
							</div>
							<br>
							<p class="prompt">{{get_project_name_by_id($bid->pid)}}项目操作项 : </p>
							<div class="controller-box">
								<a href="/allbids/{{$bid->id}}/tfile" target="_blank" class="btn btn-default" >查看招标文件</a>
								<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看招标方发布的招标文件"></i>
							</div>
							<div class="controller-box">
								<a href="/bidder/allbids/{{$bid->id}}/view_bidfile" class="btn btn-default">查看投标文件</a>
								<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看投标详情"></i>
							</div>
							@role('tenderee')
							<div class="controller-box">
								<a href="/tenderee/my/{{$bid->id}}/open/compare" target="_blank" class="btn btn-default" >比价详情</a>
								<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="比价详情"></i>
							</div>
							@endrole
							<div style="clear:both;" ></div>
						</div>
						@include('bids.announce')
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>


	<!-- Modal -->
	<div class="modal fade" id="check-file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">招标文件</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">下载文件</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade bs-example-modal-lg" id="create-bid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">投标</h4>
				</div>
				<div class="modal-body">
					<h4>招标编号：CLZB20160601</h4>
					<h4>项目名称：XX项目材料招标</h4>
					<button class="btn btn-default">电子标书生成</button><button class="btn btn-default">标书上传</button>
					<table class="table table table-bordered">
						<thead>
							<tr class="thead">
								<td>序号</td>
								<td>品名</td>
								<td>规格</td>
								<td>材质</td>
								<td>品牌</td>
								<td>重量(t)</td>
								<td>单价(元/吨)</td>
								<td>备注</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>盘螺</td>
								<td>Φ6</td>
								<td>HRB400E(抗震)</td>
								<td>select</td>
								<td>100</td>
								<td><input type="number"></td>
								<td>无</td>
							</tr>
							<tr>
								<td>2</td>
								<td>高线</td>
								<td>Φ8</td>
								<td>HRB300</td>
								<td>select</td>
								<td>300</td>
								<td><input type="number"></td>
								<td>无</td>
							</tr>
							<tr>
								<td>3</td>
								<td>螺纹钢</td>
								<td>Φ26</td>
								<td>HRB400(非抗震)</td>
								<td>select</td>
								<td>400</td>
								<td><input type="number"></td>
								<td>无</td>
							</tr>
							<tr>
								<td>4</td>
								<td>螺纹钢</td>
								<td>Φ20</td>
								<td>HRB400E(抗震)</td>
								<td>select</td>
								<td>500</td>
								<td><input type="number"></td>
								<td>无</td>
							</tr>
						</tbody>
					</table>

					<table class="table table table-bordered">
						<thead>
							<tr class="thead">
								<td>综合单价</td>
								<td>备注</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<span style="width:30%;float:left;">下单如我的钢铁网价格</span>
									<select style="width:30%;float:left;" name="" class="form-control">
										<option value="上浮">上浮</option>
										<option value="下浮">下浮</option>
									</select>
									<input style="width:30%;float:left;" type="text" />
								</td>
								<td>none</td>
							</tr>
						</tbody>
					</table>

					<table class="table table table-bordered">
						<thead>
							<tr class="thead">
								<td>序号</td>
								<td>品牌</td>
								<td>单价</td>
								<td>备注</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>广钢</td>
								<td>
									<span style="width:30%;float:left;">下单如我的钢铁网价格</span>
									<select style="width:30%;float:left;" name="" class="form-control">
										<option value="上浮">上浮</option>
										<option value="下浮">下浮</option>
									</select>
									<input style="width:30%;float:left;" type="text" />
								</td>
								<td>none</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger">发布投标</button>
					<button type="button" class="btn btn-primary">保存投标</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>


	<script>
		setPageTitle("投标结束");
	</script>
@endsection