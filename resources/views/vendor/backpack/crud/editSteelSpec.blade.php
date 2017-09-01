@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.edit') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
		@endif

		  {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put')) !!}
		  <div class="box">
		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
		    </div>
		    <div class="box-body row">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content')
		      @else
		      	@include('crud::form_content', ['fields' => $crud->getFields('update', $entry->getKey())])
		      @endif

					<table class="default" id="spec">
						<button class="button" id="addSpecButton" >添加规格值</button>
						<tr>
							<th>规格值名称</th>
							<th>编码</th>
							{{-- <th>操作</th> --}}
						</tr>
						@if(!empty($spec_values))
							@foreach($spec_values as $sv)
								<tr>
								<td>
									<input type="hidden" name="svid[]" value="{{$sv->id}}">
									<input type="text" name="svname[]" value="{{$sv->name}}" />
								</td>
								<td>
									<input type="text" name="svcode[]" value="{{$sv->code}}" />
									{{-- <button class="button select_button" value="选择">选择</button> --}}
								</td>
								{{-- <td class="btn_min">
									<a href="javascript:;" class="icon-arrow-up-2">上升</a>
									<a href="javascript:;" class="icon-arrow-down-2">下降</a>
									<a href="javascript:;" class="icon-remove-2" >删除</a>
								</td> --}}
							</tr>
							@endforeach
						@else
						<tr>
							<td>
								<input type="hidden" name="value_id[]" value="0">
								<input type="text" name="value[]" />
							</td>
							<td>
								<input type="text" name="code[]" />
								{{-- <button class="button select_button" value="选择">选择</button> --}}
							</td>
							{{-- <td class="btn_min">
								<a href="javascript:;" class="icon-arrow-up-2">上升</a>
								<a href="javascript:;" class="icon-arrow-down-2">下降</a>
								<a href="javascript:;" class="icon-remove-2" >删除</a>
							</td> --}}
						</tr>
						@endif
						
					</table>


		    </div><!-- /.box-body -->
		    <div class="box-footer">

			  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>
		      <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		  {!! Form::close() !!}
	</div>
</div>
@endsection
