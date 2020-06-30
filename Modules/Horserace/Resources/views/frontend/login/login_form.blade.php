@extends('horserace::frontend.layouts.before_login.design')
@section('title','Login')
@section('content')
<div id="contents">
    <div class="title">会員ログイン</div>
        <div class="form">
            <div class="form02-txt">
                <form action="{{ route('login.submit') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="action_EntryComplete" value="true" />
                    <input type="text" value="" name="login_id" placeholder="ID" id="login_id">
                    <br>
                    <input type="text" value="" name="password" placeholder="PASS" id="password">
                    <br>
                    <input type="image" src="{{ asset('frontend/images/channel/login-btn.png') }}" onmouseover="this.src='{{ asset('frontend/images/channel/login-btn2.png') }}'" onmouseout="this.src='{{ asset('frontend/images/channel/login-btn.png') }}'" /><br>
                    <p><a href="{{ route('password_forget') }}">▶パスワードを忘れた方はこちら</a></p>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="user fade">
        <form action="{{ route('login.submit') }}" method="post" >
  
          {{ csrf_field() }}
          <table>
            <tbody>
            <tr>
              <th scope="row">ログインID</th>
              <td><input id="login_id" type="text" name="login_id" value=""></td>
              <td rowspan="2"><input type="submit" value="ログイン" class="sbtn"></td>
            </tr>
            <tr>
              <th scope="row">パスワード</th>
              <td><input id="password" type="password" name="password" value=""></td>
            </tr>
            </tbody>
          </table>
        </form>
  
      </div>
    </div> --}}
@endsection