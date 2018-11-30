<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    public  function tree(){
        $categorys=$this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,'cate_id','cate_pid',0,'cate_name');
    }
    public  function getTree($data,$filed_id,$field_pid,$pid,$filed_name){
        $arr=array();
        foreach ($data as $k=>$v){
            if($v[$field_pid]==$pid){
                $data[$k]['_'.$filed_name]=$data[$k][$filed_name];
                $arr[]=$data[$k];
                foreach ($data as $m=>$n){
                    if($n[$field_pid]==$v[$filed_id]){
                        $data[$m]['_'.$filed_name]="∟".$data[$m][$filed_name];
                        $arr[]= $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
