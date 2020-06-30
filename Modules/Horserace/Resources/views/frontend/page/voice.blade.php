@extends('horserace::frontend.layouts.design')
@section('title','Voice')
@section('content')

  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/boat/login/title-voice.png') }}" width="860"
         height="92"/>
  </div>--}}
<div id="contents">
    <div class="title">{{isset($data['page']['name'])?$data['page']['name']:'的中実績'}}</div>
  <div id="voice">
    <div class="clearfix">
      {{--<div class="column-info">--}}
        @include('horserace::dynamic_page.voice')
      {{--</div>--}}
    </div>
  </div>
</div>
@endsection