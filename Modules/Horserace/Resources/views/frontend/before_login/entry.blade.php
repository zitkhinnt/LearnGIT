@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
  <!-- main -->
        @if($data["status"] == "success")
          <div id="contents">
            <div class="title">仮登録申請を受付けました</div>
              <div class="text-area">
                <div class="column-info">
                  <div class="info">
                    <p>ご入力いただいたメールアドレス宛に確認メールが届きますので、記載内容に沿って本登録手続きを行ってください。<br>
                    <br>
                    ご利用環境によっては《迷惑メールフォルダ》に振り分けられる場合もございますので《迷惑メールフォルダ》のご確認も必ず行っていただけますようお願いいたします。<br>
                    <br>
                    </p>
                  </div>
                </div>
              </div>
          </div>
        @elseif($data["status"] == "exit")
          <div class="text-area">
            <div class="column-info">
              <div class="info">
                <p  style="text-align: center; color: red;">・このメールアドレスはすでに登録済みです。
                <br>・過去にSNS認証でご登録された方へ、
                <br>お客様のIDとPASSをお伝えしますので、お問い合わせよりご連絡ください。</p>
              </div>
            </div>
          </div>
        @else
          <p>Error</p>
        @endif
  </div>

  <!-- main -->
@endsection
