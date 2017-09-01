<div class="_message">
    <div class="_icon-box"><i class="glyphicon glyphicon-star color-blue"></i></div>
    <div>
    <p class="_title">{{get_project_name_by_id(Auth::user()->Notifications[$i]['data']['bid']['pid'])}}项目</p>
    {{-- <a href="/tenderee/my/{{Auth::user()->Notifications[$i]['data']['bid']['id']}}"> --}}
    <p class="_content">尊敬的用户，【{{get_project_name_by_id(Auth::user()->Notifications[$i]['data']['bid']['pid'])}}项目】钢筋招标已开标，恭喜贵司成功中标！</p>
    <p class="_time">{{Auth::user()->Notifications[$i]['created_at']}}</p>
    {{-- </a> --}}
    </div>
    
    <div style="clear:both;"></div>
</div>