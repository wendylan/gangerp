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
			<p class="bg-success">招标方发起了二次议价, 您可以选择改价或坚持原来价格:</p>
			<br />
			<div class="table-box">
				<table class="table table-bordered">
					<thead>
						<tr class="thead">
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
						<tr>
							<td>2</td>
							<td>高线</td>
							<td>##6</td>
							<td>HRB500</td>
							<td>友钢</td>
							<td>100</td>
							<td>2200</td>
							<td>2200</td>
							<td><input type="text"></td>
						</tr>
						<tr>
							<td>3</td>
							<td>螺纹钢</td>
							<td>##6</td>
							<td>HRB880</td>
							<td>友钢</td>
							<td>100</td>
							<td>2200</td>
							<td>2200</td>
							<td><input type="text"></td>
						</tr>
						<tr>
							<td>4</td>
							<td>盘螺</td>
							<td>##6</td>
							<td>HRB400</td>
							<td>友钢</td>
							<td>100</td>
							<td>2200</td>
							<td>2200</td>
							<td><input type="text"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<br/><br/>
		
			<div class="table-box">
				<table class="table table-bordered">
					<tr class="thead">
						<th colspan="2">综合单价</th>
						<th rowspan="2">备注</th>
					</tr>
					<tr class="thead">
						<th>首轮报价</th>
						<th>二次报价</th>
					</tr>
					<tr>
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
					</tr>
				</table>
			</div>

			<br/><br/>
			
			<div class="table-box">
				<table class="table table-bordered">
					<tr class="thead">
						<th>序号</th>
						<th>品牌</th>
						<th>首轮报价</th>
						<th>二次报价</th>
						<th>备注</th>
					</tr>
					<tr>
						<td>1</td>
						<td>广钢</td>
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
					</tr>
					<tr>
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
					</tr>
				</table>
			</div>

			<button class="btn btn-success" style="margin:100px auto 0px auto; width:50%; display:block;">提交二次报价</button>
			
			<div class="no-one">
				<h2>目前暂无投标方报名,请耐心等待</h2>
			</div>

		</div>
	</div>
	<div style="clear:both;"></div>

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