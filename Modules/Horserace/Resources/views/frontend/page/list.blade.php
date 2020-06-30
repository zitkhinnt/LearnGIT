@extends('horserace::frontend.layouts.design')
@section('title','List')
@section('content')

  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      @include('horserace::dynamic_page.list')
    </div>
    <!--contents-left-->

    <!--contents-right-->
  @include('horserace::frontend.layouts.sidebar')
  <!--contents-right-->


  </div>
  <!-- main -->
@endsection