                <div class="_message">
                  <div class="_icon-box"><i class="glyphicon glyphicon-star color-green"></i></div>
                  <div>
                    <p class="_title">{{get_project_name_by_id(Auth::user()->unreadNotifications[$i]['data']['bid']['pid'])}}项目</p>
                    <a href="/tenderee/my/{{Auth::user()->unreadNotifications[$i]['data']['bid']['id']}}">
                    <p class="_content">恭喜你中标</p>
                    <p class="_time">{{Auth::user()->unreadNotifications[$i]['created_at']}}</p>
                  </a>
                  </div>
                  
                  <div style="clear:both;"></div>
                </div>