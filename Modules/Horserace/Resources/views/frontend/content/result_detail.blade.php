@extends('horserace::frontend.layouts.design')
@section('title','Column')
@section('content')
  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left" class="result-detail">
      <div id="result-bg">
        {{--<div class="font center title">的中実績</div>--}}
        <div class="center" style="margin-top: 20px"><h4>{{ $data['result_detail']->title }}</h4></div>
        <div class="column-info">
          {!! $data['result_detail']->content !!}<br>
        </div>
      </div>

      <div id="blog">
        <div class="blog_list">
          <ul>
            @foreach($data['result'] as $item)
              <li>
                <a href="{{ route('result_detail', $item->id) }}">
                  {{ date_format(date_create($item->public_at),"Y年m月d日") }}
                  {{ $item->title }}
                </a>
              </li>
            @endforeach
          </ul>
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