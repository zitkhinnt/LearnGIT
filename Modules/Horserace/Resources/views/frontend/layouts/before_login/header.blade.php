<!-- Header -->
<div id="header">
  <div class="header-area clearfix">
    <p class="top-logo fade">
      <a href="{{ route("login") }}">
        <img src="{{ asset('frontend/images/channel/logo.png') }}"
             width="236" height="80">
      </a>
      </p>
    
    {{-- hide --}}
    <p class="login-btn" style="display:none"><a href="{{route('login_smp')}}">会員ログイン</a></p>
    
    {{-- hide --}}
    <div class="user fade" style="display:none">
      <form action="{{ route('login.submit') }}" method="post" >

        {{ csrf_field() }}
        <table>
          <tbody>
          <tr>
            <th scope="row" style="display:none;">ログインID</th>
            <td style="display:none;"><input id="login_id" type="text" name="login_id" value=""></td>
            <td rowspan="2"><input type="submit" value="ログイン" class="sbtn"></td>
          </tr>
          <tr>
            <th scope="row" style="display:none;">パスワード</th>
            <td style="display:none;"><input id="password" type="password" name="password" value=""></td>
          </tr>
          </tbody>
        </table>
      </form>


      <ul class="sns clearfix" style="display:none;">

      <ul class="sns clearfix">
        {{-- <li style="display:none;"><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook.svg') }}"></a></li>
        <li style="display:none;"><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter.svg') }}"></a></li>
        <li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google.svg') }}"></a></li>
        <li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo.svg') }}"></a></li> --}}
      </ul>
      <p class="link"><a href="{{route('password_forget')}}" style="display:none;">＞＞パスワードを忘れた方はこちら</a></p>
    </div>
    {{-- end hide --}}
  </div>
  <div class="login-btn">
      <a href="{{ route('login.form') }}">ログイン</a>
    </div>
</div>