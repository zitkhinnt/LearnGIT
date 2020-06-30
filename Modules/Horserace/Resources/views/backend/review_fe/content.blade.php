@extends('horserace::backend.review_fe.design')
@section('title','Column')
@section('content')
  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      <div id="column">
        <div class="font center title">限定コラム</div>
        <div class="center">{{ $data->title }}</div>
        <div class="column-info">
          <p class="column-img"><img src="{{ asset('frontend/images/column01.jpg') }}"/></p>
          {!! $data->content !!}<br>
        </div>
      </div>
    </div>
    <!--contents-left-->

    <!--contents-right-->
  @include('horserace::backend.review_fe.sidebar')
  <!--contents-right-->


  </div>
  <!-- main -->
@endsection