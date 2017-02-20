<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LinkController extends PublicController
{
    //GET admin.category.index 全部分类
    public function index()
    {
        $data = Link::orderBy('link_order', 'asc')->get();
        return view('admin.link.list', compact('data'));
    }

    // POST  admin.link.store 添加分类提交的方法
    public function store()
    {
        $input = Input::except("_token");
        $validator = Validator::make($input, [
            "link_name" => 'required',
            "link_url" => 'required',
        ], [
            "required" => "带*为必填项，请填写完整!"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $re = Link::insert($input);
            if ($re) {
                return redirect('admin/link');
            } else {
                return back()->with(['errors' => '数据库写入错误!']);
            }
        }
    }

    // GET|HEAD  admin/category/create  添加分类
    public function create()
    {
        return view('admin.link.add');
    }

    public function changeOrder()
    {
        $input = Input::all();
        $link = Link::find($input['link_id']);
        $link->link_order = $input['value'];
        $re = $link->update();
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

    // GET|HEAD  admin/link/{category}/edit   admin.category.edit 编辑分类
    public function edit($cate_id)
    {
        $data = Link::find($cate_id);
        return view('admin.link.edit', compact('data'));
    }

    // PUT|PATCH  admin/category/{category}  admin.category.update  更新分类
    public function update($cate_id)
    {
        $input = Input::except('_method', '_token');
        $validator = Validator::make($input, [
            "link_name" => 'required',
            "link_url" => 'required',
        ], [
            "link_url.required" => "链接地址不能为空!",
            "link_name.required" => "链接名称不能为空!",
            "link_name.max" => "分类名称不能超过10个字符"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $re = Link::find($cate_id)
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
    public function destroy($link_id)
    {
        $input = Input::except('_method', '_token');
        $re = Link::find($link_id)
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
