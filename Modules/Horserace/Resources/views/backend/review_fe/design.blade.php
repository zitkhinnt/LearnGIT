<!doctype html>
<html>

<!-- Mirrored from over-the-wall.jp/oneandonly-login-test/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Oct 2018 01:40:04 GMT -->
<head>
  <meta charset="utf-8">
  <title>one &amp; only - @yield('title')</title>
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="content-style-type" content="text/css">
  <meta http-equiv="content-script-type" content="text/javascript">
  <meta name="Coverage" content="Japan">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.ico') }}?{{UPDATE}}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon.png') }}?{{UPDATE}}">
  <link rel="shortcut icon" href="{{ asset('frontend/images/android-home-icon.png') }}?{{UPDATE}}">
  <!--CSS-->
  <link href="{{ asset('frontend/css/pc.css') }}?{{UPDATE}}" rel="stylesheet"/>
  <link href="{{ asset('frontend/css/smp.css') }}?{{UPDATE}}" rel="stylesheet"/>
  <link href="{{ asset('frontend/css/jquery.mmenu.all.css') }}?{{UPDATE}}" rel="stylesheet" type="text/css"/>
  <!--CSS-->
</head>

<body>
<div id="wrap">
  <!-- header -->
@include('horserace::backend.review_fe.header')
<!-- end header -->

  <!-- main  -->
@yield('content')
<!-- end main -->

  <!-- footer -->
@include('horserace::backend.review_fe.footer')
<!-- end footer -->
</div>


<!--MENU-->
<nav id="spmenu">
  <ul>
    <li class="spmenu-title clearfix">Menu<p class="close">×</p></li>
    <li><a href="index.html">TOP</a></li>
    <li><a href="#">初めての方</a>
      <ul>
        <li><a href="{{ route('about', 1) }}">ONE AND ONLYとは</a></li>
        <li><a href="{{ route('about', 2) }}">勝ち組になるための秘訣</a></li>
        <li><a href="{{ route('about', 3) }}">ステータス制度の仕組み</a></li>
      </ul>
    </li>
    <li><a href="{{ route('column') }}">限定コラム</a></li>
    <li><a href="#">情報提供申込</a>
      <ul>
        <li><a href="{{ route('list') }}">商品一覧</a></li>
        <li><a href="{{ route('week') }}">今週のラインナップ</a></li>
      </ul>
    </li>
    <li><a href="{{ route('result') }}">的中実績</a></li>
    <li><a href="{{ route('contact') }}">お問い合わせ</a></li>
    <li><a href="{{ route('point') }}">ポイント購入</a></li>
    <li><a href="{{ route('mail') }}">メールBOX</a></li>
    <li><a href="{{ route('mypage') }}">会員情報変更</a></li>
  </ul>
</nav>
<!--MENU-->

<!-- js -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="{{ asset('frontend/js/jquery.mmenu.min.js') }}?{{UPDATE}}"></script>
<script>
  $(function () {
    $('#spmenu').mmenu({
      slidingSubmenus: false
    });
  });
</script>
<script src="{{ asset('frontend/js/smartRollover.js') }}?{{UPDATE}}"></script>
<script src="{{ asset('frontend/js/slides.js') }}?{{UPDATE}}"></script>
<script src="{{ asset('frontend/js/right.js') }}?{{UPDATE}}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery.fullwide-slider.js') }}?{{UPDATE}}"></script>

</body>

<!-- Mirrored from over-the-wall.jp/oneandonly-login-test/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Oct 2018 01:41:36 GMT -->
</html>