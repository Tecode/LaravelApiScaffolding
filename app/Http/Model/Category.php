<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Array_;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded =[];

    public function tree()
    {
        $all = $this->orderBy('cate_order', 'asc')
            ->get();
        return $this->getTree($all);
    }

    public function getTree($data)
    {
        $arr = array();
        foreach ($data as $el => $value) {
            if ($value['cate_pid'] == 0) {
                $data[$el]['_'.'cate_name'] = $data[$el]['cate_name'];
                $arr[] = $data[$el];
                foreach ($data as $k => $v) {
                    if ($value['cate_id'] == $v['cate_pid']) {
                        $data[$k]['_'.'cate_name'] = '┣--'.$data[$k]['cate_name'];
                        $arr[] = $data[$k];
                    }
                }
            }
        }
        return $arr;
    }
}
