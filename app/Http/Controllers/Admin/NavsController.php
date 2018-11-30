<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades;

class NavsController extends CommonController
{
    //get admin/navs  全部友情链接列表
    public function index(){
        $data=Navs::orderBy('nav_order','aes')->paginate(4);
        return view('admin/navs/index',compact('data'));
    }
    public function changeOrder(){
        $input=Input::all();
        $result=Navs::where('nav_id',$input['nav_id'])
                       ->update(['nav_order'=>$input['nav_order']]);
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
    //get admin/navs/create   添加链接
    public function create(){
        return view('admin.navs.add');
    }
    //post admin/navs  添加链接提交
    public function store(){
        $input=Input::all();
        $rules=[
            'nav_name'=>'required',
        ];
        $message=[
            'nav_name.required'=>'链接名称不能为空!',

        ];
        $validator=Facades\Validator::make($input,$rules,$message);
        if($validator->passes()){
             $data=Input::except('_token');
             $result=Navs::insert($data);
            if($result){
                $notice=['status'=>1,
                    'msg'=>'增添成功！'
                ];
                return redirect('admin/navs')->with('result',$notice);
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
    //get admin/navs/{navs}/edit  编辑分类
    public function edit($nav_id){
        $field=Navs::where('nav_id',$nav_id)->get();
        return view('admin.navs.edit',compact('field'));
    }
    //put admin/navs/{navs} 跟新分类
    public function update($nav_id){
        $input=Input::except('_token','_method');
        $result=Navs::where('nav_id',$nav_id)
                       ->update($input);
        if($result){
            $result=[
                'status'=>1,
                'msg'=>'修改成功!'
            ];
            return redirect('admin/navs')->with('result',$result);
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
    //delete admin/navs/{navs} 删除单个分类
    public function destroy($nav_id){
         $update=Navs::where('nav_id',$nav_id)
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
}
