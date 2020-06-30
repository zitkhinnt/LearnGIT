@extends('horserace::frontend.layouts.design')
@section('title','My page')
@section('content')

  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-mypage.png')}}" width="860"
         height="92"/>
  </div>--}}
  <div class="title">マイページ</div>
  <div id="txt-area">
    <div id="change-area">

      <!--change info-->
      <div class="column-info">
        <div class="info">
          <p class="p-title">お客様情報変更</p>
          <p>お客様情報の変更が可能です。</p>
          <form action="{{ route('mypage.change.info') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="id" value="{{ Auth::id() }}">
            <table>
              <tbody>
              <tr>
                <th>お名前&nbsp;(ハンドルネーム)</th>
                <td>
                  <input type="text" name="nickname" value="{{ Auth::user()->nickname }}" class="form-txt01"/>
                  {{--@if ($errors->has('nickname'))
                    <span style="color: red; display: block">
                      <strong>{{ $errors->first('nickname') }}</strong>
                    </span>
                  @endif--}}
                </td>
              </tr>
              <tr>
                <th>性別</th>
                <td>
                  <label for="sex_cd_1">
                    <input type="radio" name="gender" value="{{ MALE }}" id="sex_cd_1"
                      {{ Auth::user()->gender == MALE ? "checked='checked'" : "" }} />男性
                  </label>&nbsp;&nbsp;&nbsp;
                  <label for="sex_cd_2">
                    <input type="radio" name="gender" value="{{ FEMALE }}" id="sex_cd_2"
                      {{ Auth::user()->gender == FEMALE ? "checked='checked'" : "" }} />女性
                  </label>
                </td>
              </tr>
              <tr>
                <th>年代</th>
                <td>
                  <select id="select" name="age" class="form-txt02">
                    <option value="{{ AGE_USER_20 }}"
                      {{ Auth::user()->age == AGE_USER_20 ? "selected" : "" }}>
                      {{ __("horserace::be_form.age_20") }}
                    </option>
                    <option value="{{ AGE_USER_30 }}"
                      {{ Auth::user()->age == AGE_USER_30 ? "selected" : "" }}>
                      {{ __("horserace::be_form.age_30") }}
                    </option>
                    <option value="{{ AGE_USER_40 }}"
                      {{ Auth::user()->age == AGE_USER_40 ? "selected" : "" }}>
                      {{ __("horserace::be_form.age_40") }}
                    </option>
                    <option value="{{ AGE_USER_50 }}"
                      {{ Auth::user()->age == AGE_USER_50 ? "selected" : "" }}>
                      {{ __("horserace::be_form.age_50") }}
                    </option>
                    <option value="{{ AGE_USER_60 }}"
                      {{ Auth::user()->age == AGE_USER_60 ? "selected" : "" }}>
                      {{ __("horserace::be_form.age_60") }}
                    </option>
                    <option value="{{ AGE_USER_70 }}"
                      {{ Auth::user()->age == AGE_USER_70 ? "selected" : "" }}>
                      {{ __("horserace::be_form.age_70") }}
                    </option>
                  </select>
                </td>
              </tr>
            </tbody>
            </table>
            <div class="center">
              {{--<input type="image" src="{{ asset('frontend/images/channel/login/change-btn.png' )}}"
                     class="btn">--}}
                     <button type="submit" name="submit" value="1" class="login-btn2">変更する</button>
            </div>
          </form>
        </div>
      </div>

      <!--change mail pc-->
      <div class="column-info">
        <div class="info">
          <p class="p-title">PCメールアドレス変更</p>
          <p>PCメールアドレスの変更が可能です。 </p>
          <p>メールアドレスの受信制限をされている場合は、登録完了メールが受け取れないことがあります。 </p>
          <p>ドメイン指定受信設定を行って下さい。</p>
          <form action="{{ route('mypage.change.mail_pc') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="id" value="{{ Auth::id() }}">
            <input type="hidden" name="mail_pc" value="{{ Auth::user()->mail_pc }}">
            <input type="hidden" name="key_login" value="{{ Auth::user()->user_key }}">
            <table>
              <tr>
                <th>現在のEメールアドレス</th>
                <td>{{ Auth::user()->mail_pc }}</td>
              </tr>
              <tr>
                <th>新しいEメールアドレス</th>
                <td>
                  <input value="" type="email" name="new_mail_pc" id="new_mail_pc"  class="form-txt01"/>
                  @if ($errors->has('mail_pc'))
                    <span style="color: red; display: block">
                       <strong>{{ $errors->first('mail_pc') }}</strong>
                    </span>
                  @elseif(Session::has('flash_level')!=null && Session::get('flash_level')=='exit')
                  <span style="color: red; display: block">
                    <strong>{{Session::get('flash_message')}}</strong>
                  </span>                   
                  @endif
                </td>
              </tr>
            </table>

            <div class="center">
              {{--<input type="image" src="{{ asset('frontend/images/channel/login/change-btn.png' )}}"
                     class="btn">--}}
                     <button type="submit"  id="myBtn" class="login-btn2" onclick="verifyChangeNewMail();">変更する</button>
            </div>
          </form>
        </div>
      </div>


      <!--change mail mobile-->
      <div class="column-info">
        <div class="info">
          <p class="p-title">携帯メールアドレス変更</p>
          <p>携帯携帯メールアドレスの変更が可能です。 </p>
          <p>メールアドレスの受信制限をされている場合は、登録完了メールが受け取れないことがあります。 </p>
          <p>ドメイン指定受信設定を行って下さい。</p>
          <form action="{{ route('mypage.change.mail_mobile') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="id" value="{{ Auth::id() }}">
            <table>
              <tr>
                <th>現在の携帯Eメールアドレス</th>
                <td>{{ Auth::user()->mail_mobile }}</td>
              </tr>
              <tr>
                <th>新しいEメールアドレス</th>
                <td>
                  <input value="" type="email" name="mail_mobile" class="form-txt01"/>
                  @if ($errors->has('mail_mobile'))
                    <span style="color: red; display: block">
                      <strong>{{ $errors->first('mail_mobile') }}</strong>
                    </span>
                    @elseif(Session::has('flash_level')!=null && Session::get('flash_level')=='exit_email_mobile')
                    <span style="color: red; display: block">
                      <strong>{{Session::get('flash_message')}}</strong>
                    </span> 
                  @endif
                </td>
              </tr>
            </table>

            <div class="center">
              {{--<input type="image" src="{{ asset('frontend/images/channel/login/change-btn.png' )}}"
                     class="btn">--}}
                     <button type="submit" name="submit" value="1" class="login-btn2">変更する</button>
            </div>
          </form>
        </div>
      </div>

      <!--change password-->
      <div class="column-info">
        <div class="info">
          <p class="p-title">パスワード変更</p>
          <p>パスワードの変更が可能です。</p>
          <form action="{{ route('mypage.change.password') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="id" value="{{ Auth::id() }}">
            <table class="sp_hidden_table">
              <tr>
                <th>ID番号</th>
                <td>{{ Auth::user()->login_id }}</td>
              </tr>
              <tr>
                <th>現在のパスワード</th>
                <td>{{ Auth::user()->password_text }}</td>
              </tr>
              <tr>
                <th>新しいパスワード</th>
                <td>
                  <input type="password" name="password" class="form-txt01"/>
                  @if ($errors->has('password'))
                    <span style="color: red; display: block">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>確認の為再度入力</th>
                <td>
                  <input type="password" name="password_confirm" class="form-txt01"/>
                  @if ($errors->has('password_confirm'))
                    <span style="color: red; display: block">
                      <strong>{{ $errors->first('password_confirm') }}</strong>
                    </span>
                  @endif
                </td>
              </tr>
            </table>
            <div class="center">
              {{--<input type="image" src="{{ asset('frontend/images/channel/login/change-btn.png' )}}"
                     class="btn">--}}
                     <button type="submit" name="submit" value="1" class="login-btn2">変更する</button>

            </div>
          </form>
        </div>
      </div>


    </div>
  </div>
@endsection
@section('javascript')

<script>
  function verifyChangeNewMail() { 
      var input_mail = $('#new_mail_pc').val();
      if(input_mail!=''){
        modal.style.display = "block";
      }
    }
</script>
<script>
  // Get the modal
  var modal = document.getElementById("myModal");
  // Get the button that opens the modal
  var btn = document.getElementById("myChangeMailPC");
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
@endsection
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <h2>確認</h2>
    <p> 新しいメールアドレスに確認メールが送られます。メールの内容に従い、処理を完了してください。.</p>
    <button class="close">OK</button>
  </div>
</div>
<style>
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content/Box */
  .modal-content {
    text-align: center;
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 300px; /* Could be more or less, depending on screen size */
  }
  .modal-content h2{
    margin: 14px 0px;
    font-size: 24px;
    line-height: 1.5em;
  }
  .modal-content p{
    margin: 14px 0px;
    padding: 0px;
    font-size: 20px;
    line-height: 1.5em;
  }

  /* The Close Button */
  .close {
    color: #352e2e;
    position: relative;
    font-size: 28px;
    font-weight: bold;
    border: none;
    background: none;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
</style>