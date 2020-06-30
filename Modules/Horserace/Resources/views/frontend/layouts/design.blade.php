<!doctype html>
<html>

<!-- Mirrored from over-the-wall.jp/oneandonly1130/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 30 Nov 2018 02:48:03 GMT -->

<head>
  <meta charset="utf-8">
  <title>競輪チャンネル</title>
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="content-style-type" content="text/css">
  <meta http-equiv="content-script-type" content="text/javascript">
  <meta name="Coverage" content="Japan">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="{{ asset('frontend/images/channel/login/favicon.ico')}}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/images/channel/login/apple-touch-icon.png') }}">
  <link rel="shortcut icon" href="{{ asset('frontend/images/channel/login/android-home-icon.png') }}">
  <!--CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/channel/login/pc.css') }}?{{UPDATE}}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/channel/login/smp.css') }}?{{UPDATE}}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/channel/login/jquery.mmenu.all.css') }}?{{UPDATE}}"/>
  <!--CSS-->

  <?php $check_gtag = \Request::cookie('check_gtag'); ?>
  @if(isset($check_gtag) && $check_gtag == 1)
      <!-- Global site tag (gtag.js) - Google Ads: 625474901 --> 
      <script async src="https://www.googletagmanager.com/gtag/js?id=AW-625474901"></script> 
      <script> 
          window.dataLayer = window.dataLayer || []; 
          function gtag(){dataLayer.push(arguments);} 
          gtag('js', new Date()); 
          
          gtag('config', 'AW-625474901'); 
      </script> 
      <!-- Event snippet for 申し込み conversion page --> 
      <script> 
          gtag('event', 'conversion', {'send_to': 'AW-625474901/r5PTCOqriNMBENX6n6oC'}); 
      </script>
  @else
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GTAG_ID')}}"></script> 
    <script> 
      window.dataLayer = window.dataLayer || []; 
      function gtag(){dataLayer.push(arguments);} 
      gtag('js', new Date()); 
    
      gtag('config', '{{env('GTAG_ID')}}'); 
    </script> 
    <!-- Event snippet for 申し込み conversion page --> 
    <script> 
      gtag('event', 'conversion', {'send_to': '{{env('GTAG_SEND_TO')}}'}); 
    </script>
  @endif

    <!-- Global site tag (gtag.js) - Google Ads: 625474901 --> 

</head>
<body>
  @include('horserace::frontend.layouts.sidebar')
  <div id="wrap">{{-- class="mm-page"> --}}
    @include('horserace::frontend.layouts.header')
   {{-- @yield('wide_slider') --}}

    <div id="main" class="clearfix">

     {{--@include('horserace::frontend.layouts.account')--}}

      <!-- main  -->
        <!--contents-left-->
    <div id="menu">{{-- class="fade">--}}
        {{--<div id="right-area">
          <ul id="keiba_btn">
            <li><a href="{{route('point')}}"><img src="{{ asset('frontend/images/channel/login/point-banner.png') }}" width="235" height="150"/></a></li>
            <li><a href="{{route('mail_box')}}"><img src="{{ asset('frontend/images/channel/login/mail-banner.png') }}"  width="235" height="150"/></a></li>
          </ul>      
          <ul id="k_bn">
  
            
            <li><a href="{{route('free')}}"><img src="{{ asset('frontend/images/channel/login/s-banner04.jpg') }}"  width="210" height="120"/></a></li>
            <li><a href="{{route('about')}}"><img src="{{ asset('frontend/images/channel/login/s-banner01.jpg') }}" width="210" height="120"/></a></li>
            <li><a href="{{route('voice')}}"><img src="{{ asset('frontend/images/channel/login/s-banner02.jpg') }}"  width="210" height="120"/></a></li>
            <li><a href="{{route('result')}}" ><img src="{{ asset('frontend/images/channel/login/s-banner03.jpg') }}"  width="210" height="120"/></a></li>
            <li><a href="https://www.rakuten-bank.co.jp/" target="_blank"><img src="{{ asset('frontend/images/channel/login/banner01.png') }}" width="210" height="60"/></a></li>
          </ul>
        </div>--}}

        <ul class="clearfix">
            <a href="{{route('home')}}"><li><img src="{{ asset('frontend/images/channel/login/icon1.svg')}}"/><p>トップページ</p></li></a>
            <a href="{{route('point')}}"><li><img src="{{ asset('frontend/images/channel/login/icon2.svg')}}"/><p>チップ購入</p></li></a>
            <a href="{{route('mail_box')}}"><li><img src="{{ asset('frontend/images/channel/login/icon3.svg')}}"/><p>メールBOX</p></li></a>
            <a href="{{route('about')}}"><li class="sp-none"><img src="{{ asset('frontend/images/channel/login/icon4.svg')}}"/><p>必勝ガイド</p></li></a>
            <a href="{{route('course')}}"><li><img src="{{ asset('frontend/images/channel/login/icon5.svg')}}"/><p>コース一覧</p></li></a>
            <a href="{{route('result')}}"><li class="sp-none"><img src="{{ asset('frontend/images/channel/login/icon6.svg')}}"/><p>的中実績</p></li></a>
            <a href="{{route('voice')}}"><li class="sp-none"><img src="{{ asset('frontend/images/channel/login/icon7.svg')}}"/><p>感謝の声</p></li></a>
            <a href="{{route('mypage')}}"><li class="sp-none"><img src="{{ asset('frontend/images/channel/login/icon8.svg')}}"/><p>マイページ</p></li></a>
            <a href="{{route('contact')}}"><li class="sp-none"><img src="{{ asset('frontend/images/channel/login/icon9.svg')}}"/><p>お問い合わせ</p></li></a>
            <li class="pc-none"><div id="nav_toggle"><img src="{{ asset('frontend/images/channel/login/menu.svg')}}"/><p>メニュー</p></div></li>
            </ul>
      </div>
    <!--contents-left-->
      <div id="contents">
      @yield('content')
      </div>
      <!-- end main -->
      <!--contents-right-->
    {{--<div id="contents-right" class="fade">
      <div id="right-area">
        <ul id="keiba_btn">
          <li><a href="{{route('point')}}"><img src="{{ asset('frontend/images/channel/login/point-banner.png') }}" width="235" height="150"/></a></li>
          <li><a href="{{route('mail_box')}}"><img src="{{ asset('frontend/images/channel/login/mail-banner.png') }}"  width="235" height="150"/></a></li>
        </ul>      
        <ul id="k_bn">

          
          <li><a href="{{route('free')}}"><img src="{{ asset('frontend/images/channel/login/s-banner04.jpg') }}"  width="210" height="120"/></a></li>
          <li><a href="{{route('about')}}"><img src="{{ asset('frontend/images/channel/login/s-banner01.jpg') }}" width="210" height="120"/></a></li>
          <li><a href="{{route('voice')}}"><img src="{{ asset('frontend/images/channel/login/s-banner02.jpg') }}"  width="210" height="120"/></a></li>
          <li><a href="{{route('result')}}" ><img src="{{ asset('frontend/images/channel/login/s-banner03.jpg') }}"  width="210" height="120"/></a></li>
          <li><a href="https://www.rakuten-bank.co.jp/" target="_blank"><img src="{{ asset('frontend/images/channel/login/banner01.png') }}" width="210" height="60"/></a></li>
        </ul>
      </div>
    </div>--}}
  <!--contents-right-->
    </div>
     
    <!-- footer -->
    @include('horserace::frontend.layouts.footer')
    <!-- end footer -->
    <script type="text/javascript" src="{{ asset('frontend/js/channel/jquery.min.js') }}?{{UPDATE}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/channel/custom.js') }}?{{UPDATE}}"></script>
    <script src="{{ asset('frontend/js/channel/smartRollover.js') }}?{{UPDATE}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/channel/jquery.mmenu.min.js') }}?{{UPDATE}}"></script>
    <script>
      $(function() {
        $('#sp-menu').mmenu({
          slidingSubmenus: false
        });
      });
    </script>
    {{--<script type="text/javascript" src="{{ asset('frontend/js/channel/slides.js') }}?{{UPDATE}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery.fullwide-slider.js') }}?{{UPDATE}}"></script>
    <script type="text/javascript">
     $(function(){
        $('#nav_toggle').click(function(){
              $("header").toggleClass('open');
          $("nav").slideToggle(500);
            });
      });
  </script>--}}

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="frontend/js/channel/slides.js"></script>
<script type="text/javascript">

		$(function(){
			$('#nav_toggle').click(function(){
				
				$("nav").slideToggle(250);
					});

		});
</script>

    @yield('javascript')
  </div>
</body>

<!-- Mirrored from over-the-wall.jp/oneandonly1130/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 30 Nov 2018 02:48:03 GMT -->
</html>