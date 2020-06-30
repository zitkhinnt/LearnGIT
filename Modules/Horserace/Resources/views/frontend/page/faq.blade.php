@extends('horserace::frontend.layouts.design')
@section('title','FAQ')
@section('content')

  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      <div id="faq">
        <div class="font center title">よくある質問</div>

        <div class="column-info">
          @include('horserace::dynamic_page.faq')
        </div>

      </div>
    </div>
    <!--contents-left-->

    <!--contents-right-->
  @include('horserace::frontend.layouts.sidebar')
  <!--contents-right-->


  </div>
  <!-- main -->
@endsection