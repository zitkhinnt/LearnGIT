@extends('horserace::frontend.layouts.design')
@section('title','About 01')
@section('content')

  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      @include('horserace::dynamic_page.about_one')
    </div>
    <!--contents-left-->

    <!-- content right -->
  @include('horserace::frontend.layouts.sidebar')
  <!-- end content right -->

  </div>
  <!-- main -->
@endsection