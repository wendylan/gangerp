@extends('backpack::layout')
<style>
	html body .form-group{
		width:33%;
	}
	.nav-tabs li{
		display:block;
		float:left;
	}
	#spec_name{
		padding:25px 25px 0px 25px;
	}
	.box{
		padding:25px;
	}
	.tab-pane{
		padding:20px 25px 20px 25px;
	}
	thead th{
		text-align:center;
	}
</style>
@section('header')
	<section class="content-header">
	  <h1>
	    {{'品牌编辑'}}
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		@if ($crud->hasAccess('list'))
			<a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ "返回上一页" }}</a><br><br>
		@endif

		  {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put', 'files'=>$crud->hasUploadFields('update', $entry->getKey()))) !!}
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
		    





<div class="" id="spec_name"> <!-- required for floating -->
  <!-- Nav tabs -->
  <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
@foreach ($specs as $spec)
		{{-- {{$spec[]}} --}}
		<li style="height:auto;"><a style="height:auto;" href="#{{$spec['id'] }}" sid="{{$spec['id'] }}" data-toggle="tab">{{$spec['name'] }}</a></li>
@endforeach

    {{-- <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
    <li><a href="#profile" data-toggle="tab">Profile</a></li>
    <li><a href="#messages" data-toggle="tab">Messages</a></li>
    <li><a href="#settings" data-toggle="tab">Settings</a></li> --}}
  </ul>
</div>
<div>
    <!-- Tab panes -->
    <div class="tab-content">
			@foreach ($specs as $spec)
				<div class="tab-pane" id="{{$spec['id'] }}">
								@if(!empty($spec['value']))        
										@foreach ($spec['value'] as $specv)
												@if(!empty($specv['id'])) 
												<input name="svids[]" sid="{{$specv['spec_id']}}" svid="{{$specv['id']}}" sname="{{$specv['name']}}" type="checkbox" code="{{$specv['code']}}" value="{{$specv['id']}}" 
												@if(in_array($specv['id'],$entry->svids))
														{{'checked="checked"'}}
												@endif
												 />{{$specv['name']}}
												@endif
										@endforeach
								@endif
				</div>
			@endforeach
    </div>
</div>


		    </div><!-- /.box-body -->

<button class="auto_products btn btn-default">生成所有货品</button>

<div style="padding:25px;">
	<button class="btn btn-info btn-add" type="button" style="float:right;margin-top:25px;">添加一行</button>
	<h3 class="mt">自动生成的品牌产品</h3>
    <table id="auto_spec_table" width="100%" style="margin-top:20px;">
        <thead>
            <tr>
                <th><label>编号</label></th>
                <th><label>品牌</label></th>
                <th><label>品名</label></th>
                <th><label>规格</label></th>
                <th><label>材质</label></th>
                {{-- <th><label>Promotion</label></th> --}}
                <th></th>
            </tr>
        </thead>

        <tbody>
					@foreach($products as $p)
            <tr>
								<td><input class="form-control" name="productcode[]" type="text" placeholder="编号" value="{{$p->steel_code}}" /></td>
                <td><input class="form-control" name="brand[]" type="text" placeholder="品牌" value="{{$p->brand}}" /></td>
                <td><input class="form-control" name="cate_spec[]" type="text" placeholder="品名" value="{{$p->cate_spec}}" /></td>
                <td><input class="form-control" name="size[]" type="text" placeholder="规格" value="{{$p->size}}" /></td>
                <td><input class="form-control" name="material[]" type="text" placeholder="材质" value="{{$p->material}}" /></td>
                {{-- <td><input class="form-control" name="promotion[]" type="text" placeholder="Promotion" /></td> --}}
                <td>
                    <button class="btn btn-danger btn-remove" type="button">
                        <i class="glyphicon glyphicon-minus gs"></i>
                    </button>
                </td>
            </tr>
						@endforeach
        </tbody>

    </table>
</div>



				
        {{-- <button class="btn btn-success" type="submit">
           <b> Save</b>
        </button>
        <button class="btn btn-default" type="button">
           <b> Back</b>
        </button> --}}



		    <div class="box-footer">
		    	<!-- <div class="form-group">
		    	  <span>{{ trans('backpack::crud.after_saving') }}:</span>
		          <div class="radio">
		            <label>
		              <input type="radio" name="redirect_after_save" value="{{ $crud->route }}" checked="">
		              {{ trans('backpack::crud.go_to_the_table_view') }}
		            </label>
		          </div>
		          <div class="radio">
		            <label>
		              <input type="radio" name="redirect_after_save" value="{{ $crud->route.'/create' }}">
		              {{ trans('backpack::crud.let_me_add_another_item') }}
		            </label>
		          </div>
		          <div class="radio">
		            <label>
		              <input type="radio" name="redirect_after_save" value="current_item_edit">
		              {{ trans('backpack::crud.edit_the_new_item') }}
		            </label>
		          </div>
		        </div> -->

			  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i>更新</span></button>
		      <a style="height:auto;" href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">取消</span></a>
		    </div><!-- /.box-footer-->

		  </div><!-- /.box -->





		  {!! Form::close() !!}
	</div>
</div>


@endsection
