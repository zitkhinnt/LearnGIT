@extends('horserace::frontend.layouts.design')
@section('title','About')
@section('content')
<div id="contents">
<div class="title">{{isset($data['page']['name'])?$data['page']['name']:'初心者ガイド'}}</div>
  <!-- main -->


    <!--contents-left-->

    <div id="txt-area">
      @include('horserace::dynamic_page.about')
      {{--<div class="btn-area">
          <a href={{route('point')}}><img style="margin: auto;"  src= "{{asset('frontend/images/boat/login/a-btn01.png')}}"/></a>
      </div>--}}
    </div>
    <!--contents-left-->

    <!--contents-right-->
  @include('horserace::frontend.layouts.sidebar')
  <!--contents-right-->


  
</div>

  <!-- main -->
@endsection