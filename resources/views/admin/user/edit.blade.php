@extends('admin.layout.index')

@section('content')
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 表单
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                <div class="portlet-input input-small input-inline">
                    <div class="input-icon right">
                        <i class="am-icon-search"></i>
                        <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
                </div>
            </div>


        </div>
        <div class="tpl-block ">

            <div class="am-g tpl-amazeui-form">

                <div class="am-u-sm-12 am-u-md-9">
                    <form action="/admin/user/update" method="post" class="am-form am-form-horizontal">
                        <input type="hidden" name="id" value="{{$user->id}}"/>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">用户名</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" placeholder="用户名" name="username" value="{{$user->username}}">
                                <small>{{$errors->first('username')}}</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-email" class="am-u-sm-3 am-form-label">密码</label>
                            <div class="am-u-sm-9">
                                <input type="password"  placeholder="输入你的密码" name="password" value="">
                                <small>{{$errors->first('password')}}</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">确认密码</label>
                            <div class="am-u-sm-9">
                                <input type="password" id="user-phone" placeholder="输入确认密码" name="repassword" value="">
                                <small>{{$errors->first('repassword')}}</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-QQ" class="am-u-sm-3 am-form-label">邮箱</label>
                            <div class="am-u-sm-9">
                                <input type="email" id="user-email" placeholder="输入你的邮箱" name="email" value="{{$user->email}}">
                                <small>{{$errors->first('email')}}</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                {{csrf_field()}}
                                <button type="submit" class="am-btn am-btn-primary">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection