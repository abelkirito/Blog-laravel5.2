<?php

namespace App\Http\Controllers\Home;



use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Config;
use App\Http\Model\Links;
use App\Http\Model\Navs;

class IndexController extends CommonController
{
      public function index(){
          $temp1=['name1'=>Config::get()->where('conf_title','关键词')->toArray()[4]['conf_name'],
                  'content1'=>Config::get()->where('conf_title','关键词')->toArray()[4]['conf_content'],
          ];
          $temp2=['name2'=>Config::get()->where('conf_title','描述')->toArray()[5]['conf_name'],
              'content2'=>Config::get()->where('conf_title','描述')->toArray()[5]['conf_content'],
          ];
          //点击量最高的6篇文章(站长推荐)

          $data=Article::orderBy('art_time','desc')->paginate(5);
          //友情链接
          $links=Links::orderBy('link_order','asc')->get();
          return view('home/index',compact('hot','new','pics','data','links','temp1','temp2'));
      }
    public function cate($cate_id){
         $field=Category::find($cate_id);
         $data=Article::orderBy('art_time','desc')->where('cate_id',$cate_id)->paginate(4);
         //子分类
         $submenu=Category::where('cate_pid',$cate_id)->get();
         Category::where('cate_id',$cate_id)->increment('cate_view');
         return view('home/list',compact('field','data','submenu'));
    }
    public function article($art_id){
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
        $article['pre']=Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next']=Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $data=Article::where('cate_id',$field['cate_id'])->orderBy('art_id','desc')->take(6)->get();
        return view('home/new',compact('field','article','data'));
    }
}
