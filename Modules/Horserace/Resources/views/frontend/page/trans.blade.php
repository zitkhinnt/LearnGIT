@extends('horserace::frontend.layouts.design')
@section('title','Trans')
@section('content')

  <div id="contents">
      <div class="title">{{isset($data['page']['name'])?$data['page']['name']:'特定商取引法'}}</div>
      <div id="txt-area">
        <div id="trans">
          <div class="text-area">
            <div class="column-info">
              @include('horserace::dynamic_page.trans')
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection