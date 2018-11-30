@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;链接管理
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
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增链接</a>
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
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>链接名称</th>
                        <th>URL</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v['link_id']}})" name="ord[]" value="{{$v['link_order']}}">
                        </td>
                        <td class="tc">{{$v['link_id']}}</td>
                        <td>
                            <a href="#">{{$v['link_name']}}</a>
                        </td>
                        <td>{{$v['link_url']}}</td>
                        <td>
                            <a href="{{url('admin/links/'.$v['link_id'].'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v['link_id']}})">删除</a>
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
        function changeOrder(obj,link_id){
            var link_order=$(obj).val();
           $.post("{{url('admin/links/changeOrder')}}",{'_token':"{{csrf_token()}}",'link_order':link_order,'link_id':link_id},function(data){
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
        function delArt(link_id) {
            layer.confirm('您确定要删除这篇文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/links/')}}/"+link_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
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