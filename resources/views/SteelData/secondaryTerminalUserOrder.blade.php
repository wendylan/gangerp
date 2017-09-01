<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/data/res/normalize.css">
    <link rel="stylesheet" href="/data/res/element-ui.css">
    <link href="/data/assets/css/bootstrap.min.css" rel="stylesheet">
    <title>六六钢铁网 广州钢铁 钢铁信息 下单管理</title>
  </head>
  <body>
    <script>
      var _token = '{{ csrf_token() }}';
      var localUrl = "{{ config('app.dataUrl') }}";
      var role = "{{Auth::user()->roles}}";
      console.log(role);
    </script>
    <div id="app"></div>
    <script src="./data/dist/userOrder.js"></script>
  </body>
</html>
