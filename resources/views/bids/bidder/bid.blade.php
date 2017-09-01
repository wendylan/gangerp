@extends('backpack::layout')

@section("content")
	<style>
		html body .warpper-main{
			width: 100%;
			padding:25px;
			margin: auto;
		}

		.box-content{
			width:100%;
			min-height:300px;
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
		.bg-success{
			width:500px;
			padding:15px;
			margin:auto;
		}
		html body .status-time{
			font-size:14px;
			text-align: center;
			margin-top: 40px;
			color: #FFF;
		}
		.table-box{
			width:100%;
			height:auto;
			padding:10px;
			margin:20px auto;
			border-radius:5px;
			overflow:hidden;
			background:#FFF;
		}
		.button-group{
			width:170px;
			margin:auto;
		}


		.page-warpper{

		}
		.content-info{
			width:100%;
			min-height:300px;
			padding:20px;
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
		html body pre{
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
		.content-info h3{
			margin:0px;
		}

		.table-bule{
			border:solid 1px #DEDEDE;
		}
		.table-bule thead td{
			padding:15px 8px 15px 8px;
		}
		html body .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
			    padding: 15px 8px;
		}
		html body .table > tbody > tr > td{
			    font-size:14px;
		}
		.table-bule tbody{
			color:#797979;
		}
		.table-btn{
			color:black;
			cursor:pointer;
		}
		html body #edit-bids-modal .form-group{
			height:auto;
		}
		.table-bule input{
			width:80px;
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
		.error{
			color:red;
		}
		.self-waring{
			display:none;
			color:rgb(251, 150, 120);
			position:absolute;
		}

		.group-box{
			float:left;
			padding:10px;
		}
		.group-box p{
			text-align: center;
		}
		.project-info{
			padding:25px;
			background-color:#FFF;
		}
		html body .table-box table input, html body .table-box table select{
			padding:0px;
		}
		html body label.error{
			display:block;
		}
	</style>
	<div class="warpper-main">
		@include('components.tips-silider')
		<div>
			<div class="box-content">
				<div class="content-info">
					<h3 class="title" style="margin-top:50px;">报名成功</h3>
					<p style="text-align:center;color:#54667a;margin:10px auto;">现在可以查看招标文件, 投标截止至{{$bid->bid_deadline}}</p>
					<p style="text-align:center;color:#54667a;margin:10px auto;">您的首轮报价将会决定您接下来是否有资格参与第二次报价（首轮报价最低价前三名进入第二次报价）</p>
					@if(empty($firstq) || $firstq[0]->status==0)
					{!! Form::open(['action' => ['BidsController@bidder_bid_quote_store', $bid->id,'files' => true],'enctype'=>"multipart/form-data"]) !!}
						<div class="table-box">
							@if ($bid->type == 0)
							<table class="table table-condensed table-bule" width="100%">
								<thead>
									<tr>
										<td>序号</td>
										<td>品名</td>
										<td>规格</td>
										<td>材质</td>
										<td>品牌</td>
										<td>重量(t)</td>
										<td>现金采购价(元/吨)</td>
										@if(in_array(5,$bid->quote_request))
											<td>服务费(元/吨)</td>
										@endif  
										@if(in_array(2,$bid->quote_request))
											<td>运费(元/吨)</td>
										@endif
										@if(in_array(3,$bid->quote_request))
											<td>吊机费(元/吨)</td>
										@endif
										<td>综合单价<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="前几项价格的总价"></i></td>
										<td>规格总价<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="综合单价乘以重量"></i></td>
									</tr>
								</thead>
								<tbody>
									<?php  
									$total=0;
									$count = 0;
									?>
									@foreach ($bid->quote_list as $key=>$item)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{get_cname_by_id($item[0])}}</td>
										<td>{{get_size_by_id($item[1])}}</td>
										<td>{{get_material_by_id($item[2])}}</td>
										<td>
											<select id="brands-{{ $count }}" name="brands[]" required>
												<option selected="selected" disabled="true">请选择</option>
												@foreach($bid->brands as $b)
													<option value={{get_brand_id_by_name($b)}} 
													<?php 
														if(!empty($firstq)){
															if($firstq[$key]->brand_id==get_brand_id_by_name($b)){echo 'selected="selected"';}
														} 
													?>
													>{{$b}}</option>
												@endforeach
											</select>
										</td>
										<td class="_count">{{$item[3]}}</td>
										<td>
										@if(!empty($firstq))
												<input id="price-{{ $count }}" name="price[]" type="text" number="true" required value="{{$firstq[$key]->price}}" />
											@else
												<input id="price-{{ $count }}" name="price[]" type="text" number="true" required value="" />
											@endif
										</td>
										@if(in_array(5,$bid->quote_request))
											<td>											
											@if(!empty($firstq))
												<input id="service_price_{{ $count }}" class="service_price" name="s_price[]" type="text" number="true" required value="{{$firstq[$key]->s_price}}" />
											@else
												<input id="service_price_{{ $count }}" class="service_price" name="s_price[]" type="text" number="true" required value="" />
											@endif
											</td>
										@endif
										@if(in_array(2,$bid->quote_request))
										<td>
											@if(!empty($firstq))
												<input id="d_price_{{ $count }}" class="transport_price" name="d_price[]" type="text" number="true" required value="{{$firstq[$key]->d_price}}" />
											@else
												<input id="d_price_{{ $count }}" class="transport_price" name="d_price[]" type="text" number="true" required value="" />
											@endif		
										</td>
										@endif
										@if(in_array(3,$bid->quote_request))
										<td>
											@if(!empty($firstq))
												<input id="car_price_{{ $count }}" class="car_price" name="m_price[]" type="text" number="true" required value="{{$firstq[$key]->m_price}}" />
											@else
												<input id="car_price_{{ $count }}" class="car_price" name="m_price[]" type="text" number="true" required value="" />
											@endif
										</td>
										@endif
										@if(!empty($firstq))
										<td>
										<span>{{number_format($firstq[$key]->u_price)}}</span>
										<input id="product_price_{{ $count }}" class="product_price" name="u_price[]" type="hidden" number="true" required value="{{$firstq[$key]->u_price}}"/>
										</td>
										@else
										<td>
										<span></span>
										<input id="product_price_{{ $count }}" class="product_price" name="u_price[]" type="hidden" number="true" required value=""/>
										</td>
										@endif
										
										@if(!empty($firstq))
										<td>
										<span>{{number_format($firstq[$key]->t_price)}}</span>
										<input id="all_price_{{ $count }}" class="all_price" name="t_price[]" type="hidden" number="true" required>
										</td>
										@else
										<td>
										<span></span>
										<input id="all_price_{{ $count }}" class="all_price" name="t_price[]" type="hidden" number="true" required>
										</td>
										@endif
										<!-- <td><input name="price[]" type="number" required /><label id="project-name-error" class="self-waring" for="project-name">提示:正常单价应该在万以内</label></td> -->
										{{--<!-- <td>{{$item[4]}}</td> --> --}}
									</tr>
									<input type="hidden" name="cname_cid[]" value={{$item[0]}} />
									<input type="hidden" name="size_cid[]" value={{$item[1]}} />
									<input type="hidden" name="material_cid[]" value={{$item[2]}} />
									<input type="hidden" name="amount[]" value={{$item[3]}} />
									<?php 
										if(!empty($firstq[$key])){
											$total+=$firstq[$key]->t_price;
										}
									?>
										<?php $count += 1; ?>
									@endforeach
									<?php $need_qr=[2,3,5];$count_qr=count(array_intersect($bid->quote_request,$need_qr));$length=9+$count_qr;?>
									<tr>
										<td colspan="1">总价</td>
										<td colspan="{{$length-2}}"></td>
										<td class="all_table_standard">{{number_format($total)}}</td>
									</tr>
									<tr>
										<td>备注</td>
										@if(!empty($firstq))
										<td colspan="{{$length-1}}">
											<textarea name="fq_mark" class="form-control" type="text" style="width:50%;height:50px;">{{$firstq[$key]->mark}}</textarea>
										</td>
										@else
										<td colspan="{{$length-1}}">
											<textarea name="fq_mark" class="form-control" type="text" style="width:50%;height:50px;"></textarea>
										</td>
										@endif
										
									</tr>
									
								</tbody>
							</table>

							@elseif ($bid->type == 1)

							<table class="table table-condensed table-striped table-bule">
								<thead>
									<tr>
										<td>综合单价</td>
										<td>备注</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<span style="width:30%;float:left;">{{get_qtype_name($bid->qtype)}}</span>
											<select style="width:30%;float:left;" name="up_down" class="form-control" required>
												<option selected="true" disabled="true">请选择</option>
												<option value="1">上浮</option>
												<option value="0">下浮</option>
											</select>
											<input name="price" style="width:30%;float:left;" type="text" />元/吨
											<label id="project-name-error" class="self-waring" for="project-name">提示:正常单价应该在万以内</label>
										</td>
										<td>{{$bid->remark}}</td>
									</tr>
								</tbody>
							</table>

							@else
							<table class="table table-condensed table-striped table-bule">
								<thead>
									<tr>
										<td>序号</td>
										<td>品牌</td>
										<td>单价</td>
										<td>备注</td>
									</tr>
								</thead>
								<tbody>
									@foreach ($bid->quote_list as $key=>$item)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{get_brand_name_by_id($item[0])}}</td>
										<td>
											<span style="width:30%;float:left;">{{get_qtype_name($bid->qtype)}}</span>
											<select style="width:30%;float:left;" name="up_down[]" class="form-control" required>
												<option selected="true" disabled="true">请选择</option>
												<option value="1">上浮</option>
												<option value="0">下浮</option>
											</select>
											<input type="hidden" name="brand_id[]" value={{$item[0]}} />
											<input name="price[]" style="width:30%;float:left;" type="text" />
											<label id="project-name-error" class="self-waring" for="project-name">提示:正常单价应该在万以内</label>
										</td>
										<td>{{$item[1]}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							@endif
						</div>
						<input id="formType" style="display:none;" type="text" name="status" />
						@include('components.bidder-audit-record')
						@include('components.bidder-audit-bar')
						<div class="button-group">
							
						</div>
				</div>
			</div>

			<div class="project-info">
				<div class="info-content">
					<h3 class="prompt">{{get_project_name_by_id($bid->pid)}}项目操作项 : </h3>
					<div style="width:300px;margin:auto;">
						<div class="controller-box">
							<a href="/allbids/{{$bid->id}}/tfile" target="_blank" class="btn btn-default" >查看招标文件</a>
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看招标方发布的招标文件"></i>
						</div>
						<div class="controller-box">
							<a href="/投标书模板.docx" target="_blank" class="btn btn-default" >下载投标书模板</a>
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="下载填写投标书"></i>
						</div>
						<div class="controller-box">
							<button type="button" target="_blank" class="btn btn-default upload-bid-file" onclick="$('#upload-bid').click();" >上传投标书</button>
							<input id="upload-bid" name="bidfile" type="file" style="display:none;" />
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="(文件格式pdf)请盖章并上传投标文件"></i>
						</div>
						<div class="controller-box">
							<button type="button" class="btn btn-danger" onclick="checkFile(1)">发布投标</button>
							<input id="upload-bid" type="file" style="display:none;" />
							<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="将投标书发送到招标方"></i>
						</div>
						<div style="clear:both;"></div>
					</div>
				</div>
				@include('bids.announce')
			</div>

		</div>
		<div style="clear:both;"></div>
		@include('components.audit_bar')
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
					<h4 style="display:inline-block;"><b>招标编号</b>：CLZB20160601</h4>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<h4 style="display:inline-block;"><b>项目名称</b>：XX项目材料招标</h4>
					<div style="float:right;padding:10px;">
						<button class="btn btn-default">电子标书生成</button>
						<button class="btn btn-default">标书上传</button>
					</div>
					
			
				</div>
				
				<div class="modal-footer">
					
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
				{!! Form::close() !!}
			@else
					<h4 style="text-align:center;">已经投标，点击按钮跳转下一步</h4>
					<a href="open" class="btn btn-danger" style="display:block;width:100px;margin:auto;">下一步</a>
			@endif
			</div>
		</div>
		<div class="project-info">
			<div>
				<p class="prompt">操作项 : </p>
				<div style="width:300px;margin:auto;">
					<div class="controller-box">
						<a href="/allbids/{{$bid->id}}/tfile" target="_blank" class="btn btn-default" >查看招标文件</a>
						<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看招标方发布的招标文件"></i>
					</div>
					<div class="controller-box">
						<a href="/allbids/{{$bid->id}}/tfile" target="_blank" class="btn btn-default" >查看投标文件</a>
						<i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="查看我发布的投标文件"></i>
					</div>
					<div style="clear:both;"></div>
				</div>
			</div>
			@include('bids.announce')
		</div>
	</div>

	<script>
		setPageTitle("我的投标");

		function checkFile(data){
			$('#formType').val(data);
			var isSure = confirm("确定发布投标书?");
			if($("form").validate()){
				if(checkPrice()){
					$("form").submit();
				}else{
					var isSure = confirm("您有报价超过超过四位数, 确定发布?");
					if(isSure){
						$("form").submit();
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}

		// 限制价格
		function checkPrice(){
			var msg = true;
			$("table input[type!='hidden']").each(function(){
				if(parseInt($(this).val())>9999){
					msg = false;
				}
			});
			return msg;
		}

		$(function () {
		if ($.validator) {
		 //fix: when several input elements shares the same name, but has different id-ies....
		 $.validator.prototype.elements = function () {
		 var validator = this,
		  rulesCache = {};
		 // select all valid inputs inside the form (no submit or reset buttons)
		 // workaround $Query([]).add until http://dev.jquery.com/ticket/2114 is solved
		 return $([]).add(this.currentForm.elements)
		 .filter(":input")
		 .not(":submit, :reset, :image, [disabled]")
		 .not(this.settings.ignore)
		 .filter(function () {
		  var elementIdentification = this.id || this.name;
		  !elementIdentification && validator.settings.debug && window.console && console.error("%o has no id nor name assigned", this);
		  // select only the first element for each name, and only those with rules specified
		  if (elementIdentification in rulesCache || !validator.objectLength($(this).rules()))
		  return false;
		  rulesCache[elementIdentification] = true;
		  return true;
		 });
		 };
		}
		});

		$(".agree").click(function(){
			$(".btn-danger").text("发布投标");
			$('.check-box textarea').hide();
			$("table input, select, textarea").attr("disabled","true");
			$("table input, select, textarea").css("background","#DEDEDE");
		});
		$(".disagree").click(function(){
			$('.check-box textarea').show();
			$(".btn-danger").text("更新发布投标");
			$("table input, select, textarea").removeAttr("disabled");
			$("table input, select, textarea").css("background","#FFF");
		});

		$("input").keyup(function(){
			if($(this).val().length>4){
				$(".self-waring").show();
			}else{
				$(".self-waring").hide();
			}
		});

		$(".agree").click();

		$("table input").blur(function(){
			var inputs = $(this).parents("tr").find("input[type!='hidden']");
			console.log()
			var allPrice = [];
			var tempCount = 0;
			while(tempCount<4){
				allPrice.push(parseFloat($(inputs).eq(tempCount).val()))
				tempCount++;
			}

			var price = 0;
			for(var i=0; i<allPrice.length; i++){
				if(allPrice[i]){
					price += allPrice[i]
				}
			}

			var ton = parseInt($(this).parents("tr").find("._count").text());
			var tr = $(this).parents("tr");
			
			$(tr).find(".product_price").val(price.toFixed(2));
			$(tr).find(".all_price").val(price.toFixed(2)*ton);
			$(tr).find(".product_price").prev().text(numberToStr(price.toFixed(2)));
			$(tr).find(".all_price").prev().text(numberToStr((price*ton).toFixed(2)));

			//总价计算
			// $(".all_table_price")
			var inputValue = 0;
			$(".product_price").each(function(){
				inputValue += parseInt($(this).val());
			});

			$(".all_table_price").text(numberToStr(inputValue.toFixed(2)));

			var _inputValue = 0;
			$(".all_price").each(function(){
				if(parseInt($(this).val())){
					_inputValue += parseInt($(this).val());
				}
			});
			$(".all_table_standard").text(numberToStr(_inputValue.toFixed(2)));
		});

		//服务费自动填写
		$(".service_price").change(function(){
			var pressValue = $(this).val();
			$(".service_price").each(function(){
				var inputVal = $(this).val();
				if(!inputVal.length){
					$(this).val(pressValue);
					$(this).blur();
				}
			});
		});

		//吊机费自动填写
		$(".car_price").change(function(){
			var pressValue = $(this).val();
			$(".car_price").each(function(){
				var inputVal = $(this).val();
				if(!inputVal.length){
					$(this).val(pressValue);
					$(this).blur();
				}
			});
		});

		//运输费自动填写
		$(".transport_price").change(function(){
			var pressValue = $(this).val();
			$(".transport_price").each(function(){
				var inputVal = $(this).val();
				if(!inputVal.length){
					$(this).val(pressValue);
					$(this).blur();
				}
			});
		});


		function numberToStr(num){
			var numArr = num.toString().split('.');
			var numList = numArr[0].split('');
			var j = 0;

			for (var i=numList.length-1; i>=0; i--) {
				if( (j+1)%3===0 && (i-1)>=0 ){
					numList[i-1] += ',';
				}
				j++;
			}
			return numList.join('') + '.' + numArr[1];
		}


	</script>
@role('bidder')
	 <script>
	 	@if(!empty($firstq[0]))
			@if((Auth::user()->hasPermissionTo('决策') || Auth::user()->hasPermissionTo('复核')) && $firstq[0]->status==1)
				$("input, select, textarea").attr("disabled","disabled").css("background","#DEDEDE");
				$(".project-info").css('display','none'); 
			@else
				$('input').blur();
			@endif

			@if(Auth::user()->hasPermissionTo('复核') && $firstq[0]->review_agree!=0)
				$("input, select, textarea").attr("disabled","disabled").css("background","#DEDEDE");
				$(".project-info").css('display','none'); 
			@endif
		
			@if((Auth::user()->hasPermissionTo('录入') && $firstq[0]->review_agree!=0) || (Auth::user()->hasPermissionTo('录入') && $has_quote))
				$("input, select, textarea").attr("disabled","disabled").css("background","#DEDEDE");
				$(".project-info").css('display','none'); 
			@endif
		@endif
	</script>
@endrole
	

@endsection