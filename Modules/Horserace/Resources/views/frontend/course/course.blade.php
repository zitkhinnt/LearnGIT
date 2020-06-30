@extends('horserace::frontend.layouts.design')
@section('title','Course')
{{---@section('wide_slider') 

<div class="wideslider" style="height: 310px;">
  <ul>
    
  <li><a href="{{route('about')}}"><img src="{{ asset('frontend/images/channel/login/slide01.jpg') }}"></a></li>
  <li><a href="{{route('voice')}}"><img src="{{ asset('frontend/images/channel/login/slide02.jpg') }}"></a></li>
  <li><a href="{{route('result')}}"><img src="{{ asset('frontend/images/channel/login/slide03.jpg')}}"></a></li>
  </ul>
</div>
@endsection--}}

@section('content') 
<!-- Header -->  

  <!--contents-right-->

<!-- Contents -->  
<div id="contents">
    <div class="title">コース一覧</div>
@if(isset($data))

  <?php
      $array_pre_type_key_code = [];
      foreach ($data as $obj_pre)
      {
        $array_pre_type_key_code[$obj_pre->code] = $obj_pre;        
      }     
       
  ?>

  <div id="course">
      <ul>
          <li><a href="{{ route('free') }}"><img src="{{ asset('frontend/images/channel/login/banner01.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C2]) }}"><img src="{{ asset('frontend/images/channel/login/banner02.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C3]) }}"><img src="{{ asset('frontend/images/channel/login/banner03.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C4]) }}"><img src="{{ asset('frontend/images/channel/login/banner04.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C5]) }}"><img src="{{ asset('frontend/images/channel/login/banner05.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C6]) }}"><img src="{{ asset('frontend/images/channel/login/banner06.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C7]) }}"><img src="{{ asset('frontend/images/channel/login/banner07.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C8]) }}"><img src="{{ asset('frontend/images/channel/login/banner08.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C9]) }}"><img src="{{ asset('frontend/images/channel/login/banner09.png')}}"/></a></li>
          <li><a href="{{ route('pre_list', ['prediction_type_code' => PREDICTION_TYPE_CODE_C10]) }}"><img src="{{ asset('frontend/images/channel/login/banner10.png')}}"/></a></li>

      </ul>
  </div>
    
  
</div>
  <!--contents-right-->
  
 

  <!-- </div> -->
  <!-- main -->
  @endif
  @endsection