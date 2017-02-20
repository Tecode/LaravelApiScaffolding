<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CategoryController extends PublicController
{
    //GET admin.category.index 全部分类
    public function index()
    {
        $data = [
            "infomation" => (new Category())->tree(),
        ];
//        $htmlStrings = view('admin.category.list', compact('data'))->__toString();
//        dd($htmlStrings);
        return view('admin.category.list', compact('data'));
    }

    // POST  admin.category.store 添加分类提交的方法
    public function store()
    {
        $input = Input::except("_token");
        $validator = Validator::make($input, [
            "cate_name" => 'required|max:10',
            "cate_pid" => 'required',
        ], [
            "required" => "带*为必填项，请填写完整!",
            "max" => "分类名称不能超过10个字符"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $re = Category::insert($input);
            if ($re) {
                return redirect('admin/category');
            } else {
                return back()->with(['errors' => '数据库写入错误!']);
            }
        }
    }

    // GET|HEAD  admin/category/create  添加分类
    public function create()
    {
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.add', compact('data'));
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
        $data = Category::where('cate_pid', 0)->get();
        $filed = Category::find($cate_id);
        return view('admin.category.edit', compact('filed', 'data'));
    }

    // PUT|PATCH  admin/category/{category}  admin.category.update  更新分类
    public function update($cate_id)
    {
        $input = Input::except('_method', '_token');
        $validator = Validator::make($input, [
            "cate_name" => 'required|max:10',
            "cate_pid" => 'required',
        ], [
            "required" => "带*为必填项，请填写完整!",
            "max" => "分类名称不能超过10个字符"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $re = Category::where('cate_id', $cate_id)
                ->update($input);
            if ($re) {
                return redirect('admin/category');
            } else {
                return back()->with(['errors' => '数据库写入错误,请稍后重试!']);
            }
        }
    }

    // GET|HEAD  admin/category/{category} admin.category.show 显示信息
    public function show()
    {

    }

    // DELETE  admin/category/{category} admin.category.destroy 删除单个分类
    public function destroy()
    {
        $input = Input::except('_method', '_token');
        $re = Category::where('cate_id', $input['cate_id'])
            ->delete();
        Category::where('cate_pid', $input['cate_id'])->update(['cate_pid' => 0]);
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
