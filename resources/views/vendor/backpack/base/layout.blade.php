<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9;IE=10;IE=11"/>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
      {{ isset($title) ? $title.' :: '.config('backpack.base.project_name').' Admin' : config('backpack.base.project_name').' Admin' }}
    </title>

    @yield('before_styles')

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.vertical-tabs.min.css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <!-- <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css"> -->

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/morris/morris.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/public-css/jedate.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/public-css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/public-css/jquery-labelauty.css" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/public-css/tooltip.css" type="text/css"/>
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}">


    <!-- jQuery 2.2.0 -->
    <script src="{{ asset('vendor/adminlte') }}/public-js/jquery-2.2.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.0.min.js"><\/script>')</script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/public-js/jedate.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/public-js/area.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/public-js/echarts.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/public-js/jquery-labelauty.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/public-js/jquery.validate.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/public-js/bootstrap-multiselect.js"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/sms') }}/laravel-sms.js"></script>
    <script src="{{ asset('js/vue.min.js') }}"></script>

    @yield('after_styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      *{
        font-family:"Microsoft YaHei", "微软雅黑", "SimHei","STXihei";
      }
      label.error{
        line-height:2.4;
        position: absolute;
        background: #FFF;
      }
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button{
          -webkit-appearance: none !important;
          margin: 0; 
      }

      html{
        -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale; 
      }

      html body .modal table input, html body .modal table select{
        height: 25px;
        padding: 0px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s
      }
      html body .table-box table input, html body .table-box table select{
        height: 25px;
        padding: 0px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s
      }

      a.logo{
        text-decoration:none;
        color:#54667a;
      }
      a.logo:link{
        text-decoration:none;
      }
      a.logo:visited{
        text-decoration:none;
      }
      a.logo:hover{
        text-decoration:none;
      }
      a.logo:active{
        text-decoration:none;
      }

      html body .main-header>nav.navbar{
        min-height: 60px;
        background-color:#4F5467;
      }
      
      .big-title{
        position:relative;
        width:100%;
        height:63px;
        margin-left: 230px;
        margin-bottom:25px;
        padding:15px 15px 10px 20px;
        background-color:#FFF;
      }

      html body .main-header{
        position:static;
      }
      .big-page-title{
        color: rgba(0, 0, 0, 0.5);
        font-weight: 600;
        margin-top: 6px;
        line-height: 22px;
        font-size: 18px;
      }


      /* Datatables style */
      .dataTables_length,.dataTables_info,.dataTables_filter{
        margin: 0px 0px 12px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 15px;
      }
      html body .table-striped>tbody>tr:nth-of-type(odd){
        background-color:#f7fafc !important;
      }
      html body table.dataTable thead .sorting:after, html body table.dataTable thead .sorting_asc:after, html body table.dataTable thead .sorting_desc:after{
        position:static;
        display: inline-block;
        opacity:1;
        font-size:10px;
        color:#999;
        margin-left: 5px;
      }
      td{
        outline:none;
        word-break:break-all
      }

      html body .sidebar-toggle .glyphicon{
        font-size:18px;
        color:#54667a;
      }
      html body .content{
        margin-top: 20px;
        padding:20px;
      }
      html body .my-project-page{
        padding:25px;
      }

      .bid-edit-text pre{
        font-family:"微软雅黑";
      }
      .controller-box{
        margin-bottom:15px;
      }

      html body table input{
        width:auto;
        max-width:100px;
      }

      html body table th,td{
        text-align:center;
      }

      @media screen and (max-width: 1366px){
        html body .content-info table.table > thead > tr > th{
          font-size:12px;
        }
        html body .content-info table.table > tbody > tr > td{
          font-size:12px;
        }
      }
    </style>
</head>
<body class="hold-transition {{ config('backpack.base.skin') }} sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{!! config('backpack.base.logo_mini') !!}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{!! config('backpack.base.logo_lg') !!}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" onclick="$('#top-bar-icon').toggleClass('glyphicon-chevron-left');$('#top-bar-icon').toggleClass('glyphicon-chevron-right');">
            <i style="color:#FFF;" class="glyphicon glyphicon-chevron-left" id="top-bar-icon"></i>
            <span class="sr-only">{{ trans('backpack::base.toggle_navigation') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          @include('backpack::inc.menu')
        </nav>
        <div class="big-title">
          <h4 class="big-page-title"></h4>
        </div>
        <script>
          function setPageTitle(data){
            $(".big-page-title").text(data);
          }
        </script>
      </header>

      <!-- =============================================== -->

      @include('backpack::inc.sidebar')

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      {{--<footer class="main-footer">
        @if (config('backpack.base.show_powered_by'))
            <div class="pull-right hidden-xs">
              {{ trans('backpack::base.powered_by') }} <a target="_blank" href="http://laravelbackpack.com">Laravel BackPack</a>
            </div>
        @endif
        {{ trans('backpack::base.handcrafted_by') }} <a target="_blank" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>.
      </footer>--}}
    </div>
    <!-- ./wrapper -->


    @yield('before_scripts')
      <script>

              $('#sendVerifySmsButton').sms({
          //laravel csrf token
          token       : "{{csrf_token()}}",
          //请求间隔时间
          interval    : 60,
          //请求参数
          requestData : {
              //手机号
              mobile : function () {
                  return $('input[name=mobile]').val();
              },
              //手机号的检测规则
              mobile_rule : 'mobile_required'
          },
          prefix : 'gw-sms'
      });
      </script>


    <!-- page script -->
    <script type="text/javascript">
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function() { Pace.restart(); });

        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        // Set active state on menu element
        
        // $("ul.sidebar-menu li a").each(function(){
        //   if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')))
        //   {
        //     $(this).parents('li').addClass('active');
        //   }
        // });

        //提交/steel_brands/create数据
        // $(document).on("click",".ladda-button", function(){
        //   var steelBrandsFormData = [];
        //   $(".box-body .form-control").each(function(i, element){
        //     steelBrandsFormData.push($(element).val());
        //   });

        //   $("#auto_spec_table tr").each(function(i, element){
        //     var tempArr = [];
        //     $(element).find("input").each(function(_i, _element){
        //       if($(_element).val()){
        //         tempArr.push($(_element).val());
        //       }
        //     });
        //     if(tempArr.length>0){
        //       steelBrandsFormData.push(tempArr);
        //     }
        //   });
        //   console.log(steelBrandsFormData)
        //   $.post("http://localhost/admin/steel_brands/store", JSON.stringify(steelBrandsFormData), function(data){
        //     console.log(data);
        //   });
        // })
    </script>

    <script>
      (function( factory ) {
        if ( typeof define === "function" && define.amd ) {
          define( ["jquery", "../jquery.validate"], factory );
        } else {
          factory( jQuery );
        }
      }(function( $ ) {
      //初始化中文提示
      $.extend($.validator.messages, {
        required: "这是必填字段",
        remote: "请修正此字段",
        email: "请输入有效的电子邮件地址",
        url: "请输入有效的网址",
        date: "请输入有效的日期",
        dateISO: "请输入有效的日期 (YYYY-MM-DD)",
        number: "请输入有效的数字",
        digits: "只能输入数字",
        creditcard: "请输入有效的信用卡号码",
        equalTo: "你的输入不相同",
        extension: "请输入有效的后缀",
        maxlength: $.validator.format("最多可以输入 {0} 个字符"),
        minlength: $.validator.format("最少要输入 {0} 个字符"),
        rangelength: $.validator.format("请输入长度在 {0} 到 {1} 之间的字符串"),
        range: $.validator.format("请输入范围在 {0} 到 {1} 之间的数值"),
        max: $.validator.format("请输入不大于 {0} 的数值"),
        min: $.validator.format("请输入不小于 {0} 的数值")
      });
      // 初始化自定义检验
      jQuery.validator.addMethod("pattern", function (value, element, params) {
        if (!params.test(value)) {
         return false;
        }
        return true;
      });

      }));
    </script>

    <script>
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();
        console.log($(".ladda-button"))
        var controlForm = $('#auto_spec_table');
        var currentEntry = $('table>tbody>tr:last');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);
        newEntry.find('input').val('');                                         //Remove the Data - as it is cloned from the above
        
        //Add the button  
        var rowCount = $('table >tbody:last >tr').length;
        if(rowCount > 1) {
            var removeButtons = document.getElementsByClassName('btn-remove');
            for(var i = 0; i < removeButtons.length; i++) {
                removeButtons.item(i).disabled = false;
            }
        }
         
    }).on('click', '.btn-remove', function(e) {
        $(this).parents('tr:first').remove();
                //Disable the Remove Button
        var rowCount = $('table >tbody:last >tr').length;
        if(rowCount == 1) {
            document.getElementsByClassName('btn-remove')[0].disabled = true;
        }

        e.preventDefault();
        return false;
    }).on('click', '.auto_products', function(e) {
        $('table').empty();
        var controlForm = $('#auto_spec_table');
        var currentEntry = $('table>tbody>tr:last').clone();
        $("#auto_spec_table tbody tr").remove();
        $("#auto_spec_table tbody").append(currentEntry);
        var pmvs=new Array();
        var fauto=[];
        var factory_code=$("select[name=factory_id]").find("option:selected").attr('code');
        var brand_code=$("input[name=code]").val();
        var brand_name=$("input[name=name]").val();
        console.log(brand_name);
        //自动生成的产品
        var productAttr = [];

        $('#spec_name a').each(function(){
            var pm=$(this).text();
            if(pm=='品名'){
              var pmid=$(this).attr('sid');
              $("input[sid="+pmid+"]:checked").each(function (index,obj) {
                     pmvs[index]=[$(this).attr('sname'),$(this).attr('sid'),$(this).attr('svid'),$(this).attr('code')];
                });
               
            }else{
            }
        });
         
        for (var i=0; i<pmvs.length; i++){
        console.log(pmvs);
          var h=0;
          var pmv=pmvs[i][0];
          var pmcode=pmvs[i][3];
          var auto=new Object();
          var fauto=new Array();
          auto['name']=pmv;
          auto['code']=pmcode;
            $('#spec_name a').each(function(){
                        var gg=$(this).text();
                        var ogg=pmv+'规格';
                        var ocz=pmv+'材质';
                   //规格
                        if(gg==ogg){
                        var gsid=$(this).attr("sid");
                        var ggs=new Array();
                       $("input[sid="+gsid+"]:checked").each(function (index,obj) {  
                         ggs[index]=[$(this).attr("sname"),$(this).attr("code"),$(this).attr("sid"),$(this).attr("svid")];
                          auto['gg']=ggs;
                        });
                            }
                    //材质                
                       if(gg==ocz){
                         var gsid=$(this).attr("sid");
                          var czs=new Array();
                          $("input[sid="+gsid+"]:checked").each(function (index,obj) {   
                          czs[index]=[$(this).attr("sname"),$(this).attr('code'),$(this).attr('sid'),$(this).attr('svid')];
                          auto['cz']=czs;
                                  });
                                }           
                      }) 

            //console.log(auto);
            if(auto.hasOwnProperty("cz") && auto.hasOwnProperty("gg")){
              //var plength=auto['cz'].length*auto['gg'].length;
             
                for(var k=0;k<auto['gg'].length;k++){
                  for(var j=0;j<auto['cz'].length;j++){
                    fauto[h]=[factory_code+brand_code+auto.code+auto['gg'][k][1]+auto['cz'][j][1],brand_name,auto.name,auto['gg'][k][0],auto['cz'][j][0],pmvs[i][1]+':'+pmvs[i][2]+';'+auto['gg'][k][2]+':'+auto['gg'][k][3]+';'+auto['cz'][j][2]+':'+auto['cz'][j][3]];
                    h++;
                  }
                }

                //console.log('++++++++++++++++++++');
                //console.log(JSON.stringify(fauto));
                //var tableData =JSON.stringify(fauto);
                //var tableData =fauto;
                //console.log(fauto);
                var controlForm = $('table');
                //获取自动生成的品牌产品
                productAttr.push(fauto)
                //获取html模板
                var htmlModel = creatHtmlModelForTable(fauto);
                //插入html模板
                
                $(controlForm).prepend(htmlModel);
              }
   
                            
            }
        e.preventDefault();
        console.log(productAttr);
    });

    function getpinming(){
      var pm=$('#spec_name li a').each();
      //aler(pm);
      return false;
    }

    function creatHtmlModelForTable(tableData){
    var model = "";
    for(var i=0; i<tableData.length; i++){
        model += 
            '<tr>'+
                '<td><input class="form-control" value="'+tableData[i][0]+'" name="productcode[]" type="text" placeholder="编号" /></td>'+
                '<td><input class="form-control" value="'+tableData[i][1]+'" name="brand[]" type="text" placeholder="品牌" /></td>'+
                '<td><input class="form-control" value="'+tableData[i][2]+'" name="cate_spec[]" type="text" placeholder="品名" /></td>'+
                '<td><input class="form-control" value="'+tableData[i][3]+'" name="size[]" type="text" placeholder="规格" /></td>'+
                '<td><input class="form-control" value="'+tableData[i][4]+'" name="material[]" type="text" placeholder="材质" /></td>'+
                '<td><input class="form-control" value="'+tableData[i][5]+'" name="specs[]" type="hidden"  /></td>'+
                '<td>'+'<button class="btn btn-danger btn-remove" type="button">'+
                        '<i class="glyphicon glyphicon-minus gs"></i>'+
                    '</button>'+
                '</td>'+
            '</tr>';
    }
    
    return model;
}


	</script>



  <script>
    $(document).ready(function(){

      $(document).on("click", ".project-add-btn", function(){
        var htmlModel = '<tr>' +
              '<td> </td>' +
              '<td>' +
                '<select name="">' +
                  '<option selected="" value="广钢">广钢</option>' +
                        '<option value="韶钢">韶钢</option>' +
                        '<option value="湘钢">湘钢</option>' +
                        '<option value="粤钢">粤钢</option>' +
                        '<option value="裕丰">裕丰</option>' +
                        '<option value="桂鑫">桂鑫</option>' +
                        '<option value="达味">达味</option>' +
                        '<option value="圣力">圣力</option>' +
                        '<option value="马钢">马钢</option>' +
                        '<option value="新抚顺">新抚顺</option>' +
                        '<option value="三闽">三闽</option>' +
                        '<option value="德源">德源</option>' +
                        '<option value="德润">德润</option>' +
                '</select>' +
              '</td>' +
              '<td>' +
                '<select name="">' +
                  '<option value="">上浮</option>' +
                  '<option value="">下浮</option>' +
                '</select>' +
                '<input type="text" placeholder="元/吨"/>' +
              '</td>' +
              '<td>' +
                '<input type="text" />' +
              '</td>' +
              '<td>' +
                '<button type="button" class="btn btn-danger project-dele-btn">删除</button>' +
              '</td>' +
            '</tr>';
        $("#project-table-2>tbody").append(htmlModel);
      });

      $(document).on("click", ".project-dele-btn", function(){
        $(this).parents("tr").remove();
      });
    });

    function showModel(data){
      if(data==0){
        $("#project-table").show();
        $("#project-table-2").hide();
      }else{
        $("#project-table").hide();
        $("#project-table-2").show();
      }
    }
  </script>

  <script>
    //register
    $(".box-head>div").click(function(){
      $(".box-head>div").removeClass("set-border-bottom");
      $(this).addClass("set-border-bottom");
      console.log($(this).text())
      if($(this).text() == "邮箱注册"){
        $(".register-form-email").show();
        $(".register-form-phone").hide();
      }else{
        $(".register-form-email").hide();
        $(".register-form-phone").show();
      }
    });

    $(".check-password, .check-password>i").on("mouseenter mouseout", function(event){
      if(event.type == "mouseenter"){
        $(".email-password").attr({"type" : "text"});
      }else{
        $(".email-password").attr({"type" : "password"});
      }
    });
  </script>

  <script type="text/javascript">
      //初始化bootrap多选下拉插件
      $(document).ready(function() {
          $('.more-select-2').multiselect({
              enableClickableOptGroups: true,
              enableCollapsibleOptGroups: true,
              enableFiltering: true,
              includeSelectAllOption: true,
              maxHeight: 800,
              dropUp: true
          });

          $('.more-select').multiselect({
              enableClickableOptGroups: false,
              enableCollapsibleOptGroups: false,
              enableFiltering: false,
              includeSelectAllOption: true,
              dropUp: false
          });
      });

      //
      function showTooltip(data, e, option){
        if(!option){
          var x = e.pageX-350;
          var y = e.pageY-170;
          $("#sub").css('left', x).css('top', y);
          $("#sub").show();
        }else{
          var x = e.pageX-850;
          var y = e.pageY-120;
          $("#sub-bid").css('left', x).css('top', y);
          $("#sub-bid").show();
        }
        e.stopPropagation();
      }

      function hideTooltip(data, e){
        $("#sub").hide();
        $("#sub-bid").hide();
        e.stopPropagation();
      }
  </script>

    @include('backpack::inc.alerts')

    @yield('after_scripts')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
