@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
<!-- main -->
<div id="contents">
<div class="title">パスワードを忘れた方</div>
  <div class="form">


    @if(isset($result))
    @if($result)
    <div class="form02-txt">
        <p class="pass">
          入力されたメールアドレスに「復旧方法」を送信しましたのでご確認ください。
        </p>
    </div>
    @else
    <div class="form02-txt">
        <p class="pass">
          入力されたメールアドレスが見つかりませんでした。入力に間違いがないか今一度ご確認下さい。
        </p>
    </div>
    @endif
    @else
    <div class="form02-txt">
      <form action="{{ route('forget_password') }}" method="post">
        @csrf
        <p class="pass">
          パスワードやIDを紛失してしまった場合は、下記に「ご登録に使われたメールアドレス」を入力して送信してください。
          <br>
          ※登録されたメールアドレスをお忘れの方はこちらの<a href="contact.html">お問い合わせ</a>より、直接お問い合わせください。
        </p>
        <input type="hidden" name="action_EntryComplete" value="true" />
        <input type="text" value="" name="email" placeholder="メールアドレスを入力して(半角英数字)下さい。">
        @if ($errors->has('email'))
        <span class="invalid-feedback" style="color: red; display: block">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif

        <input type="image" src="frontend/images/channel/pass-btn.png" 
          onmouseover="this.src='frontend/images/channel/pass-btn2.png'" onmouseout="this.src='frontend/images/channel/pass-btn.png'">
      </form>
    </div>
    @endif
  </div>
</div>
<!-- main -->
@endsection
