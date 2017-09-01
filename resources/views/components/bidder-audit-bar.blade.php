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


@if(!empty($firstq))
@if($firstq[0]->status!=1)
<div class="check-box">
{{-- {!! Form::open(['action' => ['BidsController@b_audit', $bid->id]]) !!} --}}

@if (Auth::user()->can('复核') && Auth::user()->hasRole('bidder') && empty($firstq[0]->review_agree))
	<p>招标处理意见:</p>
	<div id="review">
		@if($firstq[0]->review_agree)	
		<p>复核: 同意 </p>
		@else
		<div>
			<p>复核 : </p>  
			<label class="agree"><input name="review_agree" type="radio" value="1" />同意 </label> 
			<label class="disagree"><input name="review_agree" type="radio" value="-1" />不同意 </label> 
		</div>
		<textarea name="review_reason" class="form-control" rows="3" placeholder="原因"></textarea>
		{{-- <button type="submit" class="btn btn-default">提交</button> --}}
		<input type="hidden" name="review_type" value="1"/>
		@endif
	</div>
@endif

@if (Auth::user()->can('决策') && Auth::user()->hasRole('bidder') && empty($firstq[0]->decision_agree))
	<div id="decision">
	@if($firstq[0]->decision_agree)
		<p>审核: 同意 </p>
	@else
		<div>
			<p>审核 : </p>  
			<label class="agree"><input name="decision_agree" type="radio" value="1"/>同意 </label> 
			<label class="disagree"><input name="decision_agree" type="radio" value="-1"/>不同意 </label> 
		</div>
		<textarea name="decision_reason" class="form-control" rows="3"></textarea>
		{{-- <button type="submit" class="btn btn-default">提交</button> --}}
		<input type="hidden" name="decision_type" value="1"/>
	@endif
	</div>
@endif
{{-- {!! Form::close() !!} --}}
</div>
@endif
@endif
