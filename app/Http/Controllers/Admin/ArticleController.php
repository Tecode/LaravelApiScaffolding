<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ArticleController extends PublicController
{
    //GET admin.article.index 全部分类
    public function index()
    {
        $data = Article::paginate(8);
        return view('admin.article.list',compact("data"));
    }

    // POST  admin.article.store 添加分类提交的方法
    public function store()
    {
        $input = Input::except("_token");
        $input['art_time'] = time();
        $validator = Validator::make($input, [
            "art_tittle" => 'required|max:50',
            "cate_id" => 'required',
            "art_content"=> 'required',
        ], [
            "art_tittle.required" => "请填写文章标题!",
            "art_tittle.max" => "分类名称不能超过10个字符",
            "art_content.required" =>"文章内容不能为空!"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $re = Article::insert($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with(['errors' => '数据库写入错误!']);
            }
        }
    }

    // GET|HEAD  admin/category/create  添加分类
    public function create()
    {
        $data = (new Category())->tree();
        return view('admin.article.add', compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['value'];
        $re = $cate->update();
        if ($re) {
            $data = [
                'code' => 0,
                'msg' => "修改排序成功"
            ];
        } else {
            $data = [
                'code' => -1,
                'msg' => "修改排序失败"
            ];
        }
        return $data;
    }

    // GET|HEAD  admin/category/{category}/edit   admin.category.edit 编辑分类
    public function edit($cate_id)
    {
        $data = (new Category())->tree();
        $filed = Article::find($cate_id);
        return view('admin.article.edit', compact('filed', 'data'));
    }

    // PUT|PATCH  admin/article/{category}  admin.category.update  更新分类
    public function update($cate_id)
    {
        $input = Input::except('_method', '_token');
        $input['art_time'] = time();
        $validator = Validator::make($input, [
            "art_tittle" => 'required|max:50',
            "cate_id" => 'required',
            "art_content"=> 'required',
        ], [
            "art_tittle.required" => "请填写文章标题!",
            "art_tittle.max" => "分类名称不能超过10个字符",
            "art_content.required" =>"文章内容不能为空!"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $re = Article::find($cate_id)->update($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with(['errors' => '数据库写入错误!']);
            }
        }
    }

    // GET|HEAD  admin/category/{category} admin.category.show 显示信息
    public function show()
    {

    }

    // DELETE  admin/category/{category} admin.category.destroy 删除单个分类
    public function destroy($art_id)
    {
        $re = Article::where('art_id', $art_id)
            ->delete();
        if ($re) {
            $data = [
                "code" => 0,
                "msg" => "删除成功"
            ];
        } else {
            $data = [
                "code" => -1,
                "msg" => "删除失败，请稍后再试！"
            ];
        }
        return $data;
    }

}
