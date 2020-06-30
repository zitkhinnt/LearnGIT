@extends('horserace::frontend.layouts.before_login.design')
@section('title','Contact')
@section('content')
  <div id="contents">
  <div class="title">お問い合わせ</div>

    <div id="mail">
      <div class="text-area">

        <div class="column-info fade">

          <div class="info">
            <p class="cl-black"> 当サービスに関するご質問･疑問に応じています。 <br>
              皆様からお寄せ頂きますご質問･ご意見等は、より良いサービスに活かしていける様、努力して参ります。</p>
            <form action="{{ route('before_contact.store') }}" method="post">
              <input type="hidden" name="_token" value="{!! csrf_token() !!}">
              <div style="padding: 5px;">
                <label class="cl-black">メールアドレス: </label>
                <input type="email" name="mail"
                       style="width: 60%;" value="{{ old("mail") }}"
                       required>
              </div>
              <textarea name="message"></textarea>
              <div class="center">
                <button type="submit" name="submit" value="1" class="login-btn2">送信する</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection