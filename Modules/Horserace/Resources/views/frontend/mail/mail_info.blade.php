@extends('horserace::frontend.layouts.design')
@section('title','Mail info')
@section('content')

  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-mail.png') }}" width="860" height="92">
  </div>--}}

  <div id="txt-area">
    <div class="text-area" style="white-space: pre-line;">
      @if(is_null($data["mail"]))
      @else
        <div class="column-info">
          <p>{{ date_format(date_create($data['mail']->created_at), "Y-m-d") }}</p>
          <p class="mail-title">
            {!! $data["mail"]->mail_title !!}
          </p>
          {!! $data["mail"]->mail_body !!}
          <div class="back">
            <a href="{{ route('mail_box') }}">
              メールBOXに戻る
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
  </div>
@endsection