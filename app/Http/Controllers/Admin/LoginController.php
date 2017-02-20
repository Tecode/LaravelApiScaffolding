<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


require_once 'resources/extend/Code.class.php';

class LoginController extends PublicController
{
    public function login()
    {
        if ($input = Input::all()) {
            $code = new \Code;
            $_code = $code->get();
            if (strtoupper($input['code']) != $_code) {
                return back()->with('msg', '验证码错误');
            }
            $user = User::first();
            if ($user->user_name == $input['user_name'] && $input['user_password'] == Crypt::decrypt($user->user_pass)) {
                session(['user' => $user]);
                return redirect('/admin/index');
            } else {
                return back()->with('msg', '用户名或密码错误');
            }

        } else {
            return view('/admin/login');
        }
    }

    public function code()
    {
        $code = new \Code();
        $code->make();
    }

    public function crypt()
    {
        $d = User::all();
        dd($d);
//        $str = '510125992y7xx';
//        echo Crypt::encrypt($str);
    }
}
