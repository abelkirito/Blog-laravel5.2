<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades;

class ArticleController extends CommonController
{
//get admin/article  全部文章列表
    public function index(){
        $data=Article::orderBy('art_id','desc')->paginate('6');
        return view('admin.article.index',compact('data'));
    }
//get admin/article/create   添加文章
    public function create(){
        $data=(new Category())->tree();
        return view('admin.article.add',compact('data'));
    }
    //post admin/article  添加文章提交
    public function store(){
       $input=Input::except("_token");
       $input['art_time']=time();
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required'
        ];
        $message=[
            'art_title.required'=>'文章标题不能为空!',
            'art_content.required'=>'文章内容不能为空!',
        ];
        $validator=Facades\Validator::make($input,$rules,$message);
        if($validator->passes()){
            $result=Article::create($input);
            if($result){
                $notice=['status'=>1,
                    'msg'=>'增添成功！'
                ];
                return redirect('admin/article')->with('result',$notice);
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
    //get admin/article/{article}/edit  编辑分类
    public function edit($art_id){
        $data=(new Category())->tree();
        $field=Article::where('art_id',$art_id)->get();
       return view('admin/article/edit',compact('field','data'));
    }
    //put admin/article/{article} 跟新分类
    public function update($art_id){
        $input=Facades\Input::except('_token','_method');
        $result=Article::where('art_id',$art_id)->update($input);
        if($result){
            $result=[
                'status'=>1,
                'msg'=>'修改成功!'
            ];
            return redirect('admin/article')->with('result',$result);
        }else{
            $result=[
                'status'=>2,
                'msg'=>'修改失败!'
            ];
            return back()->with('result',$result);
        }
    }
    //delete admin/article/{article} 删除单个分类
    public function destroy($art_id){
        $result=Article::where('art_id',$art_id)
                         ->delete();
        if($result){
            $data=[
                'status'=>0,
                'msg'=>'删除成功!'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'删除失败!'
            ];
        }
        return $data;
    }
}
