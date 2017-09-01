@extends('backpack::layout')

@section("content")
	<style>
		html body .content{
			padding-top:0px
		}
		html body .warpper-main{
			width: 100%;
			margin: auto;
			padding:0px 25px 25px 25px;
		}
		.no-one{
			display:none;
			width:100%;
			float:left;
			margin-bottom:-100px;
			text-align: center;
		}
		.box-content{
			clear:both;
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
			width: auto;
			margin: auto;
			font-size: 20px;
			padding-left: 150px;
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
		
		.project-info{
		    position: absolute;
		    top: 274px;
		    right: 430px;
		}
	
	</style>
	<div class="warpper-main">
		@include('components.tips-silider')
		<div class="page-warpper">
			<!-- Model -->
			<div class="box-content">
				<br />
				<div class="content-info">
					<h3>已报名的单位:</h3>
					<ul class="company-list">
					@if(!empty($firstq_cids))
						@foreach($firstq_cids as $c)
							<li>{{get_company_name_by_uid($c->uid)}}</li>
						@endforeach
					@else
							<li>暂无公司投标</li>
					@endif
					</ul>
					<br />
					<h3 class="title">报名参加投标单位将开始投标, 请耐心等待。</h3>
					<h3 class="title">截止投标时间：{{$bid->bid_deadline}}，届时将可查看首轮投标结果。</h3>
					
					<div class="no-one">
						<h2>目前暂无投标方报名,请耐心等待</h2>
					</div>

					
				</div>
				@include('components.bid-info-box')
				@include('components.audit-record')
			</div>

			<div class="project-info">
				<div class="info-content">
					<div class="prompt-box">
						<p class="prompt">目前的投标状态 : </p>
						
						@if(!empty($firstq_cids))
							<p class="prompt-title">投标进行中</p>
						@else
							<p class="prompt-title">报名中</p>
						@endif
					</div>
					<br>
					<p class="prompt">{{get_project_name_by_id($bid->pid)}}项目操作项 : </p>
					@if(empty($bid->corrections))
						<div class="controller-box">
							<button class="btn btn-default" data-toggle="modal" data-target="#notice">发布更正公告</button>
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="如果认为标书有遗漏或错误，可以发起一次更正公告，更正标书内容"></i>
						</div>
					@endif
					<div class="controller-box">
						<a href="/allbids/{{$bid->id}}/tfile" target="_blank" class="btn btn-default" >查看招标文件</a>
						<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看招标方发布的招标文件"></i>
					</div>
					<div class="controller-box">
						<a href="{{$bid->id}}/open" class="btn btn-default">查看投标详情</a>
						<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看投标详情"></i>
					</div>
					<div style="clear:both;" ></div>
				</div>
				
				@include('bids.announce')
				@include('components.audit_bar')
			</div>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="notice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">更正公告</h4>
				</div>
				{!! Form::open(['action' => ['BidsController@tenderee_my_bid_corrections', $bid->id]]) !!}
				<div class="modal-body">
					<h5>我司对{{get_project_name_by_id($bid->pid)}}钢筋招标内容作如下更正：</h5>
					<textarea style="width:100%;" name="corrections" cols="30" rows="10">{{$bid->corrections}}</textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="sendReport(this)">提交</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	


	<script>
		setPageTitle("我的招标");

		function sendReport(element){
			var isSend = confirm('每次招标只能发布一次更正公告, 确定发布 ? ');
			if(isSend){
				$(element).parents("form").submit();
				return true;
			}else{
				return false;
			}
		}
	</script>
@endsection