<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/data/res/normalize.css">
    <link rel="stylesheet" href="/data/res/element-ui.css">
    <link href="/data/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/data/assets/css/font-awesome.min.css">
    <title>六六钢铁网 广州钢铁 钢铁信息 下单管理</title>
    <style>
        body{
            background-color: #f8f8f8;
            font-size: 14px;
        }
        .el-table .cell, .el-table th>div{
            padding-left: 6px;
            padding-right: 6px;
        }
    </style>
  </head>
  <body>
    <script src="./data/dist/vendor.js"></script>
    <script>
        var _token = '{{ csrf_token() }}';
        var localUrl = "{{ config('app.dataUrl') }}";
        var role = "{{Auth::user()->roles}}";
        console.log(role);
    </script>
    @include('common')
    <div id="app"></div>
    <script src="./data/dist/purchaseOrder.js"></script>
    </body>
</html>
