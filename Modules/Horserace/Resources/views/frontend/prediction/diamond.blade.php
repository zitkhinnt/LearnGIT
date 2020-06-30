@extends('horserace::frontend.layouts.design')
@section('title','Diamond')
@section('content')

  <!-- main -->
  <div id="main" class="clearfix">

    <!--contents-left-->
    <div id="contents-left">
      <div id="contents-m">
        <div class="font">
          <p class="center title">今週の提供商品ラインナップ</p>

          @if (Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}"
                 style="height: 50px; font-size: 20px; text-align: center">
              {!! Session::get('flash_message') !!}
            </div>
          @endif

        </div>

        <p class="member-b">
          <img src="{{ asset('frontend/images/slide02.jpg') }}" width="100%"/>
        </p>

        @foreach($data["list_prediction"] as $item)
          <div class="contents-info">
            <p class="contents-img">
              @if( !is_null($item->img_banner))
                <img src="{{ asset($item->img_banner) }}"/>
              @endif
            </p>

            <!-- Show content -->
            @switch($item->show)
              @case("content")
              {!! $item->content !!}
              @break

              @case("after_buy")
              {!!  $item->after_buy !!}
              @break

              @case("result")
              {!!  $item->result !!}
              @break

              @default
              {!! $item->content !!}
              @break
            @endswitch

            <br>
            <!-- Show button -->
            {{--@switch($item->user_can_buy)--}}
              {{--@case(USER_CAN_NOT_BUY)--}}
              {{--@if($item->show == "result")--}}
                {{--<div class="btn-cam">--}}

                {{--</div>--}}
              {{--@endif--}}
              {{--@break--}}

              {{--@case(USER_CAN_BUY)--}}
              {{--@if($item->user_buy == NOT_BUY_PREDICTION)--}}
                {{--<form id="buy-prediction" method="POST" action="{{ route("buy_prediction") }}">--}}
                  {{--{{ csrf_field() }}--}}
                  {{--<input type="hidden" name="prediction_id" value="{{ $item->id }}">--}}
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
            @switch($item->status)
              @case(PREDICTION_STATUS_PREPARE)
              <div class="btn-cam">
                <a>
                  <img src="{{ asset('frontend/images/btn_prepare_off.png') }}"
                       width="600" height="120" alt=""/>
                </a>
              </div>
              @break

              @case(PREDICTION_STATUS_OPEN)
              @if($item->user_buy == NOT_BUY_PREDICTION)
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

        @endforeach


      </div>
    </div>
    <!--contents-left-->

    <!--contents-right-->
  @include('horserace::frontend.layouts.sidebar')
  <!--contents-right-->


  </div>
  <!-- main -->
@endsection