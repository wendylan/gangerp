@if(!empty($bid->corrections))
<div class="bid-edit-text">
<p class="prompt" style="padding:25px;margin:0px;">更正公告 : </p>
<pre>
{{$bid->corrections}}
</pre>
</div>
@endif
