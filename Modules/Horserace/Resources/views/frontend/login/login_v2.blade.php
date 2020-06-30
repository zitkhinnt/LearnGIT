@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
  <div id="top01">

    <div class="logo">
      <img src="{{ asset('frontend/images/horserace/frontend_images/logo.png') }}" width="500" height="222"
           alt="one & only"/>
    </div>

    <div class="txt-area font">
      @if (Session::has('flash_message'))
        <div class="msg-center alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif

      <h1>成功者が集う憩いの上級競馬サロン。</h1>
      <h2>それが、［ONE AND ONLY］の世界。</h2>

      <p>選ばれた者だけが得られる上質な情報が、ここにある。</p>

      <h3>競馬を愛し、競馬界の発展のために全力を注ぐ者だけを選び抜き、<br>「生きた」本物の情報だけを厳選する極上空間。</h3>

      <h4>本物の競馬交流の世界へ、ようこそ。</h4>

    </div>

    <div id="member_info">
      <p class="title font">［ログインはこちら］</p>
      <form method="POST" action="{{ route("login.submit") }}" name="login_form">
        {{ csrf_field() }}
        <ul>
          <li class="tag font">ID</li>
          <li>
            <input id="login_id" type="text" placeholder="IDを入力してください"
                   class="hoge form-control {{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id"
                   value="">
            @if ($errors->has('login_id'))
              <span class="invalid-feedback">
              <strong>{{ $errors->first('login_id') }}</strong>
            </span>
            @endif

          </li>
        </ul>
        <ul>
          <li class="tag font">PW</li>
          <li>
            <input id="password" type="password" placeholder="パスワードを入力してください"
                   class="hoge form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
            @if ($errors->has('password'))
              <span class="invalid-feedback">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </li>
        </ul>
        <input type="image" class="login_btn"
               src="{{ asset('frontend/images/horserace/frontend_images/login-btn_off.png') }}"
               onmouseover="this.src='{{ asset("frontend/images/horserace/frontend_images/login-btn_on.png") }}'"
               onmouseout="this.src='{{ asset("frontend/images/horserace/frontend_images/login-btn_off.png") }}'"/>
      </form>
    </div>

    <div class="txt-area font">
      <h5>［ONE AND ONLY］への入会、および無料情報の閲覧に際しましては、<br>【完全招待制】により既存の会員様より紹介された方のみご利用いただけます。</h5>
    </div>

    <div id="member_info">
      <p class="title font">［無料登録する］</p>
      <form method="POST" action="{{ route("register") }}">
        {{ csrf_field() }}
        <input type="hidden" name="ref" value="{{ $data["ref"] }}">
        <ul>
          <li>
            <input type="email" placeholder="メールアドレスを入力してください"
                   class="hoge hoge-custom form-control" name="email"
                   value="" required>
            @if ($errors->has('email'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
            @endif

          </li>
        </ul>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" style="width: 200px !important;">
            無料登録する
          </button>
        </div>
      </form>
    </div>

    {{--<p class="title font">--}}
    {{--<a href="result.html">［直近の主な結果確認はこちら］</a>--}}
    {{--</p>--}}
    <br><br><br><br><br><br><br><br><br>
  </div>
@endsection