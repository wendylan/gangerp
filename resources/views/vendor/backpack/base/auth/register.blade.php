@extends('backpack::layout')

@section('content')
    <style>
        .box-head{
            margin:30px 0px 30px 0px;
            padding:0px 50px 0px 50px;
        }
        .box-head>div{
            float:left;
            width:50%;
            text-align:center;
            color:#337ab7;
            border-bottom:solid 1px #DEDEDE;
            padding:10px 0px 10px 0px;
            font-size:18px;
            cursor:pointer;
        }
        .box-head i{
            margin: 0px 10px;
        }
        html body .set-border-bottom{
            border-bottom:solid 1px #337ab7;
        }
        .register-form-email{
            display:none;
        }
        #register-page label{
            font-size:14px;
            font-weight:100;
        }
    </style>

    <div class="row" id="register-page">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">
                <div class="box-head">
                    <!-- <div class="box-title">{{ trans('backpack::base.register') }}</div> -->
                    <div class="set-border-bottom"><i class="glyphicon glyphicon-phone"></i>手机注册</div>
                    <div><i class="glyphicon glyphicon-envelope"></i>邮箱注册</div>
                    <p style="clear:both;"></p>
                </div>
                <div class="box-body">
                    <form class="form-horizontal register-form-email" role="form" method="POST" action="{{ url('admin/register') }}">
                        {!! csrf_field() !!}

                      <!--   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('backpack::base.name') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{ trans('backpack::base.email_address') }}</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <!-- <label class="col-md-4 control-label">{{ trans('backpack::base.password') }}</label> -->
                            <label class="col-md-4 control-label">设置密码</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="password" class="form-control email-password" name="password" />
                                    <div class="input-group-addon check-password"><i class="glyphicon glyphicon-eye-open"></i></div>
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}"> -->
                            <!-- <label class="col-md-4 control-label">{{ trans('backpack::base.confirm_password') }}</label> -->
                            <!-- <label class="col-md-4 control-label">重复密码</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-btn fa-user"></i> {{ trans('backpack::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal register-form-phone" role="form" method="POST" action="{{ url('admin/register') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">手机号码</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">设置密码</label>
                            <div class="col-md-6">
                                <!-- <input type="email" class="form-control" name="email" value="{{ old('email') }}"> -->
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control email-password" value="{{ old('email') }}">
                                    <div class="input-group-addon check-password"><i class="glyphicon glyphicon-eye-open"></i></div>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">手机验证</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                  <input name="verifycode" class="form-control" placeholder="输入验证码">
                                  <span class="input-group-btn">
                                    <button id="sendVerifySmsButton" class="btn btn-default" type="button">获取验证码</button>
                                  </span>
                                </div><!-- /input-group -->
                              </div><!-- /.col-lg-6 -->
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-btn fa-user"></i> {{ trans('backpack::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


