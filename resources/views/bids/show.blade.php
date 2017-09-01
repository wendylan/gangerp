@extends('backpack::layout')

@section("content")
	<style>
		html body .warpper-main{
			width: 100%;
			max-width: 1024px;
			margin: auto;
		}
		.slider-bar{
			
		}
		.slider-bar>div{
			float:left;
			width:25%;
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
			margin-top: 100px;
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
		.box-content .company-list{
			margin-top:50px;
			/*padding:10px;
			background:#fefefe;*/
			border-radius:10px;
			overflow:hidden;
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
		.erp-table{
			width:100%;
			border-radius:5px;
		}
		.erp-table td{
			padding:10px 10px 10px 50px;
		}
		.erp-table tr{
			border-bottom:solid 1px #DEDEDE;
			background:#FFF;
		}
	/*	.erp-table tr:hover{
			background:#F5F5F5;
		}*/
		.erp-table thead tr{
			color:#000;
			background:#dff0d8 !important;
		}
	</style>
	
	<div class="warpper-main">
		<div class="slider-bar">
			<div>
				<div class="step-1 icon-box active-bar">
					<div class="glyphicon glyphicon-plus set-center-middle"></div>
					<p class="">开始报名</p>
				</div>
			</div>

			<div>
				<div class="step-1 icon-box">
					<div class="glyphicon glyphicon-pushpin set-center-middle"></div>
					<p>开始投标</p>
				</div>
			</div>
			
			<div>
				<div class="step-1 icon-box">
					<div class="glyphicon glyphicon-dashboard set-center-middle"></div>
					<p>等待开标</p>
				</div>
			</div>

			<div>
				<div class="step-1 icon-box">
					<div class="glyphicon glyphicon-flag set-center-middle"></div>
					<p>投标结束</p>
				</div>
			</div>
			
		</div>
		<div style="clear:both;"></div>

		<div class="box-content">
			<h3 class="title">以下是报名投标的单位:</h3>
			<div class="company-list">
				<table class="erp-table">
					<thead>
						<tr>
							<td>序号</td>
							<td>名称</td>
							<td>状态</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>XXX公司</td>
							<td>通过</td>
							<td><button class="btn btn-default" data-toggle="modal" data-target="#review"">查看</button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>XXX公司</td>
							<td>未通过</td>
							<td><button class="btn btn-default" data-toggle="modal" data-target="#review"">查看</button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>XXX公司</td>
							<td>未通过</td>
							<td><button class="btn btn-default" data-toggle="modal" data-target="#review"">查看</button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>XXX公司</td>
							<td>未通过</td>
							<td><button class="btn btn-default" data-toggle="modal" data-target="#review"">查看</button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>XXX公司</td>
							<td>未通过</td>
							<td><button class="btn btn-default" data-toggle="modal" data-target="#review"">查看</button></td>
						</tr>
						<tr>
							<td>2</td>
							<td>XXX公司</td>
							<td>未通过</td>
							<td><button class="btn btn-default" data-toggle="modal" data-target="#review"">查看</button></td>
						</tr>
					</tbody>
				</table>
			</div>
			

			<div class="no-one">
				<h2>目前暂无投标方报名,请耐心等待</h2>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>

	<!-- Modal -->
	<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">报名单位详细信息</h4>
				</div>
				<div class="modal-body">
					<h4>基本信息</h4>
					<p>单位名称：XX公司</p>
					<p>单位地址：广东省广州市越秀区解放北路960号</p>
					<p>企业性质：国有企业</p>
					<p>企业类型：供应商</p>
					<p>注册资本：XXXX万元</p>
					<p>纳税人标识号：XXXXXXXXXXXXXXXXXXXXXXXXX</p>
					<p>营业执照注册号：XXXXXXXXXXXXXXXXXXXXXXX</p>
					<p>营业执照有效期：- -年--月--日~- -年--月--日</p>
					<p>经营范围：</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">审核通过</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

	<script>

	</script>
@endsection