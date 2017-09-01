<style>
	.edit-box{
		float:left;
		width:100%;
		padding:25px;
		margin-top:20px;
		background-color:#FFF;
		border-radius: 5px;
	}
</style>

<div class="edit-box">
	<h3>审核记录:</h3>
	@foreach($bid->revisionHistory as $history)
	@if($history->key == 'created_at' && !$history->old_value)
		<li>{{ $history->userResponsible()->name }} 录入 {{ $history->newValue() }}</li>
	@elseif($history->key == 'review_reason')
		<li>{{ $history->userResponsible()->name }} 复核：不同意 原因：{{ $history->newValue() }}</li>
	@elseif($history->key == 'review_agree' && $history->new_value==1)
		<li>{{ $history->userResponsible()->name }} 复核：同意 </li>
	@elseif($history->key == 'status' && $history->new_value==1)
		<li>{{ $history->userResponsible()->name }} 此次招标已通过审核成功发起 </li>
	@elseif($history->key == 'contact_name')
		<li>{{ $history->userResponsible()->name }} 修改联系人为 {{ $history->newValue() }}</li>
	@elseif($history->key == 'quote_list')
		<li>{{ $history->userResponsible()->name }} 修改报价清单为 {{ qlist_to_title($history->newValue()) }}</li>
	@elseif($history->key == 'contact_phone ')
		<li>{{ $history->userResponsible()->name }} 修改联系电话为 {{ $history->newValue() }}</li>
	@elseif($history->key == 'amount')
		<li>{{ $history->userResponsible()->name }} 修改项目总吨数为 {{ $history->newValue() }} 吨</li>
	@elseif($history->key == 'batch_amount')
		<li>{{ $history->userResponsible()->name }} 修改批次吨数为 {{ $history->newValue() }} 吨</li>
	@elseif($history->key == 'quote_request')
		<li>{{ $history->userResponsible()->name }} 修改报价清单为 {{ qrequest_to_title($history->newValue()) }}</li>
	@elseif($history->key == 'paytype')
		<li>{{ $history->userResponsible()->name }} 修改付款方式为 {{ $history->newValue() }}</li>
	@elseif($history->key == 'delivery_day')
		<li>{{ $history->userResponsible()->name }} 修改供货周期为 {{ $history->newValue() }}</li>
	@elseif($history->key == 'settlement')
		<li>{{ $history->userResponsible()->name }} 修改结算条件为 {{ $history->newValue() }}</li>
	@elseif($history->key == 'mtype')
		<li>{{ $history->userResponsible()->name }} 修改计量方式为 {{ $history->newValue() }}</li>
	@else
		{{-- <li>{{ $history->userResponsible()->name }} 修改 {{ $history->fieldName() }} 从 {{ $history->oldValue() }} 修改为 {{ $history->newValue() }}</li> --}}
	@endif
	@endforeach
</div>
<div style="clear:both;"></div>