<html>
<head>

	<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<!-- <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css"> -->

	<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/public-css/bootstrap-multiselect.css" type="text/css"/>
	<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/public-css/tooltip.css" type="text/css"/>
	<link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<!-- BackPack Base CSS -->
	<link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}">


	<!-- jQuery 2.2.0 -->
	<script src="{{ asset('vendor/adminlte') }}/public-js/jquery-2.2.0.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.0.min.js"><\/script>')</script>
	<!-- Bootstrap 3.3.5 -->
	<script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/public-js/jedate.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/public-js/area.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/public-js/echarts.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/public-js/jquery-labelauty.js"></script>
	<script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
	<script src="{{ asset('vendor/adminlte') }}/public-js/bootstrap-multiselect.js"></script>
	<script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
	<script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ asset('vendor/sms') }}/laravel-sms.js"></script>
	<!-- <script src="{{ asset('vendor/adminlte') }}/public-js/jquery-labelauty.js"></script> -->
	<style>
		html body table tr td,th{
			text-align:center;
		}
		html body .warpper-main{
			width: 100%;
			padding:25px;
			margin: auto;
		}
		.slider-bar{

		}
		.slider-bar>div{
			float:left;
			width:33%;
		}
		.slider-bar p{
			font-size:18px;
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
			color:#000;
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
		#dataMap{
			width:600px;
			height:400px;
			margin:auto;
		}

		.table-box{
			width:100%;
			height:auto;
			padding:10px;
			border-radius:5px;
			overflow:hidden;
			background:#FFF;
		}
		/*.thead{
			background:lightgray;
		}*/
		.bg-success{
			padding:15px;
			width:100%;
			max-width:500px;
			margin:auto;
			font-size:18px;
			font-weight:700;
		}
		html body .modal-dialog{
			width:994px;
		}

		html body #mcTooltip{
			background:#FFF;
			padding:0px;
			border:solid 1px #DEDEDE;
		}
		html body .mcTooltipInner{
			width:100%;
		}
		#sub1, #sub2{
		/*	position: absolute;
			left:3000px;*/
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

		.page-warpper{
			padding-right:380px;
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
			padding:20px;
			margin-right:-380px;
			background-color: #FFF;
			border-radius:5px;
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
		}
		.title{
			text-align: center;
		}
      /*  table{
            border :solid 1px #DEDEDE;
            font-size:14px;
        }
        table thead th{
            background: #f5f7fa;
        }

        table tr td{
            padding:5px;
            text-align:center;
            border-top :solid 1px #DEDEDE;
        }
        table tbody tr th{
            padding:8px;
            text-align:center;
            border-bottom :solid 1px #DEDEDE;
        }
        table tbody tr:hover{
            background-color:#e0e6ed;
        }
		table tr{
			background:#FFF;
			border-radius:10px;
		}
        */
        table{
			margin-top: 20px;
			width: 100%;
		    table-layout: fixed;
		    border-collapse:collapse;
			border:1px solid #e0e6ed;
			text-align:center;
			font-size:14px;
		}
		thead{
			background-color:#eef1f6;
		}
		thead th{
			text-align: center;
			padding:10px 0px;
			border:1px solid #dfe6ec;
		}
		table td{
			padding:10px;
			border:none;
			border-bottom:1px solid #e0e6ed;
			border-right:1px solid #e0e6ed;
		}
		table tbody tr:hover{
			background-color: #eff2f7;
		}
	</style>
</head>


<body>
	<div class="warpper-main">
@if(!empty($company_prices))
		<div class="temp-test-none">
			<div class="page-warpper">
			</div>
			<div style="clear:both;"></div>

			<!-- 批次比价 -->
			@if ($bid->type == 0)
			<div>
				<h3 class="title">首轮报价比价:</h3>
				<div class="table-box first-price-1">
						<?php
							if(!empty($firstq_prices)){$cids=explode(",",$firstq_prices[0]->cids);}
						?>
					<h3>1，按总价比价</h3>
					<table class="table table-bordered " width="100%" cellpadding="1" cellspacing="1" border="1">
						<!-- 一级表头 -->
						<thead>
							<tr class="thead">
								<th rowspan="2">序号</th>
								<th rowspan="2">品名</th>
								<th rowspan="2">规格</th>
								<th rowspan="2">材质</th>
								<th rowspan="2">重量(t)</th>
								{{--<th colspan="{{2*count($cids)}}">综合单价(元/吨)</th>--}}
								@foreach ($cids as $cid)
								{{-- <th colspan={{ count($cids)==1?count($cids)+1 : count($cids)-1 }}>{{get_company_name_by_uid($cid)}}</th>  --}}
								<th colspan="2">{{get_company_name_by_uid($cid)}}</th>
								{{-- <th colspan='2'>公司B</th>
								<th colspan='2'>公司C</th> --}}
								@endforeach
							</tr>
							<!-- 二级表头 -->

							<tr class="thead">
								@foreach ($cids as $cid)
									<td>品牌</td>
									<td>综合单价</td>
								@endforeach
							</tr>
						</thead>
						<?php $fcall=array();$count=0;?>


						@foreach ($firstq_prices as $fk=>$fv)
						<?php
						$fprices=explode(',',$fv->fprice);
						$fbrands=explode(',',$fv->fbrands);
						$cids=explode(',',$fv->cids);
						$frprices=explode(',',$fv->t_rprice);
						$fs_prices=explode(',',$fv->ts_price);
						$fd_prices=explode(',',$fv->td_price);
						$fm_prices=explode(',',$fv->tm_price);
						?>
							<tr>
						    <td>{{$fk+1}}</td>
							<td>{{get_cname_by_id($fv->cname_cid)}}</td>
							<td>{{get_size_by_id($fv->size_cid)}}</td>
							<td>{{get_material_by_id($fv->material_cid)}}</td>
							<td>{{$fv->amount}}</td>
							@for($i = 0; $i < count($fbrands); $i++)
								<td>{{get_brand_name_by_id($fbrands[$i])}}</td>
								<?php
								$fd_prices[$i]=isset($fd_prices[$i])?$fd_prices[$i]:0;
								$fs_prices[$i]=isset($fs_prices[$i])?$fs_prices[$i]:0;
								$fm_prices[$i]=isset($fm_prices[$i])?$fm_prices[$i]:0;
								?>
								<td>{{$fprices[$i]}} <i class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="top" data-html="true" title="现金采购价:{{$frprices[$i]}} <br>服务费:{{$fs_prices[$i]}} <br>运费:{{$fd_prices[$i]}} <br>吊机费:{{$fm_prices[$i]}}"></i></td>

							@endfor
							@foreach($cids as $ck=>$cid)
								<?php
								$fcall[$cid]=empty($fcall[$cid])?0:$fcall[$cid];
								$fcall[$cid]+=$fprices[$ck]*$fv->amount;
								?>
							@endforeach


							{{-- {{dd($fcall)}}
							@if($count==0)
								<td rowspan="{{count($cids)}}">{{$fv->mark}}</td>
							@endif--}}
							</tr>
							<?php $count++; ?>
						@endforeach

						<?php
							if(!empty($firstq_prices)){$fqttprices=explode(",",$firstq_prices[0]->cids);}
						?>
						<tr>
							<td colspan='5'>总价</td>
							@foreach($fqttprices as $k=>$cid)
							{{-- <td colspan='2'>{{to_wanyuan($fttp*$firstq_prices[$k]->amount)}}</td> --}}
							{{-- {{dd($fcall)}} --}}
							<td colspan='2'>{{number_format($fcall[$cid])}}</td>
							{{-- <td colspan='2'>1250</td>--}}
							@endforeach
						</tr>
						<tr>
							<td colspan='5'>备注</td>
							<td colspan="2">{{$fv->mark}}</td>
							<td colspan="2">{{$fv->mark}}</td>
						</tr>
					</table>
				</div>

				<div class="table-box first-price-2">
					<h3>2，按品牌比价</h3>
					<table class="table table-bordered " width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
							<tr class="thead">
								<th rowspan="2">品牌</th>
								<th rowspan="2">品名</th>
								<th rowspan="2">规格</th>
								<th rowspan="2">材质</th>
								<th rowspan="2">重量</th>
								<th colspan='{{count($order_companys)}}'>首次报价综合单价(元/吨)</th>
								<th rowspan="2">我的钢铁网今日价格</th>
							</tr>

							<tr class="thead">
								@foreach ($order_companys as $c)
								<th colspan='1'>{{get_company_name_by_uid($c->who)}}</th>
								@endforeach
							</tr>
						</thead>
						{{-- {{dd($order_companys)}} --}}
						@foreach ($fqb as $fqv)

							@foreach ($fqv as $vi=>$vv)

								<tr>
									@if($vi==0)
										<td rowspan='{{count($fqv)}}'>{{get_brand_name_by_id($vv->brand_id)}}</td>
									@endif
									<td>{{get_cname_by_id($vv->cname_cid)}}</td>
									<td>{{get_size_by_id($vv->size_cid)}}</td>
									<td>{{get_material_by_id($vv->material_cid)}}</td>
									<td>{{$vv->amount}}</td>
										<?php 
											$itemps=explode(',',$vv->fprice); 
											$cids=explode(',',$vv->cids);
											$cps=array_combine($cids,$itemps);
										?>
										@foreach($order_companys as $c)
											@if(empty($cps[$c->who]))
												<td>-</td>
											@else
												<?php
													$vv->s_price=empty($vv->s_price)?0:$vv->s_price;
													$vv->d_price=empty($vv->d_price)?0:$vv->d_price;
													$vv->m_price=empty($vv->m_price)?0:$vv->m_price;
												?>
												<td>{{$cps[$c->who]}} <i class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="top" data-html="true" title="现金采购价:{{$vv->price}} <br>服务费:{{$vv->s_price}} <br>运费:{{$vv->d_price}} <br>吊机费:{{$vv->m_price}}"></i></td>
											@endif
										@endforeach
										{{-- @foreach($itemps as $p)
											<td>{{$p}}</td>
										@endforeach
										@if(count($itemps)<count($order_companys))
											@for ($t=0;$t<count($order_companys)-count($itemps);$t++)
												<td>-</td>
											@endfor
										@endif --}}
									<td>{{$vv->fprice+80}}</td>
								</tr>
							@endforeach
						@endforeach
						<tr>
							<td colspan="5">备注</td>
							<!-- <td colspan="1">{{$vv->mark}}</td> -->
							<!-- <td colspan="1">{{$vv->mark}}</td> -->
							<td colspan="1">{{$vv->mark}}</td>
							<td colspan="1">{{$vv->mark}}</td>
							<td>/</td>
						</tr>
						<tr>
							<td colspan="5">总价</td>
							{{-- @foreach($order_companys as $tprice)
							<td>{{to_wanyuan($tprice->tfsprice*$tprice->amount)}}</td>
							<td colspan='2'>{{number_format($fcall[$cid])}}</td>
							@endforeach
							--}}
							@foreach($fcall as $ttp)
							<td colspan='1'>{{number_format($ttp)}}</td>
							@endforeach
							{{-- <td>+150</td>
							<td>+150</td>
							<td>+150</td> --}}
							<td>/</td>
						</tr>
					</table>
				</div>
			</div>
			@elseif ($bid->type == 1)
			<!-- 统一比价 -->
			<div>
				<h3 class="title">首轮报价比价:</h3>
				<br />
				<div class="table-box">
					<h3>1，统一比价</h3>
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<!-- 一级表头 -->
						<thead>
							<tr class="thead">
								{{-- <th>序号</th>  --}}
								<th>投标单位</th>
								<th colspan='2'>综合单价(元/吨)</th>
								<th>备注</th>
							</tr>
						</thead>
						@foreach($firstq_prices as $cid=>$price)
						<tr>
							<th>{{get_company_name_by_uid($cid)}}</th>
							<th>{{get_qtype_name($bid->qtype)}}</th>
							<th>{{$price}}</th>
							<th>无</th>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
			@else
			<!-- 分品牌比价 -->
			<div>
				<h3 class="title">首轮报价比价:</h3>
				<br />
				<div class="table-box">
					<h3>分品牌比价:</h3>
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<!-- 一级表头 -->
						<thead>
							<tr class="thead">
								<th rowspan="2">序号</th>
								<th rowspan="2">品牌</th>
								<th colspan="{{count($order_companys)+1}}">综合单价(元/吨)</th>
								<th rowspan="2">今日我的钢铁网价格</th>
								<th rowspan="2">备注</th>
							</tr>
							<!-- 二级表头 -->
							{{-- <tr class="thead">
								<th>网价基础</th>
								@foreach ($order_companys as $c)
								<th>{{get_company_name_by_uid($c->who)}}</th>
								@endforeach
							</tr> --}}
						</thead>

						<tr class="thead">
							<th>网价基础</th>
							@foreach ($fqbcids as $c)
							<th>{{get_company_name_by_uid($c)}}</th>
							@endforeach
						</tr>

						<?php $fqk=0;?>
						@foreach ($fqb as $fqbk=>$fqv)
							@foreach ($fqv as $vi=>$vv)
								<tr>
									<td>{{$fqbk}}</td>
									<td>{{get_brand_name_by_id($vv->brand_id)}}</td>
									@if($fqk==0)
										<td rowspan="3">{{get_qtype_name($bid->qtype)}}</td>
									@endif
										<?php $itemps=explode(',',$vv->fprice)?>
										@foreach($itemps as $p)
											<td>{{$p}}</td>
										@endforeach
										@if(count($itemps)<count($order_companys))
											@for ($t=0;$t<count($order_companys)-count($itemps);$t++)
												<td>-</td>
											@endfor
										@endif
									<td>{{$vv->net_price}}</td>
									<td>{{$vv->mark}}</td>
								</tr>
							@endforeach
							<?php $fqk++;?>
						@endforeach
						<!-- 表尾 -->
						{{-- <tr>
							<th colspan='3'>以今日网价计算总价(Φ18~25)</th>
							@foreach($order_companys as $tprice)
								<th>{{$tprice->tfsprice}}</th>
							@endforeach
							<th>/</th>
							<th>/</th>
						</tr> --}}
					</table>
				</div>
			</div>
			@endif



			@if ($bid->stage > 2 && $is_any_sqp)
			<h3 class="title">二次议价比价:</h3>
			<br />
			@if($bid->type==0)
				<!-- 批次比价 -->
				<div class="table-box more-table">
					<h3>1，批次比价</h3>
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
							<tr>
								<th>序号</th>
								<th>投标单位</th>
								<th>品名</th>
								<th>规格</th>
								<th>材质</th>
								<th>品牌</th>
								<th>重量(t)</th>
								<th>首轮报价(元/吨)</th>
								<th>二次报价(元/吨)</th>
								{{-- <th>二次报价最低单价</th> --}}
								<th>我的钢铁网当日网价</th>
								<th>总价</th>
							</tr>
						</thead>
						<?php $i=1;?>
						@foreach($ttprices as $k=>$items)
									@foreach($items['pics'] as $j=>$item)
									<tr>
									@if($j==0)
									<td rowspan="{{count($items['pics'])}}">{{$i}}</td>
									<td rowspan="{{count($items['pics'])}}">{{get_company_name_by_uid($k)}}</td>
									@endif
									<td>{{get_cname_by_id($item->cname_cid)}}</td>
									<td>{{get_size_by_id($item->size_cid)}}</td>
									<td>{{get_material_by_id($item->material_cid)}}</td>
									<td>{{get_brand_name_by_id($item->brand_id)}}</td>
									<td>{{$item->amount}}</td>
									<td>{{$item->u_price}}</td>
									<td>{{empty($item->second_price)?'暂未报价':$item->second_price}}</td>
									<td>{{$item->net_price}}</td>
									@if($j==0)
									<td rowspan="{{count($items['pics'])}}">{{number_format($items['allprices'])}}</td>

									@endif

									</tr>
									@endforeach

							<?php $i++;?>
						@endforeach
					</table>
				</div>
				<!-- 批次分品牌比价 -->
				<div class="table-box brands-table">
					<h3>2，批次招标分品牌比价</h3>
					<table class="table table-bordered " width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
							<tr>
								<th rowspan="2">品牌</th>
								<th rowspan="2">品名</th>
								<th rowspan="2">规格</th>
								<th rowspan="2">材质</th>
								<th rowspan="2">重量</th>
								<th colspan='{{count($sorder_companys)}}'>二次报价综合单价(元/吨)</th>
								<th rowspan="2">我的钢铁网今日价格</th>
								<th rowspan="2">备注</th>
							</tr>



						<tr >
							@if(!empty($sorder_companys))
								@foreach ($sorder_companys as $c)
									<th colspan='1'>{{get_company_name_by_uid($c->who)}}</th>
								@endforeach
							@endif

						</tr>
						</thead>


						@if($is_any_sqp)
							@foreach ($sqb as $sqv)
								@foreach ($sqv as $svi=>$svv)
									<tr>
										@if($svi==0)
											<td rowspan='{{count($sqv)}}'>{{get_brand_name_by_id($svv->brand_id)}}</td>
										@endif
										<td>{{get_cname_by_id($svv->cname_cid)}}</td>
										<td>{{get_size_by_id($svv->size_cid)}}</td>
										<td>{{get_material_by_id($svv->material_cid)}}</td>
										<td>{{$svv->amount}}</td>
										<?php $itemps=explode(',',$svv->fprice); $cids=explode(',',$svv->cids);
										//print_r($cids);print_r($itemps);exit;
										$scps = array_combine(array_intersect_key($cids, $itemps), array_intersect_key($itemps, $cids));
											//$scps=array_combine2($cids,$itemps);
										?>

										@foreach($sorder_companys as $c)
											@if(empty($scps[$c->who]))
												<td>-</td>
											@else
												<td>{{$scps[$c->who]}}</td>
											@endif
										@endforeach

										<td>{{$svv->net_price}}</td>
										<td>{{$svv->mark}}</td>
									</tr>
								@endforeach
							@endforeach
						@endif
							<tr>
							<td colspan="5">总价</td>
							@if(!empty($sorder_companys))
								@foreach($ttprices as $stprice)
								<td>{{number_format($stprice['allprices'])}}</td>
								@endforeach
							@endif
							<td>/</td>
							<td>/</td>
						</tr>
					</table>
				</div>
				@elseif($bid->type==1)
				<!-- 统一二次比价 -->
				<h3>1，统一二次比价</h3>
				<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
					<thead>
						<tr class="thead">
							{{-- <th rowspan='2'>序号</th>  --}}
							<th rowspan='2'>投标单位</th>
							<th colspan="2">综合单价(元/吨)</th>
							<th rowspan='2'>备注</th>
						</tr>
						<tr class="thead">
							<th>网价基础</th>
							<th>二次议价</th>
						</tr>
					
						@foreach($sq_prices_t1_ok as $scid=>$sprice)
							<tr>
								<th>{{get_company_name_by_uid($scid)}}</th>
								<th>{{get_qtype_name($bid->qtype)}}</th>
								<th>{{$sprice=empty($sprice)?'暂无报价':$sprice}}</th>
								<th>无</th>
							</tr>
						@endforeach
					</thead>

				</table>
				@else
				<!-- 分品牌比价 -->
				<h3>1，分品牌比价</h3>
				<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
					<!-- 一级表头 -->
						<thead>
							<tr class="thead">
								<th rowspan="2">序号</th>
								<th rowspan="2">品牌</th>
								<th colspan="{{count($sorder_companys)+1}}">综合单价(元/吨)</th>
								<th rowspan="2">今日我的钢铁网价格</th>
								<th rowspan="2">备注</th>
							</tr>
							<!-- 二级表头 -->
							<tr class="thead">
								<th>网价基础</th>
								@if(!empty($sqbcids))
									@foreach ($sqbcids as $c)
										<th>{{get_company_name_by_uid($c)}}</th>
									@endforeach
								@endif
							</tr>
						</thead>
						<?php $sfqk=0;?>
						@foreach ($sqb as $fvi=>$sfqv)
							@foreach ($sfqv as $vi=>$vv)
								<tr>
									<th>{{$fvi}}</th>
									<th>{{get_brand_name_by_id($vv->brand_id)}}</th>
									@if($sfqk==0)
										<th rowspan="3">{{get_qtype_name($bid->qtype)}}</th>
									@endif
										<?php $itemps=explode(',',$vv->fprice)?>
										@foreach($itemps as $p)
											@if(empty($p))
												<th>暂未报价</th>
											@else
												<th>{{$p}}</th>
											@endif

										@endforeach
										@if(count($itemps)<count($sorder_companys))
											@for ($t=0;$t<count($sorder_companys)-count($itemps);$t++)
												<th>-</th>
											@endfor
										@endif
									<th>{{$vv->net_price}}</th>
									<th>{{$vv->mark}}</th>
								</tr>
							@endforeach
							<?php $sfqk++;?>
						@endforeach
						<!-- 表尾 -->
						{{-- <tr>
							<th colspan='3'>以今日网价计算总价(Φ18~25)</th>
							@foreach($sorder_companys as $stprice)
								<th>{{$stprice->tfsprice}}</th>
							@endforeach
							<th>/</th>
							<th>/</th>
						</tr> --}}
				</table>
				@endif
			<br />

			@endif

			<br />

		</div>
	</div>
	<div style="clear:both;"></div>

	<div style="display:none;">
	@foreach ($company_prices as $company_id=>$cprice)
		<div id="sub{{$company_id}}">
		    <div class="column">
				<div class="modal-body">
					<!-- 批次议价 -->
					@if ($bid->type == 0)
					<table class="table table-bordered">
						<thead>
							<tr class="thead">
								<td>序号</td>
								<td>品名</td>
								<td>规格</td>
								<td>材质</td>
								<td>品牌</td>
								<td>重量(吨)</td>
								<td>单价(元/吨)</td>
								<td>备注</td>
							</tr>
						</thead>
						<tbody>
						@foreach ($cprice as $k=>$v)
							<tr>
							<td>{{$k+1}}</td>
							<td>{{get_cname_by_id($v->cname_cid)}}</td>
							<td>{{get_size_by_id($v->size_cid)}}</td>
							<td>{{get_material_by_id($v->material_cid)}}</td>
							<td>{{get_brand_name_by_id($v->brand_id)}}</td>
							<td>{{$v->amount}}</td>
							<td>{{$v->price}}</td>
							<td>{{$v->mark}}</td>
							{{-- <td><input name="want_price" type="text" /></td> --}}
							</tr>
						@endforeach
						</tbody>
					</table>

					<!-- 统一议价 -->
					@elseif ($bid->type == 1)
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
							<tr class="thead">
								<th colspan='1'>综合单价(元/吨)</th>
								{{-- <th rowspan="2">备注</th>  --}}
							</tr>
							<tr class="thead">
								<th>首轮报价</th>
								{{-- <th>二次议价</th> --}}
							</tr>
						</thead>
						<tr>
						@foreach ($cprice as $k=>$v)
							<td>{{get_updown_name($v->up_down)}}{{$v->price}}元/吨</td>
						@endforeach
							{{-- <td>下单日我的钢铁网价格上浮10 元/吨</td> --}}
							{{-- <td>88</td> --}}
						</tr>
					</table>
					@else
					<!-- 分品牌议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
							<tr class="thead">
								<th rowspan="2">品牌</th>
								{{-- <th rowspan="2">品名</th>  --}}
								<th colspan='1'>综合单价(元/吨)</th>
								<th rowspan="2">备注</th>
							</tr>
							<tr class="thead">
								{{-- <th>网价基础</th> --}}
								<th>首轮报价</th>
								{{-- <th>二次议价</th> --}}
							</tr>
						</thead>
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
	@endforeach

	@foreach($second_prices as $u=>$qp)
		<div id="subx{{$u}}">
		    <div class="column">
				<div class="modal-body">
					<!-- 批次比价 -->
					@if ($bid->type == 0)
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
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
						</thead>
						@foreach ($qp as $kq=>$qitem)
							<tr>
						    <td>{{$kq+1}}</td>
							<td>{{get_cname_by_id($qitem->cname_cid)}}</td>
							<td>{{get_size_by_id($qitem->size_cid)}}</td>
							<td>{{get_material_by_id($qitem->material_cid)}}</td>
							<td>{{get_brand_name_by_id($qitem->brand_id)}}</td>
							<td>{{$qitem->amount}}</td>
							<td>{{$qitem->price}}</td>
							<td>{{$qitem->second_price}}</td>
							<td>{{$qitem->mark}}</td>
							</tr>
						@endforeach
					</table>
					@elseif ($bid->type == 1)
					<!-- 统一比价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
							<tr class="thead">
								{{-- <th rowspan='2'>序号</th>
								<th rowspan='2'>投标单位</th> --}}
								<th colspan="2">综合单价(元/吨)</th>
								{{-- <th rowspan='2'>备注</th> --}}
							</tr>
							<tr class="thead">
								<th>网价基础</th>
								<th>二次报价</th>
							</tr>
						</thead>
						@foreach ($qp as $kq=>$qitem)
						<tr>

							<td>{{get_qtype_name($qitem->qtype)}}</td>
							<td>{{get_updown_symbol($qitem->sup_down)}}{{$qitem->second_price}}</td>
							{{-- <td>55</td> --}}
						</tr>
						@endforeach

					</table>
					@else
					<!-- 分品牌比价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1">
						<thead>
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
						</thead>
						@foreach ($qp as $k=>$v)
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
						{{-- <tr>
							<td>1</td>
							<td>广钢</td>
							<td>+50</td>
							<td>+50</td>
							<td>+50</td>
							<td>88</td>
							<td>88</td>
						</tr>
						<tr>
							<td>1</td>
							<td>广钢</td>
							<td>+50</td>
							<td>+50</td>
							<td>+50</td>
							<td>88</td>
							<td>88</td>
						</tr> --}}
					</table>
					@endif
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

</body>
</html>
<script>
	$(".glyphicon ").mouseenter(function(){
		var tr = $(this).parents("tr");
		$(tr).find(".glyphicon").tooltip('show');
	});
	$(".glyphicon ").mouseleave(function(){
		$(".glyphicon").tooltip('hide');
	});
</script>
