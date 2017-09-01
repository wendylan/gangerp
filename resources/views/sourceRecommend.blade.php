<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="data/res/normalize.css">
    <link rel="stylesheet" href="data/res/index.css">
    <link href="data/assets/css/bootstrap.min.css" rel="stylesheet">
    <title>data-project</title>
  </head>
  <body>
  <script>
      var _token='{{csrf_token()}}';
      var localUrl="{{config('app.dataUrl')}}"
    </script>
    <div id="app"></div>
    <script src="./data/dist/sourceRecommend.js"></script>
  </body>
</html>
