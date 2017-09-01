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
    @if(!empty($firstq_elo))
    @foreach($firstq_elo as $q)
        @foreach($q->revisionHistory as $history)
        @if($history->key == 'created_at' && !$history->old_value)
            <li>{{ $history->userResponsible()->name }} 录入 {{ $history->newValue() }}</li>
        @elseif($history->key == 'review_reason')
            <li>{{ $history->userResponsible()->name }} 复核：不同意 原因：{{ $history->newValue() }}{{ $history->created_at }}</li>
        @elseif($history->key == 'decision_reason')
            <li>{{ $history->userResponsible()->name }} 审核：不同意 原因：{{ $history->newValue() }}{{ $history->created_at }}</li>
        @elseif($history->key == 'price')
            <li>{{ $history->userResponsible()->name }} {{get_quote_info_nanme($history->revisionable_id)}}报价更新为：{{ $history->newValue() }}</li>   
        @elseif($history->key == 'review_agree' && $history->old_value==-1)
            <li>{{ $history->userResponsible()->name }} 复核：不同意 详情查看修改记录 </li>
        @elseif($history->key == 'status' && $history->new_value==1)
            <li>{{ $history->userResponsible()->name }} 此次招标已通过审核成功发起 </li>
        @elseif($history->key == 'mark')
            @if(empty($ismark))
                <li>{{ $history->userResponsible()->name }} 备注修改为：{{ $history->newValue() }} </li>
            @endif
            @php
            $ismark=1;
            @endphp
        @elseif($history->key == 'brand_id')
            <li>{{ $history->userResponsible()->name }} {{get_quote_info_nanme($history->revisionable_id)}}品牌修改为：{{ get_brand_name_by_id($history->newValue()) }} </li>
         @elseif($history->key == 'm_price')
            <li>{{ $history->userResponsible()->name }} {{get_quote_info_nanme($history->revisionable_id)}}吊机费修改为：{{ $history->newValue()}} </li>
         @elseif($history->key == 'd_price')
            <li>{{ $history->userResponsible()->name }} {{get_quote_info_nanme($history->revisionable_id)}}运费修改为：{{ $history->newValue()}} </li>
         @elseif($history->key == 's_price')
            <li>{{ $history->userResponsible()->name }} {{get_quote_info_nanme($history->revisionable_id)}}服务费修改为：{{ $history->newValue()}} </li>        
        @else
            {{-- <li>{{ $history->userResponsible()->name }} changed {{ $history->fieldName() }} from {{ $history->oldValue() }} to {{ $history->newValue() }}</li> --}}
        @endif
        @endforeach
    @endforeach
    @endif
</div>
<div style="clear:both;"></div>