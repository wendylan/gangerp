<style>
	.bid-info-box{
		float:left;
		width:100%;
		margin-top:20px;
		padding:25px;
		border-radius:5px;
		background-color:#FFF;
		font-family:"微软雅黑";
	}
	.content-box{
		text-align:center;
	}
	.content-box p{
		float:left;
		width:30%;
	}

	.bid-info-box h4{
		font-size:16px;
		font-weight:700;
	}
	.text-style{
		margin:0px;
		font-size:14px;
	}
</style>

<div class="bid-info-box">
	<h3>招标详情:</h3>
	{{-- <div class="content-box"> --}}
				<div class="content-info">
					<h4>项目信息:</h4>
					<p class="text-style">1、招标项目名称：{{get_project_name_by_id($bid->pid)}}</p>
					<p class="text-style">2、招标项目地址：{{$bid->s_province}}{{$bid->s_city}}{{$bid->s_county}}{{$bid->add}}</p>
					<p class="text-style">3、采购内容及需求：</p>
					<p class="text-style">	 (1)材料名称：钢筋</p>
					<p class="text-style">	 (2)材料数量：{{$bid->batch_amount}}吨</p>
					<p class="text-style">	 (3)品牌范围：{{implode('、',$bid->brands)}}</p>
					<p class="text-style">	 (4)计量方式：{{$bid->mtype}}</p>
					<hr />

					<h4>具体信息</h4>
					<p class="text-style">截标时间：{{$bid->bid_deadline}}前</p>
					<p class="text-style">开标时间：{{$bid->bod}}</p>
					<p class="text-style">供货周期：{{$bid->delivery_day}}</p>
					<hr />

					<h4>报价要求</h4>
					{{qr_id_to_name_string($bid->quote_request)}}
					<hr />

					<h4>报价清单</h4>
					<table class="table" width="100%" border="1">
								<thead>
									<tr>
										<td>序号</td>
										<td>品名</td>
										<td>规格</td>
										<td>材质</td>
										<td>重量（吨）</td>
										<td>备注</td>
									</tr>
								</thead>
					<tbody>
									@foreach ($bid->quote_list as $key=>$item)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{get_cname_by_id($item[0])}}</td>
										<td>{{get_size_by_id($item[1])}}</td>
										<td>{{get_material_by_id($item[2])}}</td>
										<td>{{$item[3]}}</td>
										<td>{{$item[4]}}</td>
									</tr>
									@endforeach
					</tbody>
					</table>
					<hr />

					<h4>结算条件</h4>
					{{$bid->settlement}}
					<hr />

					<h4>付款方式</h4>
					{{$bid->paytype}}
					<hr />
	
					<h4>招标方式</h4>
					@if(!empty($bid->companys))
						<p class="text-style">定向招标，邀请以下公司参与投标</p>
						@foreach($bid->companys as $cid)
						<p class="text-style">{{get_company_name_by_cid($cid)}}</p>
						@endforeach
					@else
						<p class="text-style">公开招标</p>
					@endif
					<hr />

					<h4>备注</h4>
					@if(empty($bid->remark))
					<p class="text-style">暂无备注</p>
					@else
						<p class="text-style">{{$bid->remark}}</p>
					@endif
					<hr />
				</div>
		
		<div style="clear:both;"></div>
	{{-- </div> --}}
</div>