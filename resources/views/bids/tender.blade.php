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
				<div class="step-1 icon-box active-bar">
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
			<br />
			<ul class="company-list">
				<li>XXXXXX公司</li>
				<li>XXXXXXXXXXX公司</li>
				<li>XXXXXXXXXX公司</li>
				<li>XXXXXXXXXXXXXXXX公司</li>
				<li>XXXXXXXXXXXX公司</li>
				<li>XXXXX公司</li>
				<li>XXXXXXXXX公司</li>
			</ul>
			<br />
			<h3 class="title">通过审核的单位将开始投标, 请耐心等待。</h3>
			<br />
			<h3 class="title">现在可以更正一次招标内容, 是否&nbsp;<button class="btn btn-default" data-toggle="modal" data-target="#notice">发布更正公告</button>&nbsp;？</h3>
			<div class="no-one">
				<h2>目前暂无投标方报名,请耐心等待</h2>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>

	<!-- Modal -->
	<div class="modal fade" id="notice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">更正公告</h4>
				</div>
				<div class="modal-body">
					<h5>我司对XX项目钢筋招标（招标编号：XXX2016060301）部分内容作如下更正：</h5>
					<textarea width="100%" name="" id="" cols="30" rows="10"></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">发布</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

	<script>

	</script>
@endsection