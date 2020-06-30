@extends('horserace::frontend.layouts.before_login.design')
@section('title','Contact complete')
@section('content')
  <div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-contact.png') }}" width="860" height="92">
  </div>

  <div id="mail">
    <div class="text-area">
      <div class="column-info fade">
        <div class="info">
          <p>お問い合わせ内容を送信致しました。 </p>
          <p>※対応時間につきましては18時まで、対応時間外のお問い合わせにつきましては翌営業日のご対応とさせて頂きます。</p>
          <div class="center mt15 fade">
            <a href="{{ route('home') }}">
              <img src="{{ asset('frontend/images/channel/login/top-btn.png') }}"
                   alt="トップページへ戻る" width="400"
                   height="80">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection