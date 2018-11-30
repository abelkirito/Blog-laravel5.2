@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;自定义导航管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
 <div class="search_wrap">
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        {{csrf_field()}}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增导航</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        @if(session('result')['status']==1)

            <script>layer.msg("{{session('result')['msg']}}",{icon:6});</script>

        @endif
        @if(session('result')['status']==2)
            <script>layer.msg("{{session('result')['msg']}}",{icon:5});</script>
            @endif
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>URL</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>

                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v['nav_id']}})" name="ord[]" value="{{$v['nav_order']}}">
                        </td>
                        <td class="tc">{{$v['nav_id']}}</td>
                        <td>
                            <a href="#">{{$v['nav_name']}}</a>
                        </td>
                        <td>{{$v['nav_alias']}}</td>
                        <td>{{$v['nav_url']}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$v['nav_id'].'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v['nav_id']}})">删除</a>
                        </td>
                    </tr>

                    @endforeach
                </table>


                <div class="page_list">
                    {{$data->links()}}
                </div>
                <style>
                    .result_content ul li span{
                        font-size: 15px;
                        padding: 6px 12px;
                    }
                </style>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
        function changeOrder(obj,nav_id){
            var nav_order=$(obj).val();
           $.post("{{url('admin/navs/changeOrder')}}",{'_token':"{{csrf_token()}}",'nav_order':nav_order,'nav_id':nav_id},function(data){
                  if(data.status==0){
                      layer.msg(data.msg,{icon:6});
                      setTimeout("location.reload()",2000);
                  }else if(data.status==1){
                      layer.msg(data.msg,{icon:5});
                      setTimeout("location.reload()",2000);
                  }
           });
        }
    </script>
    <script>
        //删除分类
        function delArt(nav_id) {
            layer.confirm('您确定要删除这篇文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/navs/')}}/"+nav_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status==0){
                        layer.msg(data.msg, {icon: 6});
                        setTimeout("location.reload()",2000);
                    }else{
                        layer.msg(data.msg, {icon: 5});
                        setTimeout("location.reload()",2000);
                    }
                });
//            layer.msg('的确很重要', {icon: 1});
            }, function(){

            });
        }
    </script>
@endsection