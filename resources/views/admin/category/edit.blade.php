@extends('master/content')
@section('content')
    <body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/category')}}">全部分类</a> &raquo; 编辑分类
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
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
        <form action="{{url('admin/category/'.$filed->cate_id)}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put" />
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>分类：</th>
                    <td>
                        <select name="cate_pid">
                            <option value="0">==顶级文章==</option>
                            @foreach($data as $v)
                                <option value="{{$v->cate_id}}"
                                @if($v->cate_id == $filed->cate_pid)
                                    selected
                                    @endif
                                >{{$v->cate_name}}</option>
                                @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>分类名称：</th>
                    <td>
                        <input type="text" name="cate_name" value="{{$filed->cate_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>不能大于10个字符!</span>
                    </td>
                </tr>
                <tr>
                    <th>分类描述：</th>
                    <td>
                        <input type="text" class="lg" name="cate_tittle" value="{{$filed->cate_tittle}}">
                        <p>标题可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th>关键词：</th>
                    <td>
                        <textarea name="cate_keywords" value="{{$filed->cate_keywords}}"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea class="lg" name="cate_description" value="{{$filed->cate_description}}"></textarea>
                        <p>描述可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="cate_order" value="{{$filed->cate_order}}">
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