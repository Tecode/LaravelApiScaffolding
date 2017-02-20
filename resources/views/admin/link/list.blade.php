@extends('master/content')
@section('content')
    <body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  全部分类
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>添加链接</a>
                    <a href="{{url('admin/link')}}"><i class="fa fa-recycle"></i>全部链接</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>链接名称</th>
                        <th>链接描述</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>
    @foreach($data as $info)
                        <tr>
                            <td class="tc">
                                <input  type="text" onchange="changeOrder(this,'{{$info->link_id}}')" value="{{$info->link_order}}">
                            </td>
                            <td class="tc">{{$info->link_id}}</td>
                            <td>
                                <a href="#">{{$info->link_name}}</a>
                            </td>
                            <td>{{$info->link_tittle}}</td>
                            <td>{{$info->link_url}}</td>
                            <td>
                                <a href="{{url('admin/link/'.$info->link_id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delet(this,'{{$info->link_id}}')">删除</a>
                            </td>
                        </tr>
        @endforeach
                </table>


                {{--<div class="page_nav">--}}
                    {{--<div>--}}
                        {{--<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>--}}
                        {{--<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>--}}
                        {{--<span class="current">8</span>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>--}}
                        {{--<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>--}}
                        {{--<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>--}}
                        {{--<span class="rows">11 条记录</span>--}}
                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="page_list">--}}
                    {{--<ul>--}}
                        {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li><a href="#">&raquo;</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
            function changeOrder(obj,link_id) {
                ajax('{{url("admin/link/changeOrder")}}',
                    { link_id : link_id,value:$(obj).val()},
                function (result) {
                    if(result.code==0){
                        layer.msg(result.msg, {icon: 6});
                    }else {
                        layer.msg(result.msg, {icon: 5});
                    }
                });
            }
            function delet(obj,link_id) {
                layer.confirm('确定删除该条数据吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    ajax("{{url('admin/link/')}}"+'/'+link_id,{'_method':'delete'},
                        function (result) {
                            if(result.code==0){
                                layer.msg(result.msg, {icon: 1});
                            }else {
                                layer.msg(result.msg, {icon: 2});
                            }
                        }
                    )
                }, function(){

                });

            }
            function ajax(url,postdata,fn) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: postdata,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function(data){
                        fn.call(this,data)
                    },
                    error: function(data){
                        fn.call(this,data)
                    }
                });
            }
    </script>

    </body>
@endsection