<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;


class CommonController extends Controller
{
    public function __construct()
    {
        $navs=Navs::all();
        $hot=Article::orderBy('art_view','desc')->take(6)->get();
        //图文列表5篇（分页效果）
        $pics=Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布文章（8篇）
        $new=Article::orderBy('art_view','desc')->take(8)->get();
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
        View::share('pics',$pics);
    }
}
