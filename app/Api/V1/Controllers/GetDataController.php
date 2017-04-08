<?php

namespace App\Http\Controllers\Api;


use App\Http\Model\Article;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GetDataController extends Controller
{
    public function getData () {
        $json = array();
        $data = Article::get();
        $json['code'] = 0;
        $json['data'] = $data;
        return $json;
    }
}
