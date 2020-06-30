@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
  <!-- main -->
  <div id="contents">


    <div class="form fade">
      <img src="{{ asset('frontend/images/channel/title-login.png') }}" width="860" height="92"/>
      <div class="form03-txt">
        <form action="{{ route('login.submit') }}" method="post">
          {{ csrf_field() }}
          <input type="text" value="" name="login_id" placeholder="ID">
          <input type="password" value="" name="password" placeholder="PASS">
          <input type="image" src="{{ asset('frontend/images/channel/login-btn.png') }}"
                 onmouseover="this.src='frontend/images/channel/login-btn2.png'"
                 onmouseout="this.src='frontend/images/channel/login-btn.png'"/>
          <p><a href="pass.html">▶パスワードを忘れた方はこちら</a></p>
        </form>
        <ul class="f-sns clearfix">
          <li style="display:none;"><a href="#"><img src="{{ asset('frontend/images/channel/facebook-l.svg') }}"></a></li>
          <li style="display:none;"><a href="#"><img src="{{ asset('frontend/images/channel/twitter-l.svg') }}"></a></li>
          <li><a href="#"><img src="{{ asset('frontend/images/channel/google-l.svg') }}"></a></li>
          <li><a href="#"><img src="{{ asset('frontend/images/channel/yahoo-l.svg') }}"></a></li>
        </ul>
      </div>
    </div>


  </div>

  <!-- main -->
@endsection