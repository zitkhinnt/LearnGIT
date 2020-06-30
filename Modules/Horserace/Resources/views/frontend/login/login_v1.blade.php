<!DOCTYPE html>
<html lang="ja">

<!-- Mirrored from 163.43.29.41/horse-race/public/login by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Oct 2018 02:06:46 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=favicon.icoedge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.ico') }}?{{UPDATE}}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon.png') }}?{{UPDATE}}">
  <link rel="shortcut icon" href="{{ asset('frontend/images/android-home-icon.png') }}?{{UPDATE}}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="cxe76bi4NnICFNBXG12aR0WpkNC5A6BtGyT7Zw5V">

  <title>ONE & ONLY</title>

  <!-- Styles -->
  <link href="{{ asset('frontend/css/app.css') }}?{{UPDATE}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/css/horserace/frontend/jquery.fullPage.css') }}?{{UPDATE}}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/horserace/frontend/pc_login.css') }}?{{UPDATE}}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/horserace/frontend/sp_login.css') }}?{{UPDATE}}"/>

  <!-- Scripts -->
  <script type="text/javascript"
          src="{{ asset('frontend/js/horserace/frontend_js/jquery.min.js') }}?{{UPDATE}}"></script>

  <!-- Fonts -->
</head>
<body>
<div id="app">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top navbar-dark-opacity">
    <div class="container">
      <a class="navbar-brand" href="{{ route('login') }}">
        ONE & ONLY
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#a02" id="user-register">
              無料登録する
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#a02" id="user-login">
              ログイン
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <div id="fullpage">
      <div class="section" id="section0">
        <div class="section0">
          <p class="logo">
            <img src="{{ asset('frontend/images/horserace/frontend_images/logo.png') }}">
          </p>
          <img src="{{ asset('frontend/images/horserace/frontend_images/txt01.png') }}"/>
        </div>
        <div class="arrow">
          <a href="#a02">
            <img src="{{ asset('frontend/images/horserace/frontend_images/arrow.svg') }}"/>
          </a>
        </div>
      </div>
      <div class="section" id="section1">
        <div class="section1 col-lg-4 col-md-6 col-sm-8 col-12">
          <div id="tab-login" class="display-none">
            <h4 class="title-login-register">IDとPASSをお持ちのお客様はコチラから</h4>
            @if (Session::has('flash_message'))
              <div class="alert alert-{!! Session::get('flash_level') !!}">
                {!! Session::get('flash_message') !!}
              </div>
            @endif
            <form method="POST" action="{{ route("login.submit") }}">
              {{ csrf_field() }}
              <div class="form-group">
                <input id="login_id" type="text" placeholder="IDを入力してください"
                       class="form-control {{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id"
                       value="">
                @if ($errors->has('login_id'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('login_id') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group">
                <input id="password" type="password" placeholder="パスワードを入力してください"
                       class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                @if ($errors->has('password'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  ログイン
                </button>
              </div>
            </form>
          </div>
          <div id="tab-register">
            <h4 class="title-login-register">無料登録する</h4>
            @if (Session::has('flash_message'))
              <div class="alert alert-{!! Session::get('flash_level') !!}">
                {!! Session::get('flash_message') !!}
              </div>
            @endif
            <form method="POST" action="{{ route("register") }}">
              {{ csrf_field() }}
              <input type="hidden" name="ref" value="{{ $data["ref"] }}">
              <div class="form-group">
                <input type="email" placeholder="メールアドレスを入力してください"
                       class="form-control" name="email"
                       value="" required>
                @if ($errors->has('email'))
                  <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  無料登録する
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="arrow">
          <a href="#a03">
            <img src="{{ asset('frontend/images/horserace/frontend_images/arrow.svg') }}"/>
          </a>
        </div>
      </div>
      <div class="section" id="section2">
        <div class="section2">
          <img src="{{ asset('frontend/images/horserace/frontend_images/txt03.png') }}"/>
        </div>
        <div class="arrow">
          <a href="#a04">
            <img src="{{ asset('frontend/images/horserace/frontend_images/arrow.svg') }}"/>
          </a>
        </div>
      </div>
      <div class="section" id="section3">
        <div class="section3">
          <img src="{{ asset('frontend/images/horserace/frontend_images/txt04.png') }}"/>
        </div>
        <div class="arrow">
          <a href="#a01">
            <img src="{{ asset('frontend/images/horserace/frontend_images/arrow.svg') }}"/>
          </a>
        </div>
      </div>
    </div>
    <div id="footer">
      <p id="info">
        {{--<a href="{{ route('before_about') }}">ご利用規約</a>　--}}
        <a href="{{ route('before_about') }}">初めての方</a>　
        <a href="{{ route('before_trans') }}">特定商取引に基づく表記</a>　
        <a href="{{ route('before_privacy') }}">プライバシーポリシー</a>　
        <a href="{{ route('before_contact') }}">お問い合わせ</a>
      </p>
      <p id="copy">&copy; one &amp; only. All Rights Reserved.</p>
    </div>
  </main>
</div>
<script type="text/javascript"
        src="{{ asset('frontend/js/horserace/frontend/jquery.fullPage.js') }}?{{UPDATE}}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/custom.js') }}?{{UPDATE}}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#fullpage').fullpage({
      verticalCentered: false,
      anchors: ['a01', 'a02', 'a03', 'a04'],
      menu: '#menu',
      easing: 'easeInOutCirc',
      scrollingSpeed: 1000,
      resize: true
    });

    $(document).on('click', '#user-login', function () {
      $('#tab-login').removeClass('display-none');
      $('#tab-register').addClass('display-none');
    });

    $(document).on('click', '#user-register', function () {
      $('#tab-register').removeClass('display-none');
      $('#tab-login').addClass('display-none');
    });
  });
</script>

<script type="text/javascript">
  if (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
    document.write('<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/horserace/frontend_css/sp.css') }}?{{UPDATE}}" />');
  }
</script>
</body>

<!-- Mirrored from 163.43.29.41/horse-race/public/login by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Oct 2018 02:07:04 GMT -->
</html>
