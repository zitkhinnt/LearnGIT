@extends('horserace::frontend.layouts.design')
@section('title','Privacy')
@section('content')

  <div id="contents">
      <div class="title">{{isset($data['page']['name'])?$data['page']['name']:'プライバシーポリシー'}}</div>
      <div id="txt-area">
        @include('horserace::dynamic_page.privacy')
      </div>
  </div>
@endsection