@extends('backpack::layout')
@section("content")
	<style>
		html body .warpper-main{
			width: 100%;
			padding:25px;
			margin: auto;
		}

		.box-content{
			padding:25px;
		}
		.no-one{
			display:none;
			width:100%;
			float:left;
			margin-bottom:-100px;
			text-align: center;
		}
		.box-content .title{
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
		.tender-company{
			/*width:100%;
			max-width:500px;
			margin:20px auto;
			padding:10px;
			background:#FFF !important;
			color:#000;
			font-size:18px;
			border-left:solid 10px #5cb85c;
			border-radius:5px;
			text-align:center;
			cursor:pointer;*/
			width:100%;
			max-width:500px;
			margin:20px auto;
			padding-right:110px;
		}
		.tender-company>button{
			float:right;
			margin-right:-110px;
			font-size:16px;
		}
		.tender-company>span{
			display: inline-block;
			width:100%;
			padding:10px;
			background:#FFF !important;
			color:#000;
			font-size:18px;
			border-left:solid 10px #5cb85c;
			border-radius:5px;
			text-align:center;
			cursor:pointer;
		}

		.tender-company:hover{
			font-weight:900;
		}
		.second-tender-company{
			width:100%;
			max-width:500px;
			margin:20px auto;
			padding-right:110px;

		}
		.second-tender-company>button{
			float:right;
			margin-right:-110px;
			font-size:16px;
		}
		.second-tender-company>span{
			display: inline-block;
			width:100%;
			padding:10px 0px 10px 10px;
			background:#5cb85c !important;
			color:#FFF;
			font-size:18px;
			border-left:solid 10px #5cb85c;
			border-radius:5px;
			text-align:center;
			cursor:pointer;
		}
		.second-tender-company:hover{
			font-weight:900;
		}
		table tr{
			background:#FFF;
			border-radius:10px;
		}
		.thead{
			background:lightgray;
			color:#797979;
		}
		html body .modal-dialog{
			width:994px;
		}

		._thead{
			color:#000;
			background: rgb(206,228,220);
		}
		.labelauty-radio{
			width:150px;
			margin:0px auto 0px auto;
		}
		.labelauty-radio label{
			float:left;
			margin:5px;
		}
		.content-info{
			float:left;
			width:100%;
			padding:20px;
			background-color:#FFF;
			border-radius:5px;
		}
		.project-info{
			width:100%;
			height:auto;
			padding:25px;
			border-radius:5px;
			background-color:#FFF;
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
			margin-bottom:10px;
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
		html body .blue-table{
			border:solid 1px #DEDEDE;
		}
		html body .blue-table thead td{
			padding:15px 8px 15px 8px;
		}
		html body .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
			    padding: 15px 8px;
		}
		html body .table > tbody > tr > td{
			    font-size:14px;
		}
		html body .blue-table tbody{
			color:#797979;
		}
		.table-btn{
			color:black;
			cursor:pointer;
		}
		.blue-table>tbody>tr.hover-tr:hover{
			cursor:pointer;
			background-color: #f7fafc;
		}
		html body div.warpper-main div.temp-test-none div.page-warpper .set-background{
			background-color:#f5f5f5;
		}
		.line-btn{
			background-color:#FFF;
			border:none;
		}
		.line-btn:hover{
			/*background-color:#333;*/
		}
		form{
			margin:0px;
			padding:0px;
		}
		.thead th{
			text-align:center;
		}
		html body div.warpper-main table input{
			width:auto;
		}
	</style>
	<div class="warpper-main">
	@include('components.tips-silider')
@if(!empty($company_prices))
		<div class="temp-test-none">
			<div class="page-warpper">
				<div class="box-content">
					<div class="content-info">
						<div class="frist-bid">
							<h3 class="box-title">首轮各单位报价</h3>
							<h3 class="_box-title">报价详细:</h3>
							<table class="table table-condensed blue-table">
								<thead>
									<tr style="vertical-align:middle; text-align:center;">
										<td>公司名称</td>
										<td>公司详情</td>
										<td>投标书</td>
										<td>操作</td>
									</tr>
								</thead>
								<tbody style="vertical-align:middle; text-align:center;">
									@foreach ($company_prices as $company_id=>$cprice)

									<tr class="hover-tr" onclick="$(this).next().css('display') == 'none' ? $(this).next().show() : $(this).next().hide();">
										<td>{{get_company_name_by_uid($company_id)}} <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="点击本行可以展开详细信息"> </i></td>
										<td><a class="line-btn" onclick="$('.company-modal-{{$company_id}}').modal();event.stopPropagation();">详情</a></td>
										<td><a href="/tenderee/view_bidfile/{{$company_id}}/{{$bid->id}}" target="_blank" class="line-btn">查看</a></td>

										<td style="color:#d43f3a;">
										{!! Form::open(['action' => ['BidsController@tenderee_my_bid_whowin', $bid->id] , 'id'=>'form-'.$company_id]) !!}
										@if($isTimeOut==true)
										<button type="button" class="line-btn" onclick="confirm('确定宣布该公司({{get_company_name_by_uid($company_id)}})中标?') ? $('#form-{{$company_id}}').submit() : false;">宣布中标</button>
										@else
										<button type="button" class="line-btn" onclick="alert('现在还未到开标时间');event.stopPropagation();window.location.reload(); ">宣布中标</button>
										@endif
										<input name="whowin" type="hidden" value={{$company_id}}>

										{!! Form::close() !!}
										</td>

									</tr>

									<tr style="display:none;" class="set-background">
										<td colspan="4">
											<div class="company-info">
												<div id="sub{{$company_id}}">
												    <div class="column">
														<div class="">
															<!-- 批次议价 -->
															@if ($bid->type == 0)
															<table class="table table-bordered">
																<thead>
																	<tr class="thead">
																		<th>序号</th>
																		<th>品名</th>
																		<th>规格</th>
																		<th>材质</th>
																		<th>品牌</th>
																		<th>重量(吨)</th>
																		<td>现金采购价</td>
																		@if(in_array(4,$bid->quote_request))
																		<td>服务费(元/吨)</td>
																		@endif
																		@if(in_array(2,$bid->quote_request))
																		<td>运费(元/吨)</td>
																		@endif
																		@if(in_array(3,$bid->quote_request))
																		<td>吊机费(元/吨)</td>
																		@endif
																		<th>综合单价</th>
																		<th>规格总价</th>
																	</tr>
																</thead>
																<tbody>
																<?php $ttp=0;?>
																@foreach ($cprice as $k=>$v)
																	<?php $ttp+=($v->price+$v->s_price+$v->d_price+$v->m_price)*$v->amount;?>
																	<tr>
																	<td>{{$k+1}}</td>
																	<td>{{get_cname_by_id($v->cname_cid)}}</td>
																	<td>{{get_size_by_id($v->size_cid)}}</td>
																	<td>{{get_material_by_id($v->material_cid)}}</td>
																	<td>{{get_brand_name_by_id($v->brand_id)}}</td>
																	<td>{{$v->amount}}</td>
																	<td>{{$v->price}}</td>
																	@if(in_array(4,$bid->quote_request))
																	<td>{{$v->s_price}}</td>
																	@endif
																	@if(in_array(2,$bid->quote_request))
																	<td>{{$v->d_price}}</td>
																	@endif
																	@if(in_array(3,$bid->quote_request))
																	<td>{{$v->m_price}}</td>
																	@endif
																	<td>{{$v->price+$v->s_price+$v->d_price+$v->m_price}}</td>
																	<td>{{number_format(($v->price+$v->s_price+$v->d_price+$v->m_price)*$v->amount)}}</td>
																	{{-- <td>{{$v->mark}}</td>												 --}}
																	{{-- <td><input name="want_price" type="text" /></td> --}}
																	</tr>
																@endforeach
																	<tr>
																		<td colspan='{{6+count($bid->quote_request)}}'>总价</td>
																		{{-- <td colspan='1'></td> --}}
																		<td colspan='1'>{{number_format($ttp)}}</td>
																	</tr>
																	<tr>
																		<td colspan='1'>备注</td>
																		<td colspan='11'>{{$v->mark}}</td>
																	</tr>

																</tbody>
															</table>

															<!-- 统一议价 -->
															@elseif ($bid->type == 1)
															<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
																<tr class="thead">
																	<td>综合单价(元/吨)</td>
																	<td>备注</td>
																	{{-- <th>二次议价</th> --}}
																</tr>
																<tr>
																@foreach ($cprice as $k=>$v)
																	<td>{{get_qtype_name($v->qtype)}}{{get_updown_name($v->up_down)}}{{$v->price}}元/吨</td>
																@endforeach
																	<td>缺少后台数据</td>
																	{{-- <td>下单日我的钢铁网价格上浮10 元/吨</td> --}}
																	{{-- <td>88</td> --}}
																</tr>
															</table>
															@else
															<!-- 分品牌议价 -->
															<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
																<tr class="thead">
																	<th rowspan="1">品牌</th>
																	<th colspan='1'>首轮报价综合单价(元/吨)</th>
																	<th rowspan="1">备注</th>
																</tr>
																<tr class="thead">
																</tr>
																@foreach ($cprice as $k=>$v)
																	<tr>
																		<td>{{get_brand_name_by_id($v->brand_id)}}</td>
																		<td>{{get_updown_name($v->up_down)}}{{$v->price}}元/吨</td>
																		<td>{{$v->mark}}</td>
																	</tr>
																@endforeach
																{{-- <tr>
																	<td>1</td>
																	<td>广钢</td>
																	<td>下单日我的钢铁网价格</td>
																	<td>上浮20元/吨</td>
																	<td>上浮20元/吨</td>
																	<td>88</td>
																</tr>
																<tr>
																	<td>1</td>
																	<td>广钢</td>
																	<td>下单日我的钢铁网价格</td>
																	<td>上浮20元/吨</td>
																	<td>上浮20元/吨</td>
																	<td>88</td>
																</tr>
																<tr>
																	<td>1</td>
																	<td>广钢</td>
																	<td>下单日我的钢铁网价格</td>
																	<td>上浮20元/吨</td>
																	<td>上浮20元/吨</td>
																	<td>88</td>
																</tr>  --}}
															</table>
															@endif
														</div>
												    </div>
												</div>
											</div>
										</td>
									</tr>

									@endforeach
								</tbody>
							</table>
						</div>
						<br><br><br>

						<div class="second-bid">
							<h3 class="box-title">二次各单位报价</h3>
							<h3 class="_box-title">报价详细:</h3>

							<table class="table table-condensed blue-table">
								<thead style="vertical-align:middle; text-align:center;">
									<tr>
										<td>公司名称</td>
										<td>投标书</td>
										<td>操作</td>
									</tr>
								</thead>
								<tbody style="vertical-align:middle; text-align:center;">
								@if(empty($second_prices))
									<tr><td colspan="3">暂无二次报价</td></tr>
								@else
										@foreach($second_prices as $uid=>$qprice)
										<tr class="hover-tr" onclick="$(this).next().css('display') == 'none' ? $(this).next().show() : $(this).next().hide();">
											<td>{{get_company_name_by_uid($uid)}} <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="点击本行可以展开详细信息"> </i></td>
											<td><a href="/tenderee/view_bidfile/{{$uid}}/{{$bid->id}}" target="_blank" class="line-btn">查看</a></td>
											<td style="color:#d43f3a;">
											{!! Form::open(['action' => ['BidsController@tenderee_my_bid_whowin', $bid->id], 'id'=>'form2-'.$uid]) !!}
											@if($isTimeOut==true)
											<button type="button" class="line-btn" onclick="confirm('确定宣布该公司({{get_company_name_by_uid($uid)}})中标?') ? $('#form2-{{$uid}}').submit() : false;event.stopPropagation();">宣布中标</button>
											@else
											<button type="button" class="line-btn" onclick="alert('现在还未到开标时间');event.stopPropagation();window.location.reload(); ">宣布中标</button>
											@endif
											<input name="whowin" type="hidden" value={{$uid}}>
											{!! Form::close() !!}
											</td>
										</tr>
										<tr style="display:none;" class="set-background">
											<td colspan="3">
												<div class="company-info">
													<div id="subx{{$uid}}">
													    <div class="column">
															<div class="">
																<!-- 批次比价 -->
																@if ($bid->type == 0)
																<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
																	<tr class="thead">
																		<th>序号</th>
																		<th>品名</th>
																		<th>规格</th>
																		<th>材质</th>
																		<th>品牌</th>
																		<th>重量(t)</th>
																		<th>首轮报价(元/吨)</th>
																		<th>二次报价(元/吨)</th>
																		{{-- <th>品牌</th>
																		<th>总价</th> --}}
																		<th>备注</th>
																	</tr>
																	@foreach ($qprice as $kq=>$qitem)
																		<tr>
																	    <td>{{$kq+1}}</td>
																		<td>{{get_cname_by_id($qitem->cname_cid)}}</td>
																		<td>{{get_size_by_id($qitem->size_cid)}}</td>
																		<td>{{get_material_by_id($qitem->material_cid)}}</td>
																		<td>{{get_brand_name_by_id($qitem->brand_id)}}</td>
																		<td>{{$qitem->amount}}</td>
																		<td>{{$qitem->price}}</td>
																		<td>{{$qitem->second_price ? $qitem->second_price : '暂未报价'}}</td>
																		<td>{{$qitem->mark}}</td>
																		</tr>
																	@endforeach
																</table>
																@elseif ($bid->type == 1)
																<!-- 统一比价 -->
																<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
																	<tr class="thead">
																		{{-- <th rowspan='2'>序号</th>
																		<th rowspan='2'>投标单位</th> --}}
																		{{-- <th colspan="2">综合单价(元/吨)</th> --}}
																		{{-- <th rowspan='2'>备注</th> --}}
																	</tr>
																	<tr class="thead">
																		<th>网价基础</th>
																		<th>二次报价</th>
																	</tr>
																	@foreach ($qprice as $kq=>$qitem)
																	<tr>

																		<td>{{get_qtype_name($qitem->qtype)}}</td>
																		@if(empty($qitem->second_price))
																			<td>暂无报价</td>
																		@else
																			<td>{{get_updown_symbol($qitem->sup_down)}}{{$qitem->second_price}}</td>
																		@endif
																	</tr>
																	@endforeach

																</table>
																@else
																<!-- 分品牌比价 -->
																<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
																	<tr class="thead">
																		<th rowspan="2">品牌</th>
																		{{-- <th rowspan="2">品名</th>  --}}
																		<th colspan='1'>综合单价(元/吨)</th>
																		<th rowspan="2">备注</th>
																	</tr>
																	<tr class="thead">
																		{{-- <th>网价基础</th> --}}
																		<th>二次报价</th>
																		{{-- <th>二次议价</th> --}}
																	</tr>
																	@foreach ($qprice as $k=>$v)
																		<tr>
																			<td>{{get_brand_name_by_id($v->brand_id)}}</td>
																			@if(!empty($v->second_price))
																				<td>{{get_updown_name($v->up_down)}}{{$v->second_price}}元/吨</td>
																			@else
																				<td>暂未报价</td>
																			@endif
																			<td>{{$v->mark}}</td>
																		</tr>
																	@endforeach
																</table>
																@endif
															</div>
													    </div>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								@endif

								</tbody>
							</table>
						</div>
					</div>

					<div class="project-info">
							<p class="prompt">{{get_project_name_by_id($bid->pid)}}项目操作项 : </p>
							<div style="width:300px;margin:auto;">
								<div class="controller-box">
									<a href="open/compare"  target="_blank" class="btn btn-default">比价</a>
									<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="直观的报价数据对比页面, 更容易挑选出合适单位"></i>
								</div>
								@if($is_wp)
									<div class="controller-box">
									<button class="btn btn-default" onclick="$('.bs-example-modal-lg').modal();$('.glyphicon-question-sign').eq(0).mouseleave();">查看建议价</button>
									</div>
								@else
									<div class="controller-box">
									<button class="btn btn-default" onclick="$('.bs-example-modal-lg').modal();$('.glyphicon-question-sign').eq(0).mouseleave();">发起二次议价</button>
									<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="觉得价格都不合适, 可以发起二次议价, 之后投标方后可以修改一次价格, 也可以保持原价"></i>
									</div>
								@endif
								<div style="clear:both;"></div>
							</div>
					</div>
						@include('bids.announce')
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>



	<!-- 模态框 : 二次议价 -->
	<div class="modal fade bs-example-modal-lg" id="negotiation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">{{get_project_name_by_id($bid->pid)}}议价</h4>
				</div>
				<div class="">
				{!! Form::open(['action' => ['BidsController@tenderee_my_bid_want', $bid->id]]) !!}
					<!-- 批次议价 -->
					@if ($bid->type == 0)
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<tr class="thead">
							<th>序号</th>
							<th>品名</th>
							<th>规格</th>
							<th>材质</th>
							<th>重量(t)</th>
							<td>品牌</td>
							<th>建议价(元/吨)</th>
							<th>理想价格(元/吨)</th>
						</tr>
						<?php $count = 0; $itemnums=count($adv_prices);?>
						@foreach ($adv_prices as $k=>$item)
							<tr>
							<td rowspan="2">{{$k+1}}</td>
							<td rowspan="2">{{get_cname_by_id($item['cname_cid'])}}</td>
							<td rowspan="2">{{get_size_by_id($item['size_cid'])}}</td>
							<td rowspan="2">{{get_material_by_id($item['material_cid'])}}</td>
							<td rowspan="2">{{$item['amount']}}</td>
							<?php $brandids=array_keys($item['adv_price']);$advprice=array_values($item['adv_price']);?>
							<td>{{get_brand_name_by_id($brandids[0])}}</td>
							<td>{{$advprice[0]}}</td>
							@if(empty($bid->want_price))
								@if($count==0)
								<td rowspan="{{2*$itemnums}}">
									在建议价的基础上统一
									<select name="up_down">
										<option disabled="true" selected="selected">请选择</option>
										<option value="1">上调</option>
										<option value="0">下调</option>
									</select>
									<input name="want_price" type="text" />
									元/吨
								</td>
								@endif
							@else
								@if(empty($bid->want_price))
									<td>统一{{get_updown_name($bid->up_down)}}{{$bid->want_price}}</td>
								@else
									<td rowspan="2">统一{{get_updown_name($bid->up_down)}}{{$bid->want_price}}</td>
								@endif
							@endif
							</tr>
							<tr>
								@if(isset($brandids[1]) && isset($advprice[1]))
									<td>{{get_brand_name_by_id($brandids[1])}}</td>
									<td>{{$advprice[1]}}</td>
								@endif
							</tr>

							<?php $count++ ?>
						@endforeach
					</table>
					@elseif ($bid->type == 1)
					<!-- 统一议价（发起议价） -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<tr class="thead">
							<!-- <th colspan='2'>综合单价(元/吨)</th>  -->
						</tr>
						<tr class="thead">
							<th>网价基础</th>
							<th>二次议价</th>
						</tr>
						<tr>
							<td>{{get_qtype_name($bid->qtype)}}</td>
							@if($is_wp)
								<td>{{$bid->want_price}}</td>
							@else
								<td>
								<select name="up_down">
									<option value="1">上浮</option>
									<option value="0">下浮</option>
								</select>
								<input name="want_price" type="text" / >元/吨
							</td>
							@endif

						</tr>

					</table>
					@else
					<!-- 分品牌议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<tr class="thead">
							<th colspan="3">综合单价(元/吨)</th>
							{{-- <th rowspan="2">备注</th>  --}}
						</tr>
						<tr class="thead">
							<th>品牌</th>
							<th>首轮报价最低价</th>
							<th>建议价格</th>
						</tr>
						<?php
							$count = 0;
						?>
						@foreach($lprices as $lpt2)
							<tr>
							<td>{{get_brand_name_by_id($lpt2->brand_id)}}</td>
							 <td>{{get_qtype_name($bid->qtype)}}{{$lpt2->lprice}}元/吨</td>{{--{{get_updown_symbol($lpt2->up_down)}} --}}
							<td>
								{{-- 下单日我的钢铁网价格 --}}
								@if(empty($bid->want_price))
									<select name="up_down[]">
										<option value="1">上浮</option>
										<option value="0">下浮</option>
									</select>
									<input name="want_price[]" type="text" / >元/吨
								@else
									<p>{{get_updown_name($bid->up_down)}}{{ $bid->want_price[$count] }}元/吨</p>
								@endif
							</td>
							{{-- <td><input type="text"></td> --}}
						</tr>
						<?php
							$count++;
						?>
						@endforeach
					</table>
					@endif

				</div>
				@if(empty($bid->want_price))
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">发起议价</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
				@endif
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	<!-- 模态框 : 查看详情 -->
	@foreach($company_prices as $cid=>$cprices)
	<?php $cinfo=get_company_info_by_uid($cid);?>
	<div class="modal fade company-modal-{{$cid}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel"> {{$cinfo->name}}详情</h4>
				</div>
				<div class="modal-body">
					<div>
					@if(!empty($cinfo))
						<p>企业名称: {{$cinfo->name}}</p>
						<p>企业地址: {{$cinfo->province}}{{$cinfo->city}}{{$cinfo->county}}{{$cinfo->address}}</p>
						<p>企业类型: {{get_company_type_name($cinfo->company_attr)}}</p>
						<p>注册资本: {{$cinfo->company_number}}</p>
						<p>营业执照号码: {{$cinfo->company_number}}</p>
						<p>营业执照有效期: {{$cinfo->company_number}}</p>
						<p>法定代表人: {{$cinfo->company_boss}}</p>
						<p>移动电话: {{$cinfo->company_tel}}</p>
						<p>证件号码: {{$cinfo->idcard_number}}</p>
					@else
						<p>暂无信息</p>
					@endif

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
	@endforeach

	</div>

@else
	<div class="box-content">
		<h4 class="title">暂无公司投标,请耐心等待</h4>
	</div>
@endif

	<script>
		setPageTitle("我的招标");

	$(document).ready(function(){
		//初始化隐藏的table
		$(".more-table, .brands-table, .first-price-1, .first-price-2").hide();
		//初始化jquery-labelauty
		$(".warpper-main :checkbox").labelauty();
		$(".warpper-main :radio").labelauty();
		// 初始化提示框
		$(".glyphicon-question-sign").eq(0).mouseenter();
		console.log($(".glyphicon-question-sign").eq(0))

		$("tr").click(function(){
			$(".glyphicon-question-sign").eq(0).mouseleave();
		});
	});



	</script>
@endsection
