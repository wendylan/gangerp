                <div class="_message">
                  <div class="_icon-box"><i class="glyphicon glyphicon-star"></i></div>
                  <div>
                    <p class="_title">{{get_project_name_by_id(Auth::user()->unreadNotifications[$i]['data']['bid']['pid'])}}项目</p>
                    <a href="/tenderee/my/{{Auth::user()->unreadNotifications[$i]['data']['bid']['id']}}">
                    <p class="_content">{{get_company_name_by_uid(Auth::user()->unreadNotifications[$i]['data']['who'])}}参加了投标</p>
                    <p class="_time">{{Auth::user()->unreadNotifications[$i]['created_at']}}</p>
                  </a>
                  </div>
                  
                  <div style="clear:both;"></div>
                </div>