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
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>时间</th>
                        <th>查看次数</th>
                        <th>编辑</th>
                        <th>操作</th>
                    </tr>
    @foreach($data as $info)
                        <tr>
                            <td class="tc">{{$info->art_id}}</td>
                            <td>
                                <a href="#">{{$info->art_tittle}}</a>
                            </td>
                            <td>{{date('Y-m-d H:i:s',$info->art_time)}}</td>
                            <td>{{$info->art_view}}</td>
                            <td>{{$info->art_editor}}</td>
                            <td>
                                <a href="{{url('admin/article/'.$info->art_id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delet(this,'{{$info->art_id}}')">删除</a>
                            </td>
                        </tr>
        @endforeach
                </table>
                <div class="page_list" style="text-align: center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
            function changeOrder(obj,cate_id) {
                ajax('{{url("admin/cate/changeOrder")}}',
                    { cate_id : cate_id,value:$(obj).val()},
                function (result) {
                    if(result.code==0){
                        layer.msg(result.msg, {icon: 6});
                    }else {
                        layer.msg(result.msg, {icon: 5});
                    }
                });
            }
            function delet(obj,art_id) {
                layer.confirm('确定删除这篇文章吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    ajax("{{url('admin/article/')}}/"+art_id,{'_method':'delete'},
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