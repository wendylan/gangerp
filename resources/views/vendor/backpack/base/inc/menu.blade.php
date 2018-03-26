<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>
<style>
    .navbar-custom-menu{
      height:60px;
    }
    .navbar-custom-menu a{
      text-decoration:none;
      color:#FFF;
    }
    .navbar-custom-menu a:link{
      text-decoration:none;
    }
    .navbar-custom-menu a:visited{
      text-decoration:none;
    }
    .navbar-custom-menu a:hover{
      text-decoration:none;
    }
    .navbar-custom-menu a:active{
      text-decoration:none;
    }
    .navbar-custom-menu ul.navbar-nav,li,a{
          /*height: 100%;*/
          height: auto;
    }
    .navbar-custom-menu ul.navbar-nav>li>a,i{
      line-height:2;
    }

    a.sidebar-toggle{
      height:60px;
    }
    .msg-box{
      display:none;
      position:absolute;
      width:300px;
      height:auto;
      margin-left:-256px;
      background-color: #FFF;
      border:1px solid rgba(120, 130, 140, 0.13);
      border-top:none;
    }
    ._message{
      width:100%;
      padding:5px;
      padding-left:50px;
      height:auto;
      border:1px solid rgba(120, 130, 140, 0.13);
      border-top:none;
      line-height:1.8;
    }
    ._message:hover{
      background-color:#f7fafc;
      cursor:pointer;
    }
    ._message p{
      display:block;
      margin:0px;
    }
    ._message>._icon-box{
      float:left;
      height:100%;
      margin-left:-30px;
      font-size:20px;
    }
    ._message>._icon-box i{
      vertical-align:middle;   
      display:table-cell;
      height:75px;
      color:#AAA;
    }
    ._message ._title{
      font-weight:700;
    }
    ._message ._content{
      color:#54667a;
    }
    ._message ._time{
      color:#8d9ea7;
    }
    .unread-msg{
      width:100%;
      height:50px;
      border:1px solid rgba(120, 130, 140, 0.13);
      border-top:none;
      font-size:16px;
      font-weight:700;
      text-align:center;
      color:#54667a;
      line-height:3;
    }

    html body .click-background{
      background-color: rgba(255, 255, 255, 0.2);
    }
    html body .nav>li>a:hover, .nav>li>a:active, .nav>li>a:focus{
      background:none;
      color:#FFF;
      background-color: rgba(255, 255, 255, 0.2);
    }
    .point{
      position: absolute;
      top: 35px;
      right: 10px;
      height: 25px;
      width: 25px;
      display:block;
      width:5px;
      height:5px;
      border-radius:100px;
      background-color: #fb9678;
    }
    .heartbit{
      position: absolute;
      top: 25px;
      right: 0px;
      height: 25px;
      width: 25px;
      z-index: 10;
      border: 5px solid #fb9678;
      border-radius: 70px;
      -moz-animation: heartbit 1s ease-out;
      -moz-animation-iteration-count: infinite;
      -o-animation: heartbit 1s ease-out;
      -o-animation-iteration-count: infinite;
      -webkit-animation: heartbit 1s ease-out;
      -webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
    }
    @keyframes heartbit
    {
      0% {
          -webkit-transform: scale(0);
          opacity: 0.0;
      }
      25% {
          -webkit-transform: scale(0.1);
          opacity: 0.1;
      }
      50% {
          -webkit-transform: scale(0.5);
          opacity: 0.3;
      }
      75% {
          -webkit-transform: scale(0.8);
          opacity: 0.5;
      }
      100% {
          -webkit-transform: scale(1);
          opacity: 0.0;
      }
    }
    html body .main-header .sidebar-toggle{
      padding:20px 20px;
    }

    ._message>._icon-box i.color-blue{
      color:#428bca;
    }
    ._message>._icon-box i.color-green{
      color:#5cb85c;
    }
</style>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- ========================================================= -->
      <!-- ========== Top menu right items (ordered left) ========== -->
      <!-- ========================================================= -->

      <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        @if (Auth::guest())
            <li><a href="{{ url('admin/login') }}">{{ trans('backpack::base.login') }}</a></li>
            @if (config('backpack.base.registration_open'))
            <li><a href="{{ url('admin/register') }}">{{ trans('backpack::base.register') }}</a></li>
            @endif
        @else
            <li class="navbar-tool">
              <a href="#" onclick="showMsgBox(this);"><i class="glyphicon glyphicon-envelope" style="margin-top: 8px;"></i>
              @if(!Auth::user()->unreadNotifications->isEmpty())
                <span class="point"></span>
                <span class="heartbit"></span>
              @endif
              </a>
              <div class="msg-box">
                
                @for($i = 0; $i < count(Auth::user()->unreadNotifications); $i++)
                  @if(Auth::user()->unreadNotifications[$i]['type']=='App\Notifications\bidderadd')
                    @include('vendor.notifications.bidderadd-menu')
                  @elseif(Auth::user()->unreadNotifications[$i]['type']=='App\Notifications\whowin')
                    @include('vendor.notifications.whowin-menu')
                  @endif
                  @break($i == 4)
                @endfor
                <a href="/message" target="_blank">
                <div class="unread-msg">你还有<span style="color:rgb(251, 150, 120);"> {{count(Auth::user()->unreadNotifications)}} </span>条未读消息</div></a>
              </div>
            </li>
            <li>            
            <a href="#">
            @if(!empty(Auth::user()->name))
                {{ Auth::user()->name }} 
            @elseif(!empty(Auth::user()->mobile))
                {{ Auth::user()->name }} 
            @else
                {{ Auth::user()->email }} 
            @endif
            </a>
             </li>
            <li><a href="{{ url('admin/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
        @endif

       <!-- ========== End of top menu right items ========== -->
    </ul>
</div>

<script>
  
  function showMsgBox(element){
    if( $('.msg-box').css('display') == 'none' ){
      $('.msg-box').show();
      $(element).addClass("click-background");
    }else{
      $('.msg-box').hide()
      $(element).removeClass("click-background");
    }
  }
</script>
