@extends('horserace::frontend.layouts.design')
@section('title','Argree')
@section('content')

  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-agree.png') }}" width="860"
         height="92"/>
  </div>--}}
  <div id="contents">
      <div class="title">{{isset($data['page']['name'])?$data['page']['name']:'ご利用規約'}}</div> 
  {{--<div class="text-area">--}}
    {{--<div class="column-info">--}}
      <div id="txt-area">
        @include('horserace::dynamic_page.agree')
      </div>
    {{--</div>--}}
  {{--</div>--}}
    </div>
@endsection