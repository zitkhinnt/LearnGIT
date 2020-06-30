@extends('horserace::frontend.layouts.design')
@section('title','Column')
@section('content')
<!-- main -->
<div id="main" class="clearfix">

  <!--contents-left-->
  <div id="contents-left" class="blog-detail">
    <div id="column">
      <div class="font center title">限定コラム</div>
      <div class="center" style="margin-top: 20px"><h4>{{ $data['blog_detail']->title }}</h4></div>
      <div class="column-info">
        {!! $data['blog_detail']->content !!}<br>
      </div>
    </div>
    <div id="blog">
      <div class="blog_list">
        <ul>
          @foreach($data['blog'] as $item)
          <li>
            <a href="{{ route('blog_detail', $item->id) }}" style="color: black">

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

</div>
<!-- main -->
@endsection