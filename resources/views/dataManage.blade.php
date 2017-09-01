
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="data/res/normalize.css">
    <link rel="stylesheet" href="data/res/element-ui.css">
    <link href="data/assets/css/bootstrap.min.css" rel="stylesheet">
    <title>data-project</title>
  </head>
  <body>
  <!-- {{config('app.dataUrl')}} -->
  <!-- {{csrf_token()}} -->
  <!-- {{Auth::user()->permissions}} -->
   <script>
      window.Laravel = {!! json_encode([
              'csrfToken' => Auth::user()->permissions,
          ]) !!};
      Laravel.apiToken="{{Auth::user()}}";
      var localUrl="{{config('app.dataUrl')}}";
      var _token='{{csrf_token()}}'
    </script>
    <div id="app"></div>
    <script src="./js/jquery-3.0.0.min.js"></script>
    <script src="data/assets/js/jquery.table2excel.min.js"></script>
    <script src="./data/dist/dataManage.js"></script>
  </body>
</html>
