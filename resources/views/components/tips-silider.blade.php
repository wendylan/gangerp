<style>
	#sub{
		width:820px;
		height: 100px;
		margin:auto;
		opacity:0.9;
		border-radius:5px;
		z-index:999;
		color:#000;
	}
	#sub-b{
		width:720px;
		height: 150px;
		margin:0px auto 50px auto;
		opacity:0.9;
		border-radius:5px;
		z-index:999;
		color:#000;
	}
	.slider-bar>.big-icon{
		display:inline-block;
	}
	.slider-bar>div{
		float:left;
		
	}
	#sub .slider-bar>div{
		float:left;
		margin-right:30px;
	}
	.slider-bar p{
		font-size:18px;
		color:#54667a;
		font-weight:600;
	}
	.set-center-middle{
		margin-top:15px;
	}
	.icon-box{
		width:60px;
		height:60px;
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
		color:#54667a;
		font-size:14px;
	}
	.active-bar{
		color:#FFF;
		background: #5cb85c;
	}
	.active-bar p{
		color:#54667a;
	}

	html body .warpper-main{
		width: 100%;
		margin: auto;
		padding:0px 25px 25px 25px;
	}

	html body .status-time{
		font-size:14px;
		text-align: center;
		margin:0px;
		margin-top: 40px;
		color: #54667a;
	}


	.tips-box{
		position: relative;
		width: 100%;
		height: 130px;
		top: 10px;
	}
	.process-line{
		width:70%;
		margin:auto;
		height:8px;
		background-color:#DEDEDE;
	}
	.process-line-green{
		width:70%;
		margin:auto;
		height:5px;
		background-color:#00c292;
	}
	.process-line-small-right{
		float: right;
	    width: 50%;
	    margin-right: 0px;
	    margin-top: -50px;
	    height: 5px;
	    background-color: #DEDEDE;
	}
	.process-line-small-left{
		float: left;
	    width: 50%;
	    margin-right: 0px;
	    margin-top: -50px;
	    height: 5px;
	    background-color: #DEDEDE;
	}
	.set-color-green{
		background-color:#00c292;
	}
	.process-circle{
		position:relative;
		width:35px;
		height:35px;
		margin:auto;
		border:solid 5px #DEDEDE;
		border-radius:100px;
		background-color:#00c292;
	}
	.process-circle i{
		color:#FFF;
		margin: 3px 0px 0px 4px;
	}
	.process-circle-unactive{
		position:relative;
		width:35px;
		height:35px;
		margin:auto;
		border:solid 5px #DEDEDE;
		border-radius:100px;
		background-color:#DEDEDE;
	}
	.process-circle-box{
		float:left;
		width:24%;
	}
	.process-circle-box p{
		margin:5px 0px;
		text-align:center;
	}

	.layout-1{
		position: absolute;
		margin-top: 45px;
		z-index: 0;
		width: 100%;
		overflow:hidden;
	}
	.layout-2{
		position: relative
	}
</style>
<!-- @role('tenderee')
	<div id="sub">
	    <div class="column">
			<div class="modal-body">
			<div class="slider-bar">
				<div class="big-icon">
					<div class="step-1 icon-box active-bar">
						<div class="glyphicon glyphicon-pushpin set-center-middle"></div>
						<p>发布招标</p>
					</div>
					<p class="status-time" style="font-size:12px;">审批意见</p>
					<p style="font-size:12px;margin:0px;text-align:center;">复核, 审批</p>
				</div>

				<div style="margin:0px;margin-right:40px;">
					<i class="glyphicon glyphicon-arrow-right bids-icon"></i>
				</div>

				<div class="big-icon">
					<div class="step-1 icon-box active-bar">
						<div class="glyphicon glyphicon-pushpin set-center-middle"></div>
						<p>正在投标</p>
					</div>
					<p class="status-time">{{$bid->bid_deadline}}</p>
					<p style="font-size:14px;margin:0px;text-align:center;">(截止投标时间)</p>
				</div>

				<div style="margin:0px;margin-right:40px;">
					<i class="glyphicon glyphicon-arrow-right bids-icon"></i>
				</div>
				
				<div class="big-icon">
					<div class="step-1 icon-box">
						<div class="glyphicon glyphicon-dashboard set-center-middle"></div>
						<p>等待开标</p>
					</div>
					{{-- <p class="status-time">2015-11-16 16:55</p> --}}
				</div>

				<div style="margin:0px;margin-left:40px;">
					<i class="glyphicon glyphicon-arrow-right bids-icon"></i>
				</div>

				<div class="big-icon">
					<div class="step-1 icon-box">
						<div class="glyphicon glyphicon-flag set-center-middle"></div>
						<p>投标结束</p>
					</div>
					<p class="status-time">{{$bid->bod}}</p>
					<p style="font-size:14px;margin:0px;text-align:center;">(开标时间)</p>
				</div>
			</div>
			<div style="clear:both;"></div>
			</div>
	    </div>
	</div>
@endrole

@role('bidder')
<div id="sub-b">
    <div class="column">
		<div class="modal-body">
		<div class="slider-bar">
			<div class="big-icon">
				<div class="step-1 icon-box active-bar">
					<div class="glyphicon glyphicon-plus set-center-middle"></div>
					<p class="">报名</p>
				</div>
			</div>

			<div style="margin:0px;margin-left:40px;">
				<i class="glyphicon glyphicon-arrow-right bids-icon"></i>
			</div>

			<div class="big-icon">
				<div class="step-1 icon-box active-bar">
					<div class="glyphicon glyphicon-pushpin set-center-middle"></div>
					<p>进行投标</p>
				</div>
				<p class="status-time">{{$bid->bid_deadline}}</p>
				<p style="font-size:14px;margin:0px;text-align:center;">(截止投标时间)</p>
			</div>

			<div style="margin:0px;margin-right:40px;">
				<i class="glyphicon glyphicon-arrow-right bids-icon"></i>
			</div>
			
			<div class="big-icon">
				<div class="step-1 icon-box">
					<div class="glyphicon glyphicon-dashboard set-center-middle"></div>
					<p>等待开标</p>
				</div>
				{{-- <p class="status-time">2015-11-16 16:55</p> --}}
			</div>

			<div style="margin:0px;margin-left:40px;">
				<i class="glyphicon glyphicon-arrow-right bids-icon"></i>
			</div>

			<div class="big-icon">
				<div class="step-1 icon-box">
					<div class="glyphicon glyphicon-flag set-center-middle"></div>
					<p>投标结束</p>
				</div>
				<p class="status-time">{{$bid->bod}}</p>
				<p style="font-size:14px;margin:0px;text-align:center;">(开标时间)</p>
			</div>
		</div>
		<div style="clear:both;"></div>
		</div>
    </div>
</div>
@endrole -->

<div id="tips-box">
	<div class="layout-1">
		<!-- <div class="process-line"></div> -->
	</div>

	<div class="layout-2">
		<div class="process-circle-box">
			<div class="process-circle-content">
				<p>@{{ tipsText.step1.up }}</p>
				<div class="process-circle" v-if="tipsStep>=0">
					<i class="glyphicon glyphicon-ok"></i>
				</div>
				<div class="process-circle-unactive" v-else></div>

				<p>@{{ tipsText.step1.down }}</p>
				<div v-if="tipsStep>=1" class="process-line-small-right set-color-green"></div>
				<div v-else class="process-line-small-right"></div>
			</div>
		</div>
		<div class="process-circle-box">
			<div class="process-circle-content">
				<p>@{{ tipsText.step2.up }}</p>
				<div class="process-circle" v-if="tipsStep>=1">
					<i class="glyphicon glyphicon-ok"></i>
				</div>
				<div class="process-circle-unactive" v-else></div>

				<p>@{{ tipsText.step2.down }}</p>
				<div v-if="tipsStep>=1" class="process-line-small-left set-color-green"></div>
				<div v-else class="process-line-small-left"></div>
				<div v-if="tipsStep>=2" class="process-line-small-right set-color-green"></div>
				<div v-else class="process-line-small-right"></div>
			</div>
		</div>
		<div class="process-circle-box">
			<div class="process-circle-content">
				<p>@{{ tipsText.step3.up }}</p>
				<div class="process-circle" v-if="tipsStep>=2">
					<i class="glyphicon glyphicon-ok"></i>
				</div>
				<div class="process-circle-unactive" v-else></div>
				<p>@{{ tipsText.step3.down }}</p>

				<div v-if="tipsStep>=2" class="process-line-small-left set-color-green"></div>
				<div v-else class="process-line-small-left"></div>
				<div v-if="tipsStep>=3" class="process-line-small-right set-color-green"></div>
				<div v-else class="process-line-small-right"></div>
			</div>
		</div>
		<div class="process-circle-box">
			<div class="process-circle-content">
				<p>@{{ tipsText.step4.up }}</p>
				<div class="process-circle" v-if="tipsStep>=3">
					<i class="glyphicon glyphicon-ok"></i>
				</div>
				<div class="process-circle-unactive" v-else></div>
				<p style="width:1px;height:20px;"></p>
				<div v-if="tipsStep>=3" class="process-line-small-left set-color-green"></div>
				<div v-else class="process-line-small-left"></div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>

<script>
	var vueHandle = new Vue({
		el : "#tips-box",
		data : {
			tipsStep : {{get_tip_step($bid)}},
			tipsText : {
				step1 : {
					up : "发布招标",
					down : "{{$bid->created_at}}"
				},
				step2 : {
					up : "正在投标",
					down : "截标时间：{{$bid->bid_deadline}}"
				},
				step3 : {
					up : "等待开标",
					down : "开标时间：{{$bid->bod}}"
				},
				step4 : {
					up : "投标结束",
					down : "{{'&nbsp;'}}"
				}
			}
		}
	});
</script>