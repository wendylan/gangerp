@extends('backpack::layout')
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
		width:100%;
		max-width:500px;
		margin:100px auto 0px auto;
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
	._title{
		color:#5cb85c;
	}
	.text-style{
		margin:20px;
		font-size:17px;
	}
	.bg-success{
		padding:15px;
		font-size:20px;
		font-weight:700;
	}
</style>
@section("content")
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
			<br />
			<p class="bg-success">一、项目信息</p>
			<p class="text-style">1、招标项目名称：XX项目材料招标</p>
			<p class="text-style">2、招标项目地址：广东省广州市XX区XXXXXXXXXXXXXX路</p>
			<p class="text-style">3、采购内容及需求：</p>
			<p class="text-style">(1)材料名称：钢筋</p>
			<p class="text-style">(2)材料数量：10000吨</p>

			<p class="bg-success">二、购买标书要求</p>
			<p class="text-style">1、报名时间：2016年6月1日~2016年6月5日</p>
			<p class="text-style">2、报名方法：在本平台完成报名</p>

			<p class="bg-success">三、招标人信息</p>
			<p class="text-style">1、招标人名称：X X X</p>
			<p class="text-style">2、招标人地址：广东省广州市XX区XX路</p>
			<p class="text-style">3、招标联系人：X X X</p>
			<p class="text-style">4、联系人电话：15900000000</p>

			<p class="bg-success">四、备注</p>
			<p class="text-style">1、无</p>

			<h3 class="title" style="margin-top:50px;">您还未报名该项目, 现在可以 <button class="btn btn-success" onclick="confirm('是否参与报名？')">参与报名</button></h3>

			<div class="no-one">
				<h2>该项目已经报名, 正等待招标方审核</h2>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>

	<script>

	</script>
@endsection