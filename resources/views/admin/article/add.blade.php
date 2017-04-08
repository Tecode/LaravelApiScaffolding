@extends('master/content')
@section('content')
    <body>
    <link href="{{asset('resources/extend/uploadify/uploadify.css')}}" type="text/css" />
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="{{url('admin/article')}}">全部文章</a> &raquo; 添加文章
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    {{--<div class="result_wrap">--}}
        {{--<div class="result_title">--}}
            {{--<h3>快捷操作</h3>--}}
        {{--</div>--}}
        {{--<div class="result_content">--}}
            {{--<div class="short_wrap">--}}
                {{--<a href="#"><i class="fa fa-plus"></i>新增文章</a>--}}
                {{--<a href="#"><i class="fa fa-recycle"></i>批量删除</a>--}}
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
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
        <form action="{{url('admin/article')}}" enctype="multipart/form-data" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120">分类：</th>
                    <td>
                        <select name="cate_id">
                            <option value="0">==顶级文章==</option>
                            @foreach($data as $v)
                                <option value="{{$v->cate_id}}">{{$v->_cate_name}}</option>
                                @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章标题：</th>
                    <td>
                        <input type="text" name="art_tittle">
                        <span><i class="fa fa-exclamation-circle yellow"></i>不能大于50个字符!</span>
                    </td>
                </tr>
                <tr>
                    <th>关键词：</th>
                    <td>
                        <input type="text" name="art_tag">
                        <span><i class="fa fa-exclamation-circle yellow"></i>用空格隔开!</span>
                    </td>
                </tr>
                <tr>
                    <th>编辑：</th>
                    <td>
                        <input type="text" name="art_editor">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <div style="width: 20%;min-height: 60px">
                            <img class="img_pictrue" src="{{url('storage/app/uploads/20170224191424179.PNG')}}" width="100%"/>
                        </div>
                        <input id="file_upload" value="" type="file" multiple="true">
                        <input class="file_upload" value="" name="art_thump" type="hidden" />
                    </td>
                </tr>
                <tr>
                    <th>文章描述：</th>
                    <td>
                        <textarea class="lg" name="art_description"></textarea>
                    </td>
                </tr>
                <style>
                    .edui-default{line-height: 28px;}
                    div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                    {overflow: hidden; height:20px;}
                    div.edui-box{overflow: hidden; height:22px;}
                </style>
                <tr>
                    <th>文章内容：</th>
                    <td width="80%" height="auto">
                        <!-- 加载编辑器的容器 -->
                        <script id="container" name="art_content" style="height:600px;width:auto" type="text/plain"></script>
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
    <script src="{{url('resources/extend/uploadify/jquery.uploadify.min.js')}}"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="{{url('resources/extend/utf8-php/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{url('resources/extend/utf8-php/ueditor.all.min.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        $(function() {
                $('#file_upload').uploadify({
                'buttonImage' : '{{url("resources/extend/uploadify/browse-btn.png")}}',
                'formData'     : {
                    '_token'     : '{{csrf_token()}}'
                },
                swf           : '{{url("resources/extend/uploadify/uploadify.swf")}}',
                uploader      : '{{url("admin/upload")}}',
                'onUploadSuccess' : function(file, data, response) {
                    $('.img_pictrue').attr('src',"{{url('/')}}"+"/"+data);
                    $('.file_upload').val("{{url('/')}}"+"/"+data);
                }
            });
        });
    </script>
    </body>
@endsection