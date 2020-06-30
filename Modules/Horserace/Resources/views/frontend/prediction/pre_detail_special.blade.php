@extends('horserace::frontend.layouts.design')
@section('title','Crystal')
@section('content')

  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      <div id="column">
        <div class="font">
          <p class="center title">特別情報</p>

          @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}"
                 style="height: 50px; font-size: 20px; text-align: center">
              {!! Session::get('flash_message') !!}
            </div>
          @endif

        </div>

        <div class="column-info">
          <p class="column-img">
            @if( !is_null($data["prediction"]->img_banner))
              <img src="{{ asset($data["prediction"]->img_banner) }}"/>
            @endif
          </p>

          <!-- Show content -->
          @switch($data["prediction"]->show)
            @case("content")
            {!! $data["prediction"]->content !!}
            @break

            @case("after_buy")
            {!!  $data["prediction"]->after_buy !!}
            @break

            @case("result")
            {!!  $data["prediction"]->result !!}
            @break

            @default
            {!! $data["prediction"]->content !!}
            @break
          @endswitch

          <br>
          <!-- Show button -->
          {{--@switch($data["prediction"]->user_can_buy)--}}
            {{--@case(USER_CAN_NOT_BUY)--}}
            {{--@if($data["prediction"]->show == "result")--}}
              {{--<div class="btn-cam">--}}

              {{--</div>--}}
            {{--@endif--}}
            {{--@break--}}

            {{--@case(USER_CAN_BUY)--}}
            {{--@if($data["prediction"]->user_buy == NOT_BUY_PREDICTION)--}}
              {{--<form id="buy-prediction" method="POST" action="{{ route("buy_prediction") }}">--}}
                {{--{{ csrf_field() }}--}}
                {{--<input type="hidden" name="prediction_id" value="{{ $data["prediction"]->id }}">--}}
                {{--<div class="btn-cam">--}}
                  {{--<a href="{{ route("buy_prediction") }}"--}}
                     {{--onclick="event.preventDefault(); document.getElementById('buy-prediction').submit();">--}}
                    {{--<img src="{{ asset('frontend/images/btn-cam01_off.png') }}"--}}
                         {{--width="600" height="120" alt=""/>--}}
                  {{--</a>--}}
                {{--</div>--}}
              {{--</form>--}}
            {{--@else--}}
              {{--<div class="btn-cam">--}}

              {{--</div>--}}
            {{--@endif--}}
            {{--@break--}}

            {{--@default--}}

            {{--@break--}}
          {{--@endswitch--}}

          <!-- Status -->
          @switch($data["prediction"]->status)
            @case(PREDICTION_STATUS_PREPARE)
            <div class="btn-cam">
              <a>
                <img src="{{ asset('frontend/images/btn_prepare_off.png') }}"
                     width="600" height="120" alt=""/>
              </a>
            </div>
            @break

            @case(PREDICTION_STATUS_OPEN)
            @if($data["prediction"]->user_buy == NOT_BUY_PREDICTION)
              <form id="buy-prediction" method="POST" action="{{ route("buy_prediction") }}">
                {{ csrf_field() }}
                <input type="hidden" name="prediction_id" value="{{ $item->id }}">
                <div class="btn-cam">
                  <a href="{{ route("buy_prediction") }}"
                     onclick="event.preventDefault(); document.getElementById('buy-prediction').submit();">
                    <img src="{{ asset('frontend/images/btn_open_off.png') }}"
                         width="600" height="120" alt=""/>
                  </a>
                </div>
              </form>
            @else
              <div class="btn-cam">
                <a>
                  <img src="{{ asset('frontend/images/btn_bought_off.png') }}"
                       width="600" height="120" alt=""/>
                </a>
              </div>
            @endif
            @break

            @case(PREDICTION_STATUS_REMAIN)
            <div class="btn-cam">
              <a>
                <img src="{{ asset('frontend/images/btn_remain_off.png') }}"
                     width="600" height="120" alt=""/>
              </a>
            </div>
            @break

            @case(PREDICTION_STATUS_DONE)
            <div class="btn-cam">
              <a>
                <img src="{{ asset('frontend/images/btn_done_off.png') }}"
                     width="600" height="120" alt=""/>
              </a>
            </div>
            @break

            @default

            @break
          @endswitch

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