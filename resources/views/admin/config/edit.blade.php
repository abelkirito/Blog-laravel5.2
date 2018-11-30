@extends('layouts.admin')
    @section('content')
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="admin/index">首页</a> &raquo; 配置管理
        </div>
        <!--面包屑导航 结束-->

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>修改配置</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增导航</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部导航</a>
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

            <form action="{{url('admin/config/'.$field[0]['conf_id'])}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="put">
                <table class="add_tab">
                    <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value="{{$field[0]['conf_title']}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>配置项名称：</th>
                        <td>
                            <input type="text" name="conf_name" value="{{$field[0]['conf_name']}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="input" @if($field[0]['field_type']=="input") checked="" @endif onclick="showTr()">input &nbsp&nbsp
                            <input type="radio" name="field_type" value="textarea" @if($field[0]['field_type']=="textarea") checked="" @endif onclick="showTr()">textarea &nbsp&nbsp
                            <input type="radio" name="field_type" value="radio" @if($field[0]['field_type']=="radio") checked="" @endif onclick="showTr()">radio &nbsp
                            <span><i class="fa fa-exclamation-circle yellow"></i>类型：input textarea radio</span>
                        </td>
                    </tr>
                    <tr class="field_value">
                        <th><i class="require">*</i>类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value" value="{{$field[0]['field_value']}}">
                            <p><i class="fa fa-exclamation-circle yellow"></i>仅在radio才需要配置，格式 1|开启,0|关闭</p>

                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="{{$field[0]['conf_order']}}">

                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>说明：</th>
                        <td>
                            <textarea name="conf_tips">{{$field[0]['conf_tips']}}</textarea>

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
        <script>
            showTr();
            function showTr(){
                var type=$('input[name=field_type]:checked').val();
                var tag=$(".field_value");
                  if(type=="radio"){
                      tag.show();
                  }else{
                      tag.hide();
                  }
            }
        </script>
    @endsection
