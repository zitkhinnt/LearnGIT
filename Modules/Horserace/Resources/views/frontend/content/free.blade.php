@extends('horserace::frontend.layouts.design')
@section('title','Column')
@section('content')
<!-- main -->
<div id="cam">
  <div class="cam-area">
    <img src="{{ asset('frontend/images/channel/login/c01.png') }}" alt="">
    <p class="cam-head">
      <img src="{{ asset('frontend/images/channel/login/banner01.png') }}" alt="">
    </p>
  </div>
  <div class="cam">
    @if(!isset($data['no_blog']))
      {!! $data['blog_detail']->content !!}
    @endif
  </div>

</div>
<!-- main -->
@endsection