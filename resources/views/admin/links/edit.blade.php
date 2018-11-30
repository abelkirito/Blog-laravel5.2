@extends('layouts.admin')
    @section('content')
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 链接管理
        </div>
        <!--面包屑导航 结束-->

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部文章</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
        </div>
        <!--结果集标题与导航组件 结束-->

        <div class="result_wrap">
            <div class="result_title">
                @if(count($errors)>0)
                    <div class="mark">
                        {{$errors->first()}}
                    </div>
                @endif
                @if(session('result')['status']==1)

                            <script>layer.msg("{{session('result')['msg']}}",{icon:6});</script>

                    @endif
                @if(session('result')['status']==2)
                        <script>layer.msg("{{session('result')['msg']}}",{icon:5});</script>
                    @endif
            </div>

            <form action="{{url('admin/links/'.$field[0]['link_id'])}}" method="post">
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}
                <table class="add_tab">
                    <tbody>

                    <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text" name="link_name" value="{{$field[0]['link_name']}}">

                        </td>
                    </tr>
                    <tr>
                        <th>链接标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title" value="{{$field[0]['link_title']}}">

                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <th>URL：</th>
                        <td>
                            <textarea name="link_url" >{{$field[0]['link_url']}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="link_order" value="{{$field[0]['link_order']}}">

                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>

    @endsection
