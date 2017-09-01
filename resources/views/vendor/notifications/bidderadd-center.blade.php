<div class="_msg-box">
    <div class="__title">{{ get_project_name_by_id(Auth::user()->notifications[$i]['data']['bid']['pid']) }}项目 <span class="__time">{{Auth::user()->notifications[$i]['created_at']}}</span></div>
    <div class="__content">{{ get_company_name_by_uid(Auth::user()->notifications[$i]['data']['who']) }} 报名了你的招标项目</div>
</div>