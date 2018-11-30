<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades;

class LinksController extends CommonController
{
    //get admin/links  全部友情链接列表
    public function index(){
        $data=Links::orderBy('link_order','aes')->paginate(4);
        return view('admin/links/index',compact('data'));
    }
    public function changeOrder(){
        $input=Input::all();
        $result=Links::where('link_id',$input['link_id'])
                       ->update(['link_order'=>$input['link_order']]);
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
    //get admin/links/create   添加链接
    public function create(){
        return view('admin.links.add');
    }
    //post admin/links  添加链接提交
    public function store(){
        $input=Input::all();
        $rules=[
            'link_name'=>'required',
        ];
        $message=[
            'link_name.required'=>'链接名称不能为空!',

        ];
        $validator=Facades\Validator::make($input,$rules,$message);
        if($validator->passes()){
             $data=Input::except('_token');
             $result=Links::insert($data);
            if($result){
                $notice=['status'=>1,
                    'msg'=>'增添成功！'
                ];
                return redirect('admin/links')->with('result',$notice);
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
    //get admin/links/{links}/edit  编辑分类
    public function edit($link_id){
        $field=Links::where('link_id',$link_id)->get();
        return view('admin.links.edit',compact('field'));
    }
    //put admin/category/{category} 跟新分类
    public function update($link_id){
        $input=Input::except('_token','_method');
        $result=Links::where('link_id',$link_id)
                       ->update($input);
        if($result){
            $result=[
                'status'=>1,
                'msg'=>'修改成功!'
            ];
            return redirect('admin/links')->with('result',$result);
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
    //delete admin/links/{links} 删除单个分类
    public function destroy($link_id){
         $update=Links::where('link_id',$link_id)
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
