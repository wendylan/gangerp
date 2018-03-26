<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="renderer" content="webkit">
        <link rel="stylesheet" href="/data/res/normalize.css">
        <link rel="stylesheet" href="/data/res/element-ui.css">
        <link rel="stylesheet" href="/data/assets/css/font-awesome.min.css">
        <title>六六钢铁网 广州钢铁 钢铁信息 </title>
        <style>
            *{
                font-size: 14px;
            }
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
        </script>
        @include('common')
        <div id="app"></div>
        <script src="./data/dist/retrievePassword.js"></script>
    </body>
</html>
