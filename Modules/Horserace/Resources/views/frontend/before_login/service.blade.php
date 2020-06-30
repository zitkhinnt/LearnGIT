@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
  <!-- main -->
  <div id="contents">
    <div class="title">{{isset($data['page']['name'])?$data['page']['name']:'ご利用規約'}}</div>   
      <div class="text-area02">        
          @include('horserace::dynamic_page.agree')       
      </div> 
  </div>

  <!-- main -->
@endsection