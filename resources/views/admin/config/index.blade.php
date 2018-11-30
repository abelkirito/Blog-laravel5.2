@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo;配置管理
    </div>
    <!--面包屑导航 结束-->
@if(session('msg'))
    <div class="result_title">
    <div class="mark">
    {{session('msg')}}
        </div>
    </div>
    @endif
    <!--结果页快捷搜索框 开始-->
 <div class="search_wrap">
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/config/changeContent')}}" method="post">
        {{csrf_field()}}
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置项</a>
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
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>

                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v['conf_id']}})" name="ord[]" value="{{$v['conf_order']}}">
                        </td>
                        <td class="tc">{{$v['conf_id']}}</td>
                        <td>
                            <a href="#">{{$v['conf_title']}}</a>
                        </td>
                        <td>{{$v['conf_name']}}</td>
                        <input type="hidden" name="conf_id[]" value="{{$v['conf_id']}}">
                        <td>{!!$v['_html']!!}</td>
                        <td>
                            <a href="{{url('admin/config/'.$v['conf_id'].'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v['conf_id']}})">删除</a>
                        </td>
                    </tr>

                    @endforeach
                </table>
                <div class="btn_group">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>

                <div class="page_list">
                    {{$page->links()}}
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
        function changeOrder(obj,conf_id){
            var conf_order=$(obj).val();
           $.post("{{url('admin/config/changeOrder')}}",{'_token':"{{csrf_token()}}",'conf_order':conf_order,'conf_id':conf_id},function(data){
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
        function delArt(conf_id) {
            layer.confirm('您确定要删除该配置项？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/config/')}}/"+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
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