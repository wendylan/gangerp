{{-- <form role="form"> --}}
  {{-- Show the erros, if any --}}
  @if ($errors->any())
  	<div class="col-md-12">
  		<div class="callout callout-danger">
	        <h4>{{ trans('backpack::crud.please_fix') }}</h4>
	        <ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul>
		</div>
  	</div>
  @endif

  {{-- Show the inputs --}}
  @foreach ($fields as $field)
    <!-- load the view from the application if it exists, otherwise load the one in the package -->
	@if(view()->exists('vendor.backpack.crud.fields.'.$field['type']))
		@include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
	@else
		@include('crud::fields.'.$field['type'], array('field' => $field))
	@endif
  @endforeach
{{-- </form> --}}

{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}

@section('after_styles')
	<!-- CRUD FORM CONTENT - crud_fields_styles stack -->
	@stack('crud_fields_styles')
@endsection

@section('after_scripts')
	<!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
	@stack('crud_fields_scripts')

	<script>
		// Ctrl+S and Cmd+S trigger Save button click
		$(document).keydown(function(e) {
		    if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
		    {
		        e.preventDefault();
		        // alert("Ctrl-s pressed");
		        $("button[type=submit]").trigger('click');
		        return false;
		    }
		    return true;
		});


 $("#addSpecButton").on("click",function(){
  if(2==$("input[name='type']:checked").val()){
    $("#spec").append('<tr> <td><input type="hidden" name="value_id[]" value="0"><input type="text" name="value[]" pattern="required" /></td> <td><input type="text" name="img[]" readonly="readonly" > <button class="button select_button">选择</button></td> <td class="btn_min"><a href="javascript:;" class="icon-arrow-up-2">上升</a><a href="javascript:;" class="icon-arrow-down-2">下降</a><a href="javascript:;"  class="icon-remove-2">删除</a></td></tr>');
  }else{
    $("#spec").append('<tr> <td><input type="hidden" name="svid[] value="0"" /><input type="text" name="svname[]" /></td> <td><input type="text" name="svcode[]"> </td> <td class="btn_min"><a href="javascript:;"  class="icon-remove-2">删除</a></td></tr>');
  return false;
  }
  bindEvent();
  return false;
  });
	</script>
@endsection