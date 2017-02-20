<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PublicController extends Controller
{
    //图片上传方法
    public function upload(){
        $file = Input::file('Filedata');
        if($file -> isValid()){
            //获取上传文件名称
            $clientName = $file -> getClientOriginalName();
            //获取绝对零时文件路径
            $realPath = $file -> getRealPath();
            //获取文件后缀
            $entension = $file -> getClientOriginalExtension();
            //图片保存路径
            $newName = date('YmdHid').mt_rand(100,200).'.'.$entension;
            $path = $file -> move('storage/app/uploads',$newName);
            return 'storage/uploads/'.$newName;
        }
    }
}
