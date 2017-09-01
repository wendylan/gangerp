@extends('backpack::layout')

@section("content")
	<style>
		html body .warpper-main{
			width: 100%;
			padding:25px;
			margin: auto;
		}

		.no-one{
			display:none;
			width:100%;
			float:left;
			margin-bottom:-100px;
			text-align: center;
		}
		.box-content{
			float:left;
			width:100%;
			min-height:300px;
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
			width:100%;
			max-width:500px;
			margin:20px auto;
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
			padding:10px;
			background:#FFF !important;
			color:#000;
			font-size:18px;
			border-left:solid 10px #5cb85c;
			border-radius:5px;
			text-align:center;
			cursor:pointer;
		}
		.second-tender-company:hover{
			font-weight:900;
		}
		#dataMap{
			width:600px;
			height:400px;
			margin:auto;
		}

		table tr{
			background:#FFF;
			border-radius:10px;
		}
		.table-box{
			width:100%;
			height:auto;
			padding:10px;
			border-radius:5px;
			overflow:hidden;
			background:#FFF;
		}
		.thead{
			background:#dff0d8;
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
		.content-info h3{
			margin:0px;
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
		.error{
			color:red;
		}
	</style>
	<div class="warpper-main">
		@include('components.tips-silider')
		<div class="page-warpper">
			<div class="box-content">
				<div class="content-info">
				        @if($insq && !$issq)
							<p class="prompt">招标方发起了二次议价, 您可以选择改价或坚持原来价格:</p>
							<br />
							{!! Form::open(['action' => ['BidsController@bidder_bid_squote_store', $bid->id]]) !!}
							@if ($bid->type == 0)
							<div class="table-box">
								<table class="table table-condensed table-striped table-blue" width="100%">
									<thead>
										<tr>
											<td>序号</td>
											<td>品名</td>
											<td>规格</td>
											<td>材质</td>
											<td>品牌</td>
											<td>重量(吨)</td>
											<td>首轮报价综合单价</td>
											<td>招标方理想价</td>
											<td>二次报价</td>
										</tr>
									</thead>
									<tbody>
										@foreach ($prices as $k=>$item)
											<tr>
											<td>{{$k+1}}</td>
											<td>{{get_cname_by_id($item->cname_cid)}}</td>
											<td>{{get_size_by_id($item->size_cid)}}</td>
											<td>{{get_material_by_id($item->material_cid)}}</td>
											<td>{{get_brand_name_by_id($item->brand_id)}}</td>
											<td>{{$item->amount}}</td>
											<td>{{$item->u_price}}</td>
											@if(isset($bid->want_price))
												@if($bid->up_down==0)
													<td>{{$advp[$k]['adv_price'][$item->brand_id]-$bid->want_price}}</td>
												@else
													<td>{{$advp[$k]['adv_price'][$item->brand_id]+$bid->want_price}}</td>
												@endif
											@endif
											<td><input name="second_price[]" type="text" /></td>
											<input name="pid[]" type="hidden" value="{{$item->pid}}" />
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							@elseif ($bid->type == 1)
							<br/><br/>
							<div class="table-box">
								<table class="table table-condensed table-striped table-blue">
									<tr class="thead">
										<th>首轮报价</th>
										<th>招标方建议价格</th>
										<th>二次报价</th>
									</tr>
									<tr>
									@foreach ($prices as $k=>$item)
										<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{$item->price}}元/吨</td>
									@endforeach
										<td>{{get_updown_name($bid->up_down)}}{{$bid->want_price}}</td>
										<td>
											<select name="sup_down" required>
												<option selected="true" disabled="true">请选择</option>
												<option value="1">上浮</option>
												<option value="0">下浮</option>
											</select>
											<input name="second_price" type="text" style="width:50px;" /><span>元/吨</span>
										</td>
										{{-- <td><input type="text"></td> --}}
									</tr>
								</table>
							</div>
							@else
							<br/><br/>

							<div class="table-box">
								<table class="table table-condensed table-striped table-blue">
									<tr>
										<th>品牌</th>
										<th>首轮报价</th>
										<th>招标方建议价格</th>
										<th>二次报价</th>
										{{-- <th>备注</th> --}}
									</tr>
									<?php $count = 0; ?>
									@foreach ($prices as $k=>$item)
									<tr>
										<td>{{get_brand_name_by_id($item->brand_id)}}</td>

										<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{$item->price}}元/吨</td>
										<td>{{ $bid->want_price[$count] }}元/吨</td>
										<?php $count++; ?>
										<td>
											{{-- <span>下单日我的钢铁网价格</span> --}}
											<select name="sup_down[]" required>
												<option selected="true" disabled="true">请选择</option>
												<option value="1">上浮</option>
												<option value="0">下浮</option>
											</select>
											<input name="second_price[]" type="text" /><span>元/吨</span>
										</td>
										<input name="brand_id[]" type="hidden" value="{{$item->brand_id}}">
										{{-- <td><input type="text"></td> --}}
									</tr>
									@endforeach
									{{-- <tr>
										<td>2</td>
										<td>韶钢</td>
										<td>下单日我的钢铁网价格上浮20元/吨</td>
										<td>
											<span>下单日我的钢铁网价格</span>
											<select name="">
												<option value="上浮">上浮</option>
												<option value="下浮">下浮</option>
											</select>
											<input type="text" /><span>元/吨</span>
										</td>
										<td><input type="text"></td>
									</tr> --}}
								</table>

							</div>
							@endif

							<div class="no-one">
								<h2>目前暂无投标方报名,请耐心等待</h2>
							</div>

						@else
							@if($insq && $issq)
								<div class="box-content">
									<h3 style="text-align:center;margin-top:120px;">你已经提交二次议价,请耐心等待投标结果</h3>
									<a href="/bid/{{$bid->id}}/over" style="display:block;margin:20px auto;text-align:center;">点击查看结果</a>
								</div>
								<div class="box-content">
									<p style="text-align:center;color:#54667a;">您的报价 : </p>

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
														<td>{{$data->u_price}}</td>
														{{-- @if(isset($bid->want_price[$k])) --}}
															@if($bid->up_down==0)
															<td>{{$advp[$k]['adv_price'][$data->brand_id]-$bid->want_price}}</td>
															@else
																<td>{{$advp[$k]['adv_price'][$data->brand_id]+$bid->want_price}}</td>
															@endif
														{{-- @else
															<td>暂无招标方建议价</td>
														@endif --}}
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
													<th>招标方建议价格</th>
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
													<th>招标方建议价格</th>
													<th>二次报价</th>
												</tr>
												<?php $count = 0; ?>
												@foreach ($prices as $k=>$item)
												<tr>
													<td>{{get_brand_name_by_id($item->brand_id)}}</td>

													<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{$item->price}}元/吨</td>
													<td>{{ $bid->want_price[$count] }}元/吨</td>
													<?php $count++; ?>
													<td>
														<select name="sup_down[]" required >
															<option selected="true" disabled="true">请选择</option>
															<option value="1">上浮</option>
															<option value="0">下浮</option>
														</select>
														<input name="second_price[]" type="text" /><span>元/吨</span>
													</td>
													<input name="brand_id[]" type="hidden" value="{{$item->brand_id}}">
												</tr>
												@endforeach
											</table>
										</div>
									@endif

								</div>
							@else
							<div class="box-content">
								<h3 style="text-align:center;margin-top:95px;">等待招标方宣布结果或者进行二次议价</h3>
								<br/>
								<p style="text-align:center;color:#54667a;">您的报价 : </p>

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
												<td>现金采购价(元/吨)</td>
												@if(in_array(4,$bid->quote_request))
												<td>服务费(元/吨)</td>
												@endif
												@if(in_array(2,$bid->quote_request))
												<td>运费(元/吨)</td>
												@endif
												@if(in_array(3,$bid->quote_request))
												<td>吊机费(元/吨)</td>
												@endif
												<td>首轮综合报价</td>
												<td>招标方建议价</td>
												{{--<td>二次报价</td> --}}
											</tr>
										</thead>
										<tbody>
											@php
											$ttprices=0;
											@endphp
											@foreach($my_fqb as $k=>$item)
												<tr>
													<td>{{ $k+1 }}</td>
													<td>{{ get_cname_by_id($item->cname_cid) }}</td>
													<td>{{get_size_by_id($item->size_cid)}}</td>
													<td>{{get_material_by_id($item->material_cid)}}</td>
													<td>{{get_brand_name_by_id($item->brand_id)}}</td>
													<td>{{$item->amount}}</td>
													<td>{{$item->price}}</td>
													@if(in_array(4,$bid->quote_request))
													<td>{{$item->s_price}}</td>
													@endif
													@if(in_array(2,$bid->quote_request))
													<td>{{$item->d_price}}</td>
													@endif
													@if(in_array(3,$bid->quote_request))
													<td>{{$item->m_price}}</td>
													@endif
													<td>{{$item->u_price}}</td>
													@if(isset($bid->want_price[$k]))
														<td>{{$bid->want_price[$k]}}</td>
													@else
														<td>暂无招标方建议价</td>
													@endif
												</tr>
												@php
													$ttprices+=$item->t_price;
												@endphp
											@endforeach
											<?php $need_qr=[2,3,5];$count_qr=count(array_intersect($bid->quote_request,$need_qr));$length=9+$count_qr;?>
												<tr>
													<th>总价</th>
													<td colspan="{{$length-2}}"></td>
													<td>{{number_format($ttprices)}}</td>
													<td colspan="1"></td>
												</tr>
												<tr>
													<th>备注</th>
													<td colspan="10">
														<textarea class="form-control" disabled="disabled"></textarea>
													</td>
												</tr>
										</tbody>
									</table>
								@elseif ($bid->type == 1)
									<div class="table-box">
										<table class="table table-condensed table-striped table-blue">
											<tr>
												<th>首轮报价</th>
												<th>备注</th>
											</tr>
											@foreach ($my_fqb as $k=>$item)
											<tr>

												<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{$item->price}}元/吨</td>

												{{-- <td>
													<select name="sup_down">
														<option value="1">上浮</option>
														<option value="0">下浮</option>
													</select>
													<input name="second_price" type="text" /><span>元/吨</span>
												</td> --}}
												{{-- <td>暂无</td> --}}
												<td>暂无</td>

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
												{{-- <th>招标方建议价格</th>
												<th>二次报价</th> --}}
											</tr>
											<?php $count = 0; ?>
											@foreach ($prices as $k=>$item)
											<tr>
												<td>{{get_brand_name_by_id($item->brand_id)}}</td>

												<td>{{get_qtype_name($bid->qtype)}}{{get_updown_name($item->up_down)}}{{$item->price}}元/吨</td>
												{{-- <td>{{ $bid->want_price[$count] }}元/吨</td> --}}
												<?php $count++; ?>
												{{-- <td>
													<select name="sup_down[]">
														<option value="1">上浮</option>
														<option value="0">下浮</option>
													</select>
													<input name="second_price[]" type="text" /><span>元/吨</span>
												</td>
												<input name="brand_id[]" type="hidden" value="{{$item->brand_id}}"> --}}
											</tr>
											@endforeach
										</table>
									</div>
								@endif

							</div>
							@endif

						@endif
						@include('components.bidder-audit-record')
				</div>
			</div>

			<div class="project-info">
				<div class="info-content">
					<p class="prompt">{{get_project_name_by_id($bid->pid)}}项目操作项 : </p>
					<div style="width:300px;margin:auto;">
						<div class="controller-box">
							<a href="/allbids/{{$bid->id}}/tfile" target="_blank" class="btn btn-default" >查看招标文件</a>
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看招标方发布的招标文件"></i>
						</div>

						<div class="controller-box">
							<a href="/bidder/allbids/{{$bid->id}}/view_bidfile" target="_blank" class="btn btn-default" >查看投标文件</a>
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看我发布的投标文件"></i>
						</div>

						<div class="controller-box">
						@if($insq && !$issq)
							<button type="button" onclick="toSubmit()" class="btn btn-success">提交二次报价</button>
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="提交二次报价到招标方"></i>
						@endif
						</div>
						{!! Form::close() !!}
						<div style="clear:both;"></div>
					</div>
				</div>

				@include('bids.announce')
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>

	<script>
		setPageTitle("我的投标");
		$("form").validate();

		function toSubmit(){
			var isEmp = false;
			var canSubmit = true;

			if(checkPrice() === false){
				$("input").each(function(){
					if($(this).val().length<1){
						if(confirm("有报价框为空, 默认该项为第一次报价价格, 确定? ")){
							isEmp = true;
							return false;
						}else{
							canSubmit = false;
							return false;
						}
					}
				});

				if(isEmp){
					$("form").submit();
				}else{
					if(canSubmit){
						$("form").submit();
					}
				}
			}else{
				alert("二次报价不得高于首次报价");
			}
			
		}

		// 二次报价不得高于首次报价
		function checkPrice(){
			var isError = false;
			$("input[type!='hidden']").each(function(){
				var firstPrice = parseInt($(this).parents("tr").children().eq(6).text());
				var secondPrice = isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
				console.log(firstPrice, secondPrice)
				if(firstPrice<secondPrice){
					isError = true;
				}
			});
			return isError;
		}
	</script>
@endsection
