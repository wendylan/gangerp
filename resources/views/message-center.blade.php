@extends('backpack::layout')

@section("content")
<style>
    .main-warpper{
        width:100%;
        padding:25px;
        background-color:#FFF;
    }
    .box-title{
        margin: 0px 0px 12px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 16px;
    }
    ._box-title{
        margin: 0px 0px 50px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 16px;
        color:#8d9ea7;
    }

    .msg-main{
        width:100%;
        padding:25px;
    }
    ._msg-box{
        width:100%;
        padding:25px;
        margin-bottom:15px;
        border:solid 1px #DEDEDE;
    }
    ._msg-box .__title{
        font-size:16px;
        font-weight:700;
    }
    ._msg-box .__time{
        color:#a6afbb;
        font-size:14px;
        font-weight:100;
    }
    ._msg-box .__content{
        margin-top:10px;
        color:#54667a;
    }
    html body .msg-main div.active{
        background-color:blanchedalmond;
    }
    html body .msg-main div.unactive{
        background-color:#f7fafc !important;;
    }
</style>

<div class="main-warpper">
    <h3 class="box-title">消息列表</h3>
    
    <div class="msg-main">
            @for($i = 0; $i < count(Auth::user()->Notifications); $i++)
                @if(Auth::user()->Notifications[$i]['type']=='App\Notifications\bidderadd')
                    @include('vendor.notifications.bidderadd-center')
                @elseif(Auth::user()->Notifications[$i]['type']=='App\Notifications\whowin')
                    @include('vendor.notifications.whowin-center')
                @endif
                @break($i == 4)
            @endfor
         {{-- @for($i = 0; $i < count(Auth::user()->notifications); $i++)
            <div class="_msg-box">
                <div class="__title">{{ get_project_name_by_id(Auth::user()->notifications[$i]['data']['bid']['pid']) }}项目 <span class="__time">{{Auth::user()->notifications[$i]['created_at']}}</span></div>
                <div class="__content">{{ get_company_name_by_uid(Auth::user()->notifications[$i]['data']['who']) }} 报名了你的招标项目</div>
            </div>
        @endfor --}}
    </div>
    <div style="float:right;padding-right:25px;">
        <ul class="pagination">
            <li class="paginate_button previous disabled" id="table_id_example_previous"><a href="#" aria-controls="table_id_example" data-dt-idx="0" tabindex="0">前一页</a></li>
            <li class="paginate_button active"><a href="#">1</a></li>
            <li class="paginate_button"><a href="#">2</a></li>
            <li class="paginate_button"><a href="#">3</a></li>
            <li class="paginate_button next" id="table_id_example_next"><a href="#" aria-controls="table_id_example" data-dt-idx="4" tabindex="0">下一页</a></li>
        </ul>
    </div>
    <div style="clear:both;"></div>

</div>

<script>
    setPageTitle("消息中心");
</script>
@endsection
