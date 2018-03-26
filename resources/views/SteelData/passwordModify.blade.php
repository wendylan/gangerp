<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/data/res/normalize.css">
    <link rel="stylesheet" href="/data/res/element-ui.css">
    <link rel="stylesheet" href="/data/assets/css/font-awesome.min.css">
    <title>六六钢铁网 广州钢铁 钢铁信息 下单管理</title>
	<style>
		body{
			background-color: #f8f8f8;
		}
	</style>
</head>
<body>
<script src="./data/dist/vendor.js"></script>
<script>
  var _token='{{ csrf_token() }}';
  var localUrl="{{ config('app.dataUrl') }}";
  var role = "{{Auth::user()->roles}}";
</script>
@include('common')
<div id="app">
</div>
<script src="./data/dist/modifyPassword.js"></script>
</body>
</html>
