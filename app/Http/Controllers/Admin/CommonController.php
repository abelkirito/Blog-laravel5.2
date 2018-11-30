<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
class CommonController extends Controller{
	//图片上传
    public function upload(){
        $file=Input::file('Filedata');
        if($file->isValid()){//上传文件是否有效
            $entension=$file->getClientOriginalExtension(); //上传文件的后缀.
            $newName=date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'\uploads',$newName);
            $filepath='uploads/'.$newName;
            return $filepath;
        }
         }

}
?>