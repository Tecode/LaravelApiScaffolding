@extends('master/content')
@section('content')
    <body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/link')}}">全部链接</a> &raquo; 编辑链接
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    {{--<div class="result_wrap">--}}
        {{--<div class="result_title">--}}
            {{--<h3>快捷操作</h3>--}}
        {{--</div>--}}
        {{--<div class="result_content">--}}
            {{--<div class="short_wrap">--}}
                {{--<a href="{{url('admin/linkgory/create')}}"><i class="fa fa-plus"></i>添加分类</a>--}}
                {{--<a href="{{url('admin/linkgory')}}"><i class="fa fa-recycle"></i>全部分类</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="result_wrap">
        <div class="result_title">
        <!--结果集标题与导航组件 结束-->
            @if(count($errors)>0)
                @if(is_object($errors))
                    @foreach ($errors->all() as $error)
                        <div class="mark">
                            <li>{{ $error }}</li>
                        </div>
                    @endforeach
                @else
                    <div class="mark">
                        <li>{{ $errors }}</li>
                    </div>
                @endif
            @endif
        </div>
        <form action="{{url('admin/link/'.$data->link_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put" />
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>链接名称：</th>
                    <td>
                        <input type="text" name="link_name" value="{{$data->link_name}}">
                    </td>
                </tr>
                <tr>
                    <th>连接描述：</th>
                    <td>
                        <input type="text" class="lg" name="link_tittle" value="{{$data->link_tittle}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>链接地址：</th>
                    <td>
                        <textarea class="lg" name="link_url">{{$data->link_url}}</textarea>
                        <p>描述可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="link_order" value="{{$data->link_order}}">
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

    </body>
@endsection