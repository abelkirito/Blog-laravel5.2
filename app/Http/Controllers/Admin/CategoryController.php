<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades;
class CategoryController extends CommonController
{
    //get admin/category  全部分类列表
    public function index(){
         $cate=new Category();
         $data=$cate->tree();
         $forpage=Category::paginate(6);
         return view('admin.category.index')->with('data',$data)
                                                 ->with('page',$forpage);
    }


    //get admin/category/create   添加分类
    public function create(){
       $data=Category::all()->where('cate_pid',0);
       return view('admin.category.add')->with('data',$data);
    }
    //post admin/category  添加分类提交
    public function store(){
        $input=Facades\Input::all();
            $rules=[
                'cate_name'=>'required',
            ];
            $message=[
                'cate_name.required'=>'分类名称不能为空!',

            ];
            $validator=Facades\Validator::make($input,$rules,$message);
            if($validator->passes()){
                $cate_pid=$input['cate_pid'];
                $cate_name=$input['cate_name'];
                $cate_title=$input['cate_title'];
                $cate_keywords=$input['cate_keywords'];
                $cate_description=$input['cate_description'];
                $cate_order=$input['cate_order'];
                $result=Category::insert(['cate_pid'=>$cate_pid,'cate_name'=>$cate_name,'cate_title'=>$cate_title,'cate_keywords'=>$cate_keywords,'cate_description'=>$cate_description,'cate_order'=>$cate_order]);
                if($result){
                   $notice=['status'=>1,
                       'msg'=>'增添成功！'
                       ];
                    return redirect('admin/category')->with('result',$notice);
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
    //get admin/category/{category}/edit  编辑分类
    public function edit($cate_id){
        $field=Category::where('cate_id',$cate_id)->get();
        $data=Category::all()->where('cate_pid',0);
        return view('admin.category.edit',compact('field','data'));
    }
    //put admin/category/{category} 跟新分类
    public function update($cate_id){
        $input=Facades\Input::all();
        $result=Category::where('cate_id',$cate_id)
                          ->update(['cate_id'=>$cate_id,'cate_name'=>$input['cate_name'],'cate_keywords'=>$input['cate_keywords'],'cate_description'=>$input['cate_description'],'cate_order'=>$input['cate_order']]);
        if($result){
            $result=[
                'status'=>1,
                'msg'=>'修改成功!'
            ];
            return redirect('admin/category')->with('result',$result);
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
    //delete admin/category/{category} 删除单个分类
    public function destroy(){

    }

    public function changeOrder(){
        $order=$_POST['cate_order'];
        $id=$_POST['cate_id'];
        $result=Category::where('cate_id',$id)
                          ->update(['cate_order'=>$order]);
        if($result){
            $data=[
                'status'=>0,
                'msg'=>'修改成功!'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'修改失败!'
            ];
        }
        return $data;
        /*方法二： $test=Facades\Input::all();
                  $test['cate_order'];也可获得post传递过来的参数*/
    }
}
