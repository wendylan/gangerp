@extends('backpack::layout')

@section("content")
	<style>
		html body .warpper-main{
			width: 100%;
			padding:25px;
			margin: auto;
		}

		.box-content{
			float:left;
			width:100%;
			background:#FFF;
			border-radius:5px;
		}
		.box-content .title{
			text-align:center;
		}
		.box-content .company-list{
			/*padding:10px;
			background:#fefefe;*/
			border-radius:10px;
			overflow:hidden;
		}
		.box-content thead{
			font-weight:700;
		}
		._title{
			color:#5cb85c;
		}
		.text-style{
			margin:20px 0px 20px 50px;
			font-size:16px;
			color:#54667a;
		}
		.bg-success{
			padding:15px;
			font-size:20px;
			font-weight:700;
		}
		.content-info{
			float:left;
			width:100%;
			padding:25px;
			background-color:#FFF;
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
			width:100%;
		}
		.content-info h3{
			margin:0px;
		}
		form{
			display:block;
			margin:0px;
			padding:0px;
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
	</style>
	<div class="warpper-main">
		@include('components.tips-silider')
		<div class="page-warpper">
			<div class="box-content">
				@include('components.bid-info-box')
			</div>

			<div class="project-info">
				<div class="info-content">
					<h4 class="prompt">{{get_project_name_by_id($bid->pid)}}项目操作项 : </h4>
					<div class="controller-box">
					@if($isin)
						<p>您已经报名，请点击投标</p> 
						<a href="{{$bid->id}}/step2" class="btn btn-danger" style="display:block;width:100px;margin:auto;" >投标</a>
					@elseif(date('Y-m-d H:i:s')>$bid->bid_deadline || $bid->stage>2)
						<p>已截标</p> 
					@else
					{!! Form::open(['action' => ['BidsController@bidder_bid_add', $bid->id]]) !!}
						<button type="submit" class="btn btn-danger" style="display:block;width:100px;margin:auto;" >报名</button>
					{!! Form::close() !!}
					@endif
					</div>
					<div style="clear:both;"></div>
				</div>

				@include('bids.announce')
			</div>
		</div>
		<div style="clear:both;"></div>

	</div>
	<div style="clear:both;"></div>

	<script>
		setPageTitle("我的投标");
	</script>
@endsection