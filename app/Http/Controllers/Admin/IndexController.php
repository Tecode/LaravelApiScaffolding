<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IndexController extends PublicController
{
    public function index()
    {
//        $files = Storage::allFiles();
//        dd($files);
        //转成静态文件
//        $htmlStrings = view('admin.index')->__toString();
//        $baseUrl = date("YmdHis").mt_rand(100,900);
//        Storage::put('article/'.$baseUrl.'.html', $htmlStrings);
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function loginOut()
    {
        session(['user' => null]);
        return redirect('admin/login');
    }

    //修改超级会员密码
    public function pass()
    {

        if ($input = Input::all()) {
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $messages = [
                'password.required' => "请填写新密码",
                'password.between' => "新密码要6-20位之间",
                'password.confirmed' => "密码不一致",
            ];
            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            } else {
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                    if ($input['password_o'] != $_password) {
                        return back()->with('errors','原密码错误!');
                    } else {
                        $user->user_pass = Crypt::encrypt($input['password']);
                        $user->update();
                        return back()->with('errors','密码修改成功!');
                    }
            }
        }
        return view('admin/pass');
    }
}
