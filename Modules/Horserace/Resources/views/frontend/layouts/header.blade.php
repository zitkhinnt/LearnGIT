<!-- Header -->
<div id="header">
    <div class="header-area clearfix">
        <p class="logo"><a href="{{route('home')}}"><img
                    src="{{ asset('frontend/images/channel/login/logo.png') }}"></a></p>
        <div class="user">
            ID：{{ Auth::user()->login_id }} {{Auth::user()->nickname}}様 <span
                class="point">{{ number_format(Auth::user()->user_point) }}チップ</span>
            {{--<div class="t-id">{{ Auth::user()->login_id }}</div>
        <div class="point">{{ number_format(Auth::user()->user_point) }}Pt</div>--}}
        {{--<div class="sbtn"><a href="{{route('mypage')}}">マイページ</a>
    </div>--}}
</div>
@yield('docomomail-sp')
<header>
    {{--<div class="" id="nav_toggle">
                  <div>
                      <span></span>
                      <span></span>
                      <span></span>
                  </div>
          </div>
          <nav>
              <ul>
                  <li><a href="{{route('home')}}">ホーム</a></li>
    <li><a href="{{route('about')}}">競輪チャンネルとは</a></li>
    <li><a href="{{route('point')}}">ポイント購入</a></li>
    <li><a href="{{route('faq')}}">よくある質問</a></li>
    <li><a href="{{route('mypage')}}">マイページ</a></li>
    <li><a href="{{route('mail_box')}}">メールボックス</a></li>
    <li><a href="{{route('voice')}}">感謝の声</a></li>
    <li><a href="{{route('result')}}">的中実績</a></li>
    <li><a href="{{route('contact')}}">お問い合わせ</a></li>

    {<li><a href="{{route('home')}}">ホーム</a></li>
    <li><a href="{{route('about')}}">初心者ガイド</a></li>
    <li><a href="{{route('point')}}">ポイント購入</a></li>
    <li><a href="{{route('course')}}">コース一覧</a></li>
    <li><a href="{{route('faq')}}">よくある質問</a></li>
    <li><a href="{{route('mypage')}}">マイページ</a></li>
    <li><a href="{{route('mail_box')}}">メールボックス</a></li>
    <li><a href="{{route('free')}}">無料予想</a></li>
    <li><a href="{{route('voice')}}">感謝の声</a></li>
    <li><a href="{{route('result')}}">的中実績</a></li>
    <li><a href="{{route('contact')}}">お問い合わせ</a></li>

    <li><a href="index.html">ホーム</a></li>
    <li><a href="about.html">初心者ガイド</a></li>
    <li><a href="point.html">ポイント購入</a></li>
    <li><a href="course.html">コース一覧</a></li>
    <li><a href="faq.html">よくある質問</a></li>
    <li><a href="mypage.html">マイページ</a></li>
    <li><a href="mail.html">メールボックス</a></li>
    <li><a href="free.html">無料予想</a></li>
    <li><a href="voice.html">感謝の声</a></li>
    <li><a href="result.html">的中実績</a></li>
    <li><a href="contact.html">お問い合わせ</a></li>
    </ul>
    </nav>--}}
</header>
</div>
</div>
{{--<div id="menu">
  <ul class="clearfix">
  <li><a href="{{route('home')}}"><img src="{{ asset('frontend/images/channel/login/menu01_off.png') }}" width="167"
    height="70" /></a></li>
<li><a href="{{route('about')}}"><img src="{{ asset('frontend/images/channel/login/menu02_off.png') }}" width="167"
            height="70" /></a></li>
<li><a href="{{route('point')}}"><img src="{{ asset('frontend/images/channel/login/menu03_off.png') }}" width="167"
            height="70" /></a></li>
<li><a href="{{route('course')}}"><img src="{{ asset('frontend/images/channel/login/menu04_off.png') }}" width="167"
            height="70" /></a></li>
<li><a href="{{route('faq')}}"><img src="{{ asset('frontend/images/channel/login/menu05_off.png') }}" width="167"
            height="70" /></a></li>
<li><a href="{{route('contact')}}"><img src="{{ asset('frontend/images/channel/login/menu06_off.png') }}" width="167"
            height="70" /></a></li>
</ul>
</div>--}}


<!-- Header -->