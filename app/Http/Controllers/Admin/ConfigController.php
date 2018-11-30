<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades;

class ConfigController extends CommonController
{
    //get admin/config  全部配置项列表
    public function index(){
        $data=Config::orderBy('conf_order','aes')->get();
        $page=Config::orderBy('conf_order','aes')->paginate(4);
        foreach ($data as $k=>$v){
            switch ($v['field_type']){
                case 'input':
                    $data[$k]['_html']="<input class='lg' type='text' name='conf_content[]' value='".$v['conf_content']."'>";
                    break;
                case 'textarea':
                    $data[$k]['_html']="<textarea name='conf_content[]'>".$v['conf_content']."</textarea>";
                    break;

                case 'radio':
                    $arr=explode(',',$v['field_value']);
                    $str='';
                    $c='';
                    foreach ($arr as $m=>$n){
                       $r=explode('|',$n);
                       if($v['conf_content']==$r[0]){
                           $c='checked';
                       }
                       $str.="<input type='radio' name='conf_content[]' value='".$r[0]."'".$c.">".$r[1]."　";
                    }
                    $data[$k]['_html']=$str;
                    break;
            }
        }
        return view('admin/config/index',compact('data','page'));
    }
    public function changeOrder(){
        $input=Input::all();
        $result=Config::where('conf_id',$input['conf_id'])
                       ->update(['conf_order'=>$input['conf_order']]);
        if($result){
             return [
                 'status'=>0,
                 'msg'=>'修改成功!'
             ];
        }else{
            return [
                'status'=>1,
                'msg'=>'修改失败!'
            ];
        }

    }
    //get admin/config/create   添加链接
    public function create(){
        return view('admin.config.add');
    }
    //post admin/config  添加链接提交
    public function store(){
        $input=Input::all();
        $rules=[
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];
        $message=[
            'conf_name.required'=>'配置名称不能为空!',
            'conf_title.required'=>'配置标题不能为空!',

        ];
        $validator=Facades\Validator::make($input,$rules,$message);
        if($validator->passes()){
             $data=Input::except('_token');
             $result=Config::insert($data);
            if($result){
                $notice=['status'=>1,
                    'msg'=>'增添成功！'
                ];
                return redirect('admin/config')->with('result',$notice);
            }else{
                $notice=['status'=>2,
                    'msg'=>'增添失败！'
                ];
                return back()->with('result',$notice);
            }

        }else{
            return back()->withErrors($validator);
        }

    }
    //get admin/config/{config}/edit  编辑分类
    public function edit($conf_id){
        $field=Config::where('conf_id',$conf_id)->get();
        return view('admin.config.edit',compact('field'));
    }
    //put admin/config/{config} 跟新分类
    public function update($conf_id){
        $input=Input::except('_token','_method');
        $result=Config::where('conf_id',$conf_id)
                       ->update($input);
        if($result){
            $result=[
                'status'=>1,
                'msg'=>'修改成功!'
            ];
            return redirect('admin/config')->with('result',$result);
        }else{
            $result=[
                'status'=>2,
                'msg'=>'修改失败!'
            ];
            return back()->with('result',$result);;
        }
    }
    //get admin/category/{category}  显示单个分类信息
    public function show(){

    }
    //delete admin/config/{config} 删除单个分类
    public function destroy($conf_id){
         $update=Config::where('conf_id',$conf_id)
                        ->delete();
         if($update){
             $result=[
                 'status'=>0,
                 'msg'=>'删除成功!'
             ];
         }else{
             $result=[
                 'status'=>1,
                 'msg'=>'删除失败!'
             ];
         }
         return $result;
    }
    public function changeContent(){
        $input=Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)
                   ->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        return back()->with('msg','更新成功!');
    }
    public function putFile(){
        $config=Config::pluck('conf_content','conf_name')->all();
        $path=base_path().'\config\web.php';
        $str="<?php return　".var_export($config,true).";";
        file_put_contents($path,$str);
    }
}
