@extends('layouts.home')
@section('info')
  <title>{{\App\Http\Model\Config::all()->where('conf_title','网站标题')[0]['conf_content']}}</title>
  <meta name="{{$temp1['name1']}}" content="{{$temp1['content1']}}" />
  <meta name="{{$temp2['name2']}}" content="{{$temp2['content2']}}" />
@endsection
        @section('content')
          <div class="banner">
            <section class="box">
              <ul class="texts">
                <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
                <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
                <p>加了锁的青春，不会再因谁而推开心门。</p>
              </ul>
              <div class="avatar"><a href="#"><span>陈华</span></a> </div>
            </section>
          </div>
          <div class="template">
            <div class="box">
              <h3>
                <p><span>站长</span>推荐 Recommend</p>
              </h3>
              <ul>
                @foreach($pics as $p)
                  <li><a href="{{url('a/'.$p['art_id'])}}"  target="_blank"><img src="../{{$p['art_thumb']}}"></a><span>{{$p['art_title']}}</span></li>
                @endforeach
              </ul>
            </div>
          </div>
          <article>
            <h2 class="title_tj">
              <p>文章<span>推荐</span></p>
            </h2>
            <div class="bloglist left">
              @foreach($data as $d)
              <h3>{{$d['art_title']}}</h3>
              <figure><img src="{{url('../'.$d['art_thumb'])}}"></figure>
              <ul>
                <p>{{$d['art_description']}}</p>
                <a title="{{$d['art_title']}}" href="{{url('a/'.$d['art_id'])}}" target="_blank" class="readmore">阅读全文>></a>
              </ul>
              <p class="dateview"><span>{{date("Y-m-d",$d['art_time'])}}</span><span>作者:{{$d['art_editor']}}</span></p>
              @endforeach
                <div class="page">

                {{$data->links()}}


                </div>
            </div>
            <aside class="right">
              <!-- Baidu Button BEGIN -->
              <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
              <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
              <script type="text/javascript" id="bdshell_js"></script>
              <script type="text/javascript">
                  document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
              </script>
              <!-- Baidu Button END --><br><br><br><br>
              <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>
              <div class="news">
                @parent
                <h3 class="links">
                  <p>友情<span>链接</span></p>
                </h3>
                <ul class="website">
                  @foreach($links as $l)
                  <li><a href="{{$l['link_url']}}" target="_blank">{{$l['link_name']}}</a></li>
                  @endforeach
                </ul>
              </div>

            </aside>
          </article>
        @endsection
