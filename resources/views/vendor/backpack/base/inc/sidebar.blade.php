@if (Auth::check())
    <style>

      ul.sidebar-menu a{
        text-decoration:none;
        color:#54667a;
      }
      ul.sidebar-menu a:link{
        text-decoration:none;
      }
      ul.sidebar-menu a:visited{
        text-decoration:none;
      }
      ul.sidebar-menu a:hover{
        text-decoration:none;
      }
      ul.sidebar-menu a:active{
        text-decoration:none;
      }

      .main-sidebar{
        box-shadow:1px 0px 20px rgba(0, 0, 0, 0.08);
      }
      html body ul.sidebar-menu li.header{
        padding-left:  0px;
        color:#a6afbb;
        font-size:18px;
      }
      html body .sidebar-menu>li>a{
        padding:15px;
      }
      html body .sidebar-menu>li>a:hover{
        background-color:rgba(0, 0, 0, 0.03);
      }
      html body ul.sidebar-menu .treeview-menu>li>a{
        padding:10px 15px 10px 25px;
      }
      html body ul.sidebar-menu .treeview-menu>li>a:hover{
        color:#fb9678;
      }
      html body .user-panel{
        height:100px;
      }

      .user-panel>.image>img{
        width: 55px;
        max-width: 100%;
        height: 55px;
      }

      html body .sidebar-menu .glyphicon{
        font-size:18px;
        color:#54667a;
      }
    </style>
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="image">
            <img style="display:block;margin:auto;" src="http://img32.mtime.cn/up/2013/01/07/200438.53477793_500.jpg" class="img-circle" alt="User Image">
          </div>
          <div style="clear:both;"></div>
          <div class="info">
            <p style="color:#54667a;line-height:2;">{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i>{{-- Auth::user()->mobile --}}</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
        @role('bidder')
          <li class="header">---  投标方</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          {{--<li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>--}}
          <li class="treeview slider-title-1">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span><i class="glyphicon glyphicon-book"></i> 投标信息</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('bidder/my') }}"><i class="fa fa-newspaper-o"></i> <span>我的投标</span></a></li>
              <li><a href="{{ url('bidder/allbids') }}"><i class="fa fa-list"></i> <span>招标公告</span></a></li>
            </ul>
          </li>
          @endrole
          @role('tenderee')
          <li class="header">---  招标方</li>
          <li><a href="{{ url('tenderee/my') }}"><i class="fa fa-file-o"></i> <span><i class="glyphicon glyphicon-bullhorn"></i> 我的招标</span></a></li>
          <li><a href="{{ url('tenderee/projects') }}"><i class="fa fa-file-o"></i> <span><i class="glyphicon glyphicon-briefcase"></i> 我的项目</span></a></li>
          <li class="treeview slider-title-2">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span><i class="glyphicon glyphicon-paperclip"></i> 新建招标</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('bids/create/batch') }}"><i class="fa fa-newspaper-o"></i> <span>批次招标</span></a></li>
              <li><a href="{{ url('bids/create/project') }}"><i class="fa fa-list"></i> <span>项目招标</span></a></li>
            </ul>
          </li>
          @endrole
          @role('前台数据管理员')
           <li class="header">---  DATA模块</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li class="treeview slider-title-1">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span><i class="glyphicon glyphicon-book"></i> 数据页面</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('dataManage') }}"><i class="fa fa-newspaper-o"></i> <span>数据管理</span></a></li>
              <li><a href="{{ url('historyData') }}"><i class="fa fa-newspaper-o"></i> <span>历史数据</span></a></li>
              <li><a href="{{ url('sourceRecommend') }}"><i class="fa fa-newspaper-o"></i> <span>资源推荐</span></a></li>
              <li><a href="{{ url('priceInfo') }}"><i class="fa fa-newspaper-o"></i> <span>钢材信息</span></a></li>
              <li><a href="{{ url('freight') }}"><i class="fa fa-newspaper-o"></i> <span>运费信息</span></a></li>
            </ul>
          </li>
          @endrole
          {{-- <li class="treeview slider-title-3">
              <a href="#"><i class="fa fa-newspaper-o"></i> <span>News</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('admin/article') }}"><i class="fa fa-newspaper-o"></i> <span>Articles</span></a></li>
                <li><a href="{{ url('admin/category') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>
                <li><a href="{{ url('admin/tag') }}"><i class="fa fa-tag"></i> <span>Tags</span></a></li>
              </ul>
          </li>

          <li><a href="{{ url('admin/page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
          <li><a href="{{ url('admin/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li> --}}





           @role('admin')
          <li class="header">---  {{ trans('backpack::base.user') }}</li>
          <!-- Users, Roles Permissions -->
          <li class="treeview slider-title-4">
            <a href="#"><i class="fa fa-group"></i> <span><i class="glyphicon glyphicon-user"></i> 用户管理</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>用户</span></a></li>
              <li><a href="{{ url('admin/review') }}"><i class="fa fa-group"></i> <span>审核</span></a></li>
              <li><a href="{{ url('admin/role') }}"><i class="fa fa-group"></i> <span>角色</span></a></li>
              <li><a href="{{ url('admin/permission') }}"><i class="fa fa-key"></i> <span>权限</span></a></li>
            </ul>
          </li>

          {{-- 产品菜单 --}}
          <li class="header">---  产品</li>
          <!-- Users, Roles Permissions -->
          <li class="treeview slider-title-5">
            <a href="#"><i class="fa fa-group"></i> <span><i class="glyphicon glyphicon-gift"></i> 产品管理</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/product') }}"><i class="fa fa-user"></i> <span>全部产品</span></a></li>
              <li><a href="{{ url('admin/steelspec') }}"><i class="fa fa-group"></i> <span>产品属性</span></a></li>
              <li><a href="{{ url('admin/steel_brands') }}"><i class="fa fa-key"></i> <span>钢筋品牌</span></a></li>
              <li><a href="{{ url('admin/steel_factory') }}"><i class="fa fa-key"></i> <span>钢厂</span></a></li>
            </ul>
          </li>

          {{-- <li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li> --}}

          {{-- DATA模块 --}}
         <li class="header">---  DATA模块</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li class="treeview slider-title-1">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span><i class="glyphicon glyphicon-book"></i> 数据页面</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('dataManage') }}"><i class="fa fa-newspaper-o"></i> <span>数据管理</span></a></li>
              <li><a href="{{ url('historyData') }}"><i class="fa fa-newspaper-o"></i> <span>历史数据</span></a></li>
              <li><a href="{{ url('sourceRecommend') }}"><i class="fa fa-newspaper-o"></i> <span>资源推荐</span></a></li>
              <!-- <li><a href="{{ url('priceInfo') }}"><i class="fa fa-newspaper-o"></i> <span>钢材信息</span></a></li> -->
              <li><a href="{{ url('freight') }}"><i class="fa fa-newspaper-o"></i> <span>运费信息</span></a></li>
            </ul>
          </li>


        <li class="header">---  {{ trans('backpack::base.administration') }}</li>
        <li class="treeview slider-title-6">
              <a href="#"><i class="fa fa-cogs"></i> <span><i class="glyphicon glyphicon-pencil"></i> 高级选项</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('admin/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
                <li><a href="{{ url('admin/backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a></li>
                <li><a href="{{ url('admin/log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
                <li><a href="{{ url('admin/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
              </ul>
          </li>
          @endrole
          @role('后台数据录入')
          <li class="header">---  产品</li>
          <!-- Users, Roles Permissions -->
          <li class="treeview slider-title-5">
            <a href="#"><i class="fa fa-group"></i> <span><i class="glyphicon glyphicon-gift"></i> 产品管理</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/product') }}"><i class="fa fa-user"></i> <span>全部产品</span></a></li>
              <li><a href="{{ url('admin/steelspec') }}"><i class="fa fa-group"></i> <span>产品属性</span></a></li>
              <li><a href="{{ url('admin/steel_brands') }}"><i class="fa fa-key"></i> <span>钢筋品牌</span></a></li>
              <li><a href="{{ url('admin/steel_factory') }}"><i class="fa fa-key"></i> <span>钢厂</span></a></li>
            </ul>
          </li>
          @endrole
          <li class="header">---  用户设置</li>
          <!-- Users, Roles Permissions -->
          <li class="treeview slider-title-7">
            <a href="#"><i class="fa fa-group"></i> <span><i class="glyphicon glyphicon-cog"></i> 个人中心</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('center/accounts') }}"><i class="fa fa-user"></i> <span>子账号管理</span></a></li>
              <li><a href="{{ url('center/company-info') }}"><i class="fa fa-group"></i> <span>企业信息</span></a></li>
              <li><a href="{{ url('center/account-safe') }}"><i class="fa fa-key"></i> <span>修改密码</span></a></li>
            </ul>
          </li>
        </ul>

        <script>
            $(document).ready(function(){
                LeftBarActive(window.location.href);
            });

          function setLeftBar(name){
            $(".treeview>a span").each(function(){
              if($(this).text().replace(/\s/,"") == name){
                $(this).parents(".treeview").addClass("active");
              }
            });
          }

          function leftBarOpen(){
            $(".treeview").addClass("active");
          }

          function setOptionFocus(name){
            $("li").each(function(){
              if($(this).text().replace(/\s/g,"") == name){
                $(this).children("a").css("color", "#fb9678");
              }
            });
          }

          function LeftBarActive(name){
              $(".treeview a").each(function(){
                if($(this).attr('href') == name){
                  $(this).parents(".treeview").addClass("active");
                  $(this).css("color", "#fb9678");
                }

              });
          }
        </script>

      </section>
      <!-- /.sidebar -->
    </aside>
@endif
