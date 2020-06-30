@extends('horserace::frontend.layouts.design')
@section('title','Gold')
@section('content')

  	<!-- <div class="plan-head" >
		<a>{{$data["prediction"]->default_point}}</a>
    </div> -->

    <!-- group message flash -->
    @if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!}"
        style="height: 50px; font-size: 20px; text-align: center">
    {!! Session::get('flash_message') !!}
    </div>
    @endif

    <div id="cam">
    <!-- group prediction image -->
        <div class="cam-area">
            {{-- @if( !is_null($data["prediction"]->img_banner)) --}}
            <img style="max-width: 100%;" src="{{ asset($data["prediction"]->img_banner) }}" />
            {{-- @endif --}}
            <p class="cam-head">
                @switch($data['prediction']->prediction_type)
                @case(1)
                    <img src="{{ asset('/frontend/images/channel/login/banner01.png') }}" />
                    @break
                @case(2)
                    <img src="{{ asset('/frontend/images/channel/login/banner02.png') }}" />
                    @break
                @case(3)
                    <img src="{{ asset('/frontend/images/channel/login/banner03.png') }}" />
                    @break
                @case(4)
                    <img src="{{ asset('/frontend/images/channel/login/banner04.png') }}" />
                    @break
                @case(5)
                    <img src="{{ asset('/frontend/images/channel/login/banner05.png') }}" />
                    @break
                @case(6)
                    <img src="{{ asset('/frontend/images/channel/login/banner06.png') }}" />
                    @break
                @case(7)
                    <img src="{{ asset('/frontend/images/channel/login/banner07.png') }}" />
                    @break
                @case(8)
                    <img src="{{ asset('/frontend/images/channel/login/banner08.png') }}" />
                    @break
                @case(9)
                    <img src="{{ asset('/frontend/images/channel/login/banner09.png') }}"/>
                    @break
                @case(10)
                    <img src="{{ asset('/frontend/images/channel/login/banner10.png') }}"/>
                    @break
                @default
                    @break
                @endswitch
            </p>
        </div>
    
    <!-- group prediction content -->
        <div class="cam">
        @if($data['content'] == PREDICTION_TYPE_CONTENT_CONTENT)
            {!! $data["prediction"]->content !!}
        @endif

        @if($data['content'] == PREDICTION_TYPE_CONTENT_AFTER_BUY )
            {!!  $data["prediction"]->after_buy !!}
        @endif

        @if($data['content'] == PREDICTION_TYPE_CONTENT_RESULT)
            {!!  $data["prediction"]->result !!}
        @endif
        </div>
    </div>
@endsection
