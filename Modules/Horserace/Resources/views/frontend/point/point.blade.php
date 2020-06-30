@extends('horserace::frontend.layouts.design')
@section('title','Point')
@section('content')

  {{--<div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-point.png') }}" width="860" height="92"/>
  </div>--}}
  <div class="title">チップ購入</div>

  {{--<div id="point">--}}

    {{--<div class="text-area">--}}

      <div id="txt-area">
        @if (Session::has('flash_message'))
          <p style="color: red;"> {!! Session::get('flash_message') !!}</p>
        @endif
        <div id="point">
          <p>下記チップ一覧から購入したいチップを選択して「お支払い方法を選択する」を押して下さい。</p>
          <p>決済方法は「銀行振込」「クレジット決済」等、各種ご用意しております。
            ※消費税（10％）込みの決済金額となります。</p>
          <form action="{{ route('point.charge_top_confirm') }}" method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <table>
              @foreach($data['point'] as $item)
                <tr>
                  <td class="c-point">
                    <input type="radio" name="id" id="point1" value="{{ $item->id }}" required/>
                  </td>
                  <td><label for="point1">{{ number_format($item->point) }}チップ</label></td>
                  <td class="c-pay"><p class="center"><label for="point1">{{ number_format($item->price) }}円</label>
                    </p></td>
                </tr>
              @endforeach
            </table>
            <div class="center">
                <button type="submit" name="submit" value="1" class="login-btn2">お支払方法を選択する</button>
              
            </div>
          </form>
        </div>
      </div>
    {{--</div>--}}
  {{--</div>--}}
@endsection