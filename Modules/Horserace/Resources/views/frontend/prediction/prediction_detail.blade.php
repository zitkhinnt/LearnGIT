@extends('horserace::frontend.layouts.design')
@section('title','Gold')
@section('content')
  	<!-- <div class="plan-head" >
		<a>{{$data["prediction"]->default_point}}</a>
    </div> -->

    <!-- group message flash -->
    @if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!}"
        style="height: 50px; font-size: 20px; text-align: center; margin-top: 30px">
    {!! Session::get('flash_message') !!}
    </div>
    @endif
    <div id="cam">
    <!-- group prediction image -->
    <div class="cam-area">
        @if( !is_null($data["prediction"]->img_banner))
        <img style="max-width: 100%;" src="{{ asset($data["prediction"]->img_banner) }}" />
        @endif
        <p class="cam-head">
                @switch($data['prediction_type']->code)
                @case(PREDICTION_TYPE_CODE_C1)
                    <img src="{{ asset('frontend/images/channel/login/banner01.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C2)
                    <img src="{{ asset('frontend/images/channel/login/banner02.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C3)
                    <img src="{{ asset('frontend/images/channel/login/banner03.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C4)
                    <img src="{{ asset('frontend/images/channel/login/banner04.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C5)
                    <img src="{{ asset('frontend/images/channel/login/banner05.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C6)
                    <img src="{{ asset('frontend/images/channel/login/banner06.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C7)
                    <img src="{{ asset('frontend/images/channel/login/banner07.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C8)
                    <img src="{{ asset('frontend/images/channel/login/banner08.png') }}" />
                    @break
                @case(PREDICTION_TYPE_CODE_C9)
                    <img src="{{ asset('frontend/images/channel/login/banner09.png') }}"/>
                    @break
                @case(PREDICTION_TYPE_CODE_C10)
                    <img src="{{ asset('frontend/images/channel/login/banner10.png') }}"/>
                    @break
                @default
                    @break
                @endswitch
        </p>

    </div>
    
    <!-- group prediction content -->
    <div class="cam">
    @if($data["prediction"]->show == 'result')
        {!!  $data["prediction"]->result !!}
    @else
        {!!  $data["prediction"]->after_buy !!}
    @endif
    </div>
</div>
@endsection
