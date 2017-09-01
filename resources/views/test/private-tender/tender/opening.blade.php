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
	.bg-success{
		padding:15px;
		width:100%;
		max-width:500px;
		margin:auto;
		font-size:18px;
		font-weight:700;
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
				<div class="step-1 icon-box active-bar">
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
			<p class="bg-success">如果您对投标方价格不满意, 可以发起&nbsp;<button class="btn btn-default" data-toggle="modal" data-target="#negotiation">二次议价</button></p>
			<br />
			<h3 class="title">二次议价结果:</h3>
			<br />
			<div class="second-tender-company" data-toggle="modal" data-target="#second-tender">XXXXXXXXXXX公司</div>
			<div class="second-tender-company" data-toggle="modal" data-target="#second-tender">XXXXXXXX公司</div>
			<div class="second-tender-company" data-toggle="modal" data-target="#second-tender">XXXXXXXXXXXXXXX公司</div>
			<div class="second-tender-company" data-toggle="modal" data-target="#second-tender">XXXXXXXXXX公司</div>
			<div class="second-tender-company" data-toggle="modal" data-target="#second-tender">XXXXXXX公司</div>
			<br />
			<p class="bg-success">现在你可以查看二次议价&nbsp;<button class="btn btn-default" data-toggle="modal" data-target="#contrastr">比价</button></p>
			<br />
			<h3 class="title">首次报价标书列表:</h3>
			<br />
			<div class="tender-company" data-toggle="modal" data-target="#tender-list">XXXXXXXXXXX公司</div>
			<div class="tender-company" data-toggle="modal" data-target="#tender-list">XXXXXXXX公司</div>
			<div class="tender-company" data-toggle="modal" data-target="#tender-list">XXXXXXXXXXXXXXX公司</div>
			<div class="tender-company" data-toggle="modal" data-target="#tender-list">XXXXXXXXXX公司</div>
			<div class="tender-company" data-toggle="modal" data-target="#tender-list">XXXXXXX公司</div>

			<br />
			<!-- 批次比价 -->
			<div>
				<h3 class="title">批次比价:</h3>
				<br />
				<div class="table-box">
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<!-- 一级表头 -->
						<tr class="thead"> 
							<th rowspan="2">序号</th> 
							<th rowspan="2">品名</th> 
							<th rowspan="2">规格</th> 
							<th rowspan="2">材质</th> 
							<th rowspan="2">重量(t)</th> 
							<th colspan="3">综合单价(元/吨)</th>
							<th rowspan="2">备注</th> 
						</tr> 
						<!-- 二级表头 -->
						<tr class="thead"> 
							<th>公司A</th> 
							<th>公司B</th> 
							<th>公司C</th> 
						</tr> 
						<tr> 
							<th>1</th>
							<th>盘螺</th>
							<th>Φ6</th>
							<th>HRB400E</th>
							<th>98</th>
							<th>88</th>
							<th>75</th>
							<th>94</th>
							<th>无</th>
						</tr> 
						<tr> 
							<th>1</th>
							<th>盘螺</th>
							<th>Φ6</th>
							<th>HRB400E</th>
							<th>98</th>
							<th>88</th>
							<th>75</th>
							<th>94</th>
							<th>无</th>
						</tr> 
						<tr> 
							<th>1</th>
							<th>盘螺</th>
							<th>Φ6</th>
							<th>HRB400E</th>
							<th>98</th>
							<th>88</th>
							<th>75</th>
							<th>94</th>
							<th>无</th>
						</tr> 
					</table> 
				</div>
			</div>

			<!-- 统一牌比价 -->
			<div>
				<h3 class="title">统一比价:</h3>
				<br />
				<div class="table-box">
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<!-- 一级表头 -->
						<tr class="thead"> 
							<th>序号</th> 
							<th>投标单位</th> 
							<th colspan='2'>综合单价(元/吨)</th> 
							<th>备注</th> 
						</tr> 
						<tr> 
							<th>1</th>
							<th>XXX公司</th>
							<th>下单日我的钢铁网价格</th>
							<th>HRB400E</th>
							<th>无</th>
						</tr> 
						<tr> 
							<th>1</th>
							<th>XXX公司</th>
							<th>下单日我的钢铁网价格</th>
							<th>HRB400E</th>
							<th>无</th>
						</tr> 
						<tr> 
							<th>1</th>
							<th>XXX公司</th>
							<th>下单日我的钢铁网价格</th>
							<th>HRB400E</th>
							<th>无</th>
						</tr> 
					</table> 
				</div>
			</div>

			<!-- 分品牌比价 -->
			<div>
				<h3 class="title">分品牌比价:</h3>
				<br />
				<div class="table-box">
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<!-- 一级表头 -->
						<tr class="thead"> 
							<th rowspan="2">序号</th> 
							<th rowspan="2">品牌</th> 
							<th colspan="4">综合单价(元/吨)</th>
							<th rowspan="2">今日我的钢铁网价格</th> 
							<th rowspan="2">备注</th> 
						</tr> 
						<!-- 二级表头 -->
						<tr class="thead"> 
							<th>网价基础</th>
							<th>公司A</th> 
							<th>公司B</th> 
							<th>公司C</th> 
						</tr> 
						<tr> 
							<th>1</th>
							<th>盘螺</th>
							<th rowspan="3">下单日我的钢铁网价格</th>
							<th>Φ6</th>
							<th>HRB400E</th>
							<th>75</th>
							<th>94</th>
							<th>无</th>
						</tr> 
						<tr> 
							<th>1</th>
							<th>盘螺</th>
							<th>Φ6</th>
							<th>HRB400E</th>
							<th>75</th>
							<th>94</th>
							<th>无</th>
						</tr> 
						<tr> 
							<th>1</th>
							<th>盘螺</th>
							<th>Φ6</th>
							<th>HRB400E</th>
							<th>75</th>
							<th>94</th>
							<th>无</th>
						</tr> 
						<!-- 表尾 -->
						<tr>
							<th colspan='3'>以今日网价计算总价(Φ18~25)</th>
							<th>TEST</th>
							<th>TEST</th>
							<th>TEST</th>
							<th>TEST</th>
							<th>TEST</th>
						</tr>
					</table> 
				</div>
			</div>
			
			<br />


			<div class="no-one">
				<h2>目前暂无投标方报名,请耐心等待</h2>
			</div>

		</div>
	</div>
	<div style="clear:both;"></div>



	<!-- 模态框 : 首次报价 -->
	<div class="modal fade" id="tender-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">XXXX公司</h4>
				</div>
				<div class="modal-body">
					<h4>招标编号: XXDSWDSS557</h4>
					<h4>招标项目 : XXX项目招标</h4>
					<h4>投标单位 : XXXX公司</h4>
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
							<tr>
								<td>2</td>
								<td>高线</td>
								<td>##6</td>
								<td>HRB500</td>
								<td>友钢</td>
								<td>100</td>
								<td>2200</td>
								<td>无</td>
							</tr>
							<tr>
								<td>3</td>
								<td>螺纹钢</td>
								<td>##6</td>
								<td>HRB880</td>
								<td>友钢</td>
								<td>100</td>
								<td>2200</td>
								<td>无</td>
							</tr>
							<tr>
								<td>4</td>
								<td>盘螺</td>
								<td>##6</td>
								<td>HRB400</td>
								<td>友钢</td>
								<td>100</td>
								<td>2200</td>
								<td>无</td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="btn btn-default">营业执照</button>
					<button type="button" class="btn btn-default">开户许可证</button>
					<button type="button" class="btn btn-default">法人证件</button>
					<button type="button" class="btn btn-default">标书</button>
					<button type="button" class="btn btn-default">下载全部</button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">宣布中标</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 模态框 : 二次议价 -->
	<div class="modal fade bs-example-modal-lg" id="negotiation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">XXX议价</h4>
				</div>
				<div class="modal-body">
					<!-- 批次议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th>序号</th> 
							<th>品名</th> 
							<th>规格</th> 
							<th>材质</th> 
							<th>重量(t)</th> 
							<th>首轮报价最低单价(元/吨)</th>
							<th>理想价格(元/吨)</th>
							<th>二次报价(元/吨)</th> 
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td><input type="text" /></td>
							<td>无</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td><input type="text" /></td>
							<td>无</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td><input type="text" /></td>
							<td>无</td>
						</tr> 
					</table>
					
					<!-- 统一议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th rowspan="2">序号</th> 
							<th rowspan="2">品名</th> 
							<th colspan='3'>综合单价(元/吨)</th> 
							<th rowspan="2">备注</th> 
						</tr> 
						<tr class="thead">
							<th>网价基础</th>
							<th>首轮报价</th>
							<th>二次议价</th>
						</tr>
						<tr> 
							<td>1</td>
							<td>广钢</td>
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>
								<select name="">
									<option value="上浮">上浮</option>
									<option value="下浮">下浮</option>
								</select>
								<input type="text" / >元/吨
							</td>
							<td>88</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>广钢</td>
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>
								<select name="">
									<option value="上浮">上浮</option>
									<option value="下浮">下浮</option>
								</select>
								<input type="text" / >元/吨
							</td>
							<td>88</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>广钢</td>
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>
								<select name="">
									<option value="上浮">上浮</option>
									<option value="下浮">下浮</option>
								</select>
								<input type="text" / >元/吨
							</td>
							<td>88</td>
						</tr> 
					</table>

					<!-- 分品牌议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th colspan="2">综合单价(元/吨)</th> 
							<th rowspan="2">备注</th> 
						</tr> 
						<tr class="thead">
							<th>首轮报价</th>
							<th>二次议价</th>
						</tr>
						<tr> 
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>
								<select name="">
									<option value="上浮">上浮</option>
									<option value="下浮">下浮</option>
								</select>
								<input type="text" / >元/吨
							</td>
						</tr> 
						<tr> 
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>
								<select name="">
									<option value="上浮">上浮</option>
									<option value="下浮">下浮</option>
								</select>
								<input type="text" / >元/吨
							</td>
						</tr> 
						<tr> 
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>
								<select name="">
									<option value="上浮">上浮</option>
									<option value="下浮">下浮</option>
								</select>
								<input type="text" / >元/吨
							</td>
						</tr> 
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">发起议价</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 模态框 : 二次议价结果 -->
	<div class="modal fade bs-example-modal-lg" id="second-tender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">XXX议价</h4>
				</div>
				<div class="modal-body">
					<!-- 批次议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th>序号</th> 
							<th>品名</th> 
							<th>规格</th> 
							<th>材质</th> 
							<th>重量(t)</th> 
							<th>首轮报价最低单价(元/吨)</th>
							<th>二次报价(元/吨)</th>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td>99</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td>99</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td>99</td>
						</tr> 
					</table>
					
					<!-- 统一议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th colspan='2'>综合单价(元/吨)</th> 
							<th rowspan="2">备注</th> 
						</tr> 
						<tr class="thead">
							<th>首轮报价</th>
							<th>二次议价</th>
						</tr>
						<tr> 
							<td>上浮20元/吨</td>
							<td>下单日我的钢铁网价格上浮10 元/吨</td>
							<td>88</td>
						</tr> 
					</table>

					<!-- 分品牌议价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th rowspan="2">序号</th> 
							<th rowspan="2">品名</th> 
							<th colspan='3'>综合单价(元/吨)</th> 
							<th rowspan="2">备注</th> 
						</tr> 
						<tr class="thead">
							<th>网价基础</th>
							<th>首轮报价</th>
							<th>二次议价</th>
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
						</tr> 
						<tr> 
							<td>1</td>
							<td>广钢</td>
							<td>下单日我的钢铁网价格</td>
							<td>上浮20元/吨</td>
							<td>上浮20元/吨</td>
							<td>88</td>
						</tr> 
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">发起议价</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 模态框 : 二次议价比价 -->
	<div class="modal fade bs-example-modal-lg" id="contrastr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">XXX议价</h4>
				</div>
				<div class="modal-body">
					<!-- 批次比价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th>序号</th> 
							<th>投标单位</th>
							<th>品名</th> 
							<th>规格</th> 
							<th>材质</th> 
							<th>重量(t)</th> 
							<th>品牌</th>
							<th>首轮报价(元/吨)</th>
							<th>二次报价(元/吨)</th>
							<th>二次报价最低单价</th>
							<th>我的钢铁网当日网价</th>
							<th>总价</th>
						</tr> 
						<tr> 
							<td>1</td>
							<td rowspan="3">A公司</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td rowspan="3">99</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td rowspan="3">B公司</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>98</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td rowspan="3">13168</td>
						</tr>
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
						</tr> 
						<tr> 
							<td>1</td>
							<td>盘螺</td>
							<td>Φ6</td>
							<td>HRB400E</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
							<td>88</td>
							<td>99</td>
						</tr> 
					</table>
					
					<!-- 统一比价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th rowspan='2'>序号</th> 
							<th rowspan='2'>投标单位</th>
							<th colspan="2">综合单价(元/吨)</th>
							<th rowspan='2'>备注</th>
						</tr> 
						<tr class="thead">
							<th>网价基础</th>
							<th>二次议价</th>
						</tr>
						<tr> 
							<td>1</td>
							<td>X X 公司</td>
							<td>下单日我的钢铁网价格</td>
							<td>+50</td>
							<td>55</td>
						</tr>
						<tr> 
							<td>1</td>
							<td>X X 公司</td>
							<td>下单日我的钢铁网价格</td>
							<td>+50</td>
							<td>55</td>
						</tr> 
					</table>

					<!-- 分品牌比价 -->
					<table class="table table-bordered" width="100%" cellpadding="1" cellspacing="1" border="1"> 
						<tr class="thead"> 
							<th rowspan="2">序号</th> 
							<th rowspan="2">品名</th> 
							<th colspan='4'>综合单价(元/吨)</th> 
							<th rowspan="2">我的钢铁网今日价格(Φ18~25)</th> 
							<th rowspan="2">备注</th> 
						</tr> 
						<tr class="thead">
							<th>网价基础</th>
							<th>A公司</th>
							<th>B公司</th>
							<th>C公司</th>
						</tr>
						<tr> 
							<td>1</td>
							<td>广钢</td>
							<td rowspan="3">下单日我的钢铁网价格</td>
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
						</tr> 
						<tr> 
							<td>1</td>
							<td>广钢</td>
							<td>+50</td>
							<td>+50</td>
							<td>+50</td>
							<td>88</td>
							<td>88</td>
						</tr>
						<tr>
							<td colspan="3">以今日网价为基础计算总价(Φ18~25)</td>
							<td>+150</td>
							<td>+150</td>
							<td>+150</td>
							<td>/</td>
							<td>/</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">发起议价</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
	

	<script>
		// //平台数据
		// var projectData = {
		// 	title : ["高线", "螺纹钢", "盘螺"]
		// }

		// // 基于准备好的dom，初始化echarts实例
	 //    var myChart = echarts.init(document.getElementById('dataMap'));

	 //    // 指定图表的配置项和数据
	 //    option = {
	 //        tooltip : {
	 //            trigger: 'axis',
	 //            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
	 //                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
	 //            }
	 //        },
	 //        legend: {
	 //            data: ["高线", "螺纹钢", "盘螺"]
	 //        },
	 //        grid: {
	 //            left: '3%',
	 //            right: '4%',
	 //            bottom: '3%',
	 //            containLabel: true
	 //        },
	 //        xAxis:  {
	 //            type: 'value'
	 //        },
	 //        yAxis: {
	 //            type: 'category',
	 //            data: ['A公司','B公司','C公司','D公司','E公司','F公司','G公司']
	 //        },
	 //        series: [
	 //            {
	 //                name: '高线',
	 //                type: 'bar',
	 //                stack: '价钱',
	 //                label: {
	 //                    normal: {
	 //                        show: true,
	 //                        position: 'insideRight'
	 //                    }
	 //                },
	 //                data: [320, 302, 301, 334, 390, 330, 320]
	 //            },
	 //            {
	 //                name: '螺纹钢',
	 //                type: 'bar',
	 //                stack: '价钱',
	 //                label: {
	 //                    normal: {
	 //                        show: true,
	 //                        position: 'insideRight'
	 //                    }
	 //                },
	 //                data: [120, 132, 101, 134, 90, 230, 210]
	 //            },
	 //            {
	 //                name: '盘螺',
	 //                type: 'bar',
	 //                stack: '价钱',
	 //                label: {
	 //                    normal: {
	 //                        show: true,
	 //                        position: 'insideRight'
	 //                    }
	 //                },
	 //                data: [220, 182, 191, 234, 290, 330, 310]
	 //            },
	 //            // {
	 //            //     name: '视频广告',
	 //            //     type: 'bar',
	 //            //     stack: '价钱',
	 //            //     label: {
	 //            //         normal: {
	 //            //             show: true,
	 //            //             position: 'insideRight'
	 //            //         }
	 //            //     },
	 //            //     data: [150, 212, 201, 154, 190, 330, 410]
	 //            // },
	 //            // {
	 //            //     name: '搜索引擎',
	 //            //     type: 'bar',
	 //            //     stack: '价钱',
	 //            //     label: {
	 //            //         normal: {
	 //            //             show: true,
	 //            //             position: 'insideRight'
	 //            //         }
	 //            //     },
	 //            //     data: [820, 832, 901, 934, 1290, 1330, 1320]
	 //            // }
	 //        ]
	 //    };

	 //    // 使用刚指定的配置项和数据显示图表。
	 //    myChart.setOption(option);

	</script>
@endsection