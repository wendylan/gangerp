<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户订单</title>
	<link rel="stylesheet" href="./data/res/normalize.css">
    <link rel="stylesheet" href="./data/res/element-ui.css">
    <link href="./data/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div id="app"></div>
    <script src="./data/dist/vendor.js"></script>
	<script src="https://cdn.bootcss.com/jquery/3.0.0/jquery.js"></script>
    <script>
        var localUrl = "www.gangerp-local.com";
        var _token = null;
    </script>
    <script>
        $.get('http://www.gangerp-local.com/api/getToken',function(response){
          _token = (response);
        });
    </script>
    <script src="./data/dist/userOrder.js"></script>
</body>
</html>