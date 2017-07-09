@extends('admin.layout.index')

@section('css')
.pagination {
    position: relative;
    padding-left: 0;
    margin: 1.5rem 0;
    list-style: none;
    color: #999;
    text-align: left;
}
.pagination li{display: inline-block;}
.pagination>li>a, .pagination>li>span {
position: relative;
display: block;
padding: .5em 1em;
text-decoration: none;
line-height: 1.2;
background-color: #fff;
border: 1px solid #ddd;
border-radius: 0;
margin-bottom: 5px;
margin-right: 5px;
}
.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
z-index: 2;
color: #fff;
background-color: #0e90d2;
border-color: #0e90d2;
cursor: default;
}
.pagination .disabled span, .pagination li span,.pagination .disabled a, .pagination li a {
color: #23abf0;
border-radius: 3px;
padding: 6px 12px;
}
@endsection
@section('content')
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 列表
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                <div class="portlet-input input-small input-inline">
                    <div class="input-icon right">
                        <i class="am-icon-search"></i>
                        <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
                </div>
            </div>
        </div>
        <div class="tpl-block">
            <form action="/admin/user/index" method="get"/>
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button onclick="add()" type="button" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</button>
                            <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-save"></span> 保存</button>
                            <button type="button" class="am-btn am-btn-default am-btn-warning"><span class="am-icon-archive"></span> 审核</button>
                            <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <select data-am-selected="{btnSize: 'sm'}" style="display: none;" name="status">
                            <option value="">--请选择--</option>
                            <option value="0">未激活</option>
                            <option value="1">已激活</option>
                        </select>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field" name="key" value="@if(isset($_GET['key'])){{$_GET['key']}}@endif">
                        <span class="am-input-group-btn">
                            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-check"><input type="checkbox" class="tpl-table-fz-check"></th>
                                <th class="table-id">ID</th>
                                <th class="table-title">用户名</th>
                                <th class="table-author am-hide-sm-only">邮箱</th>
                                <th class="table-author am-hide-sm-only">状态</th>
                                <th class="table-date am-hide-sm-only">创建日期</th>
                                <th class="table-date am-hide-sm-only">修改日期</th>
                                <th class="table-set">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $v)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{$v->id}}</td>
                                    <td><a href="#">{{$v->username}}</a></td>
                                    <td>{{$v->email}}</td>
                                    <td>{{$v->status}}</td>
                                    <td class="am-hide-sm-only">{{date('Y年m月d日 H:i:s', $v->created_at)}}</td>
                                    <td class="am-hide-sm-only">{{date('Y年m月d日 H:i:s', $v->updated_at)}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button type="button" onclick="edit({{$v->id}});" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                                <button type="button" class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span class="am-icon-copy"></span> 复制</button>
                                                <button type="button" onclick="del({{$v->id}});" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="am-cf">
                            <div class="am-fr">
                                {!! $users->render() !!}
                            </div>
                        </div>
                        <hr>

                    </form>
                </div>

            </div>
        </div>
        <div class="tpl-alert"></div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    /****** 修改 ******/
    function edit(id){
        location.href = "/admin/user/edit?id="+id;
    }
    /***** 添加 *****/
    function add(){
        location.href = "/admin/user/add"
    }
</script>
@endsection