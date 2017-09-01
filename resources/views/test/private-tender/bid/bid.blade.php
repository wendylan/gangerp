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
		margin-top: 100px;
	}
	.box-content .title{
		text-align:center;
	}
	table tr{
		background:#FFF;
		border-radius:10px;
	}
	html body .table>tbody>tr>td, html body .table>tbody>tr>th, html body .table>tfoot>tr>td, html body .table>tfoot>tr>th, html body .table>thead>tr>td, html body .table>thead>tr>th{
		vertical-align:middle;
	}
	html body .warpper-main table{
		    margin-bottom: 0px;
	}
	.thead{
		background:#dff0d8;
	}
</style>
@section("content")
	<div class="warpper-main">
		<div class="slider-bar">
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
			<h3 class="title">招标方已发布招标文件, 现在可以 <button class="btn btn-default" data-toggle="modal" data-target="#check-file">查看招标文件</button> 。</h3>
			<br />
			<h3 class="title">投标截止至2020-02--02,  <button class="btn btn-default" data-toggle="modal" data-target="#create-bid">立即投标</button></h3>
			<h3></h3>
		</div>
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

	</script>
@endsection