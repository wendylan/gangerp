<style>
	.check-box{
		margin:20px 0px;
		padding:25px;
		border-radius:5px;
		background-color:#FFF;
	}
	.check-box>button{
		display:block;
		margin:10px auto 0px auto;
	}
	.check-box textarea{
		display:none;
	}
</style>


@if($bid->status!=1 && !empty(Auth::user()->id_parent))

{!! Form::open(['action' => ['BidsController@t_audit', $bid->id]]) !!}
@if (Auth::user()->hasPermissionTo('复核'))
<div class="check-box">
	<h4>招标处理意见:</h4>
	<div id="review">
		@if($bid->review_agree==1)	
		<p>复核: 同意  2016-12-21 10:30</p>
		@elseif($bid->review_agree==-1)
		<p>复核: 不同意，详情请查看修改记录</p>
		@else
		<div>
			<p>复核 : </p>  
			<label onclick="$('#review textarea').hide();$('.to-link').hide();$('.submit-btn').show();"><input name="review_agree" type="radio" value="1" checked="checked" />同意 </label> 
			<label onclick="$('#review textarea').show();$('.to-link').show();$('.submit-btn').hide();"><input name="review_agree" type="radio" value="-1" />不同意 </label> 
		</div>
		{{-- <textarea name="t_review" class="form-control" rows="3"></textarea> --}}
		<button type="submit" class="btn btn-default submit-btn">提交</button>
		<a href="./{{$bid->id}}/edit" class="to-link"><button type="button" class="btn btn-default">修改招标内容</button></a>
		
		<input type="hidden" name="review_type" value="1"/>
		@endif
	</div>
</div>
@endif

@if (Auth::user()->hasPermissionTo('决策'))
<div class="check-box">
		<div id="decision">
		@if($bid->decision_agree==1)	
			<p>审核: 同意  2016-12-21 10:30</p>
		@elseif($bid->decision_agree==-1)
			<p>审核: 不同意，详情请查看修改记录</p>
		@else
		<div>
			<p>审核 : </p>  
			<label onclick="$('#decision textarea').hide();$('.to-link').hide();$('.submit-btn').show();"><input name="decision_agree" type="radio" value="1"/>同意 </label> 
			<label onclick="$('#decision textarea').show();$('.to-link').show();$('.submit-btn').hide();"><input name="decision_agree" type="radio" value="0"/>不同意 </label> 
		</div>
		{{-- <textarea name="t_decision" class="form-control" rows="3"></textarea> --}}
		<button type="submit" class="btn btn-default submit-btn">提交</button>
		<a href="./{{$bid->id}}/edit" class="to-link"><button type="button" class="btn btn-default">修改招标内容</button></a>
		<input type="hidden" name="decision_type" value="1"/>
	@endif
	</div>
</div>
@endif
{!! Form::close() !!}

@endif

<style>
	.to-link{
		display:none;
	}
</style>