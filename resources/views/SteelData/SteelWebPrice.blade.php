<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/data/res/normalize.css">
    <link rel="stylesheet" href="/data/res/element-ui.css">
    <link href="/data/assets/css/bootstrap.min.css" rel="stylesheet">
    <title>六六钢铁网 广州钢铁 钢铁信息 网价</title>
  </head>
  <body>
    <script>
      var _token='{{ csrf_token() }}';
      var localUrl="{{ config('app.dataUrl') }}";
      var _defultDatas = {!! json_encode($webPriceDatas) !!};
      console.log(_defultDatas);
    </script>
    <div id="app"></div>
    <script src="./data//assets/js/jquery.min.js"></script>
    <script src="data/assets/js/jquery.table2excel.min.js"></script>
    <script src="./data/dist/steelWebPrice.js"></script>
  </body>
</html>
