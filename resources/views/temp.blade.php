@extends('backpack::layout')

@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">提示</div>

                <div class="panel-body">
                	<h3 style="text-align:center;">{{$text}}</h3>
                    <a href="#" onclick="history.go(-1)" style="display:block;margin:auto;width:40px;font-size:16px;">返回</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
