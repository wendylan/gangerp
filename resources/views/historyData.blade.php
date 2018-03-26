<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="data/res/normalize.css">
   <link rel="stylesheet" href="data/res/index.css">
   <link href="data/assets/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="/data/assets/css/font-awesome.min.css">
    <title>data-project</title>
  </head>
  <body>
    <script src="./data/dist/vendor.js"></script>
    <script>
      var localUrl="{{config('app.dataUrl')}}";
      var _token='{{csrf_token()}}'
    </script>
    <div id="app"></div>
    <script src="./data/dist/historyData.js"></script>
  </body>
</html>
