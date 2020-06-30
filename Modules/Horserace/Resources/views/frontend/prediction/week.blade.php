@extends('horserace::frontend.layouts.design')
@section('title','Week')
@section('content')

  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      <div id="list">
        <div class="font">
          <p class="center title">主な提供商品ラインナップ</p>

          <p class="center">ONE AND ONLYの世界でご堪能いただける主な商品群</p>
        </div>

        <div class="rank-info" style="margin-bottom: 10px">
          <p class="rank-img"><img src="{{ asset('frontend/images/slide01.jpg') }}" width="660" height="222"></p>
          クリスタルクラス限定提供<br>
          ＜情報レベル＞<span class="star">★★★★★</span>以上<br>
          【GREAT-NINE】牧場系コラボ情報<br>
          【ONLY ONE】究極の1点提供<br>
          etc・・・上記の他にも随時公開となります<br>
        </div>
        <!-- list member level crystal -->
        <div class="blog_list custom">
          <ul>
            @foreach($data['crystal'] as $item)
              <li>
                <a href="{{ route('prediction_detail', $item->id) }}" >
                  {{ $item->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="rank-info" style="margin-bottom: 10px">
          <p class="rank-img"><img src="{{ asset('frontend/images/slide02.jpg') }}" width="660" height="222"></p>
          ダイヤモンドクラス限定提供<br>
          ＜情報レベル＞<span class="star">★★★★</span>以上<br>
          【RECEPTION RACE】接待レース<br>
          【THE STALLION】種牡馬系情報<br>
          【PERFECT-TRIFECTA】究極の3連単提供<br>
          etc・・・上記の他にも随時公開となります<br>
        </div>
        <!-- list member level diamond -->
        <div class="blog_list custom">
          <ul>
            @foreach($data['diamond'] as $item)
              <li>
                <a href="{{ route('prediction_detail', $item->id) }}">
                  {{ $item->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="rank-info" style="margin-bottom: 10px">
          <p class="rank-img"><img src="{{ asset('frontend/images/slide03.jpg') }}" width="660" height="222"></p>
          ゴールドクラス限定提供<br>
          ＜情報レベル＞<span class="star">★★★</span>以上<br>
          【OWNERS SECRET】馬主情報網限定の極秘情報<br>
          【AGENT-EYE】騎手エージェント情報筋の勝負情報<br>
          etc・・・上記の他にも随時公開となります<br>
        </div>
        <!-- list member level gold -->
        <div class="blog_list custom">
          <ul>
            @foreach($data['gold'] as $item)
              <li>
                <a href="{{ route('prediction_detail', $item->id) }}">
                  {{ $item->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="rank-info" style="margin-bottom: 10px">
          <p class="rank-img"><img src="{{ asset('frontend/images/slide04.jpg') }}" width="660" height="222"></p>
          トライアルメンバー<br>
          ＜情報レベル＞<span class="star">☆～☆☆☆</span><br>
          【トライアルパック】<br>
          記者の取材によるオフレコ情報のパッケージ<br>
        </div>
        <!-- list member level trial -->
        <div class="blog_list custom" >
          <ul>
            @foreach($data['trial'] as $item)
              <li>
                <a href="{{ route('prediction_detail', $item->id) }}">
                  {{ $item->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

      </div>
    </div>
    <!--contents-left-->

    <!--contents-right-->
  @include('horserace::frontend.layouts.sidebar')
  <!--contents-right-->


  </div>
  <!-- main -->
@endsection