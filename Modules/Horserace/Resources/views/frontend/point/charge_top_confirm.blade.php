@extends('horserace::frontend.layouts.design')
@section('title','charge top confirm')
@section('content')

<div class="title">チップ購入</div>

  {{--<div id="point">--}}

   {{-- <div class="text-area">--}}

      <div id="txt-area">
        <div id="point">
          <p>お申込み内容をご確認を頂けましたら、決済方法をお選び下さい。</p>
          <div class="p-title mt15">お申込み内容</div>
          <table>
            <tbody>
            <tr>
              <td><label for="point1">{{ number_format($data['point_detail']->point) }}pt</label></td>
              <td class="c-pay2"><label for="point1">{{ number_format($data['point_detail']->price) }}円</label></td>
            </tr>
            </tbody>
          </table>
          <p>下記「お支払い方法」を選択してください。</p>
          
          <div class="p-title mt15">銀行振込</div>   

          <div id="payment" class="fade">
            {{--bank--}}
            <ul class="clearfix">
              <li>
                <a href="{{ route("point.charge_top_bank") }}"
                   onclick="event.preventDefault(); document.getElementById('payment-bank').submit();">
                  <img src="{{ asset('frontend/images/channel/login/payment_bank.png') }}" width="230">
                </a>

                <form id="payment-bank" action="{{ route("point.charge_top_bank") }}" method="POST"
                      style="display: none;">
                  @csrf
                  <input type="hidden" name="price" value="{{$data['point_detail']->price }}">
                  <input type="hidden" name="point" value="{{ $data['point_detail']->point }}">
                  <input type="hidden" name="method" value="{{ METHOD_BANK }}">
                </form>
              </li>
              <li>
                お振込決済の際は、お客様会員IDでのお振込をお願い致します。<br>
                お名前でのご入金をされた場合は、お手数ではございますがサポートまでご一報頂けますようお願い申し上げます。<br>
                <br>
                ※土日のお振込受付に関して<br>
                銀行営業時間外のお振込みは､ご入金の確認が取れませんので 大変申し訳ございませんが対応致しかねます。<br>
                何卒ご理解ご了承頂きますようお願い申し上げます。
              </li>
            </ul> 
            <a href="{{ route("point.charge_top_bank") }}" onclick="event.preventDefault(); document.getElementById('payment-bank').submit();"><p class="login-btn2">銀行振込</p></a>
            <div class="p-title mt15">クレジットカード</div>
            
            {{--create card--}}
            <ul class="clearfix">
              <li>
                <a href="{{ route("point.charge_top_credit") }}"
                   onclick="event.preventDefault(); document.getElementById('payment-credit').submit();">
                  <img src="{{ asset('frontend/images/channel/login/payment_credit.png') }}" width="230"">
                  
                </a>
                <form id="payment-credit" action="{{ route("point.charge_top_credit") }}" method="POST"
                      style="display: none;">
                  @csrf
                  <input type="hidden" name="price" value="{{$data['point_detail']->price }}">
                  <input type="hidden" name="point" value="{{ $data['point_detail']->point }}">
                  <input type="hidden" name="method" value="{{ METHOD_CREDIT }}">
                </form>

              </li>
              <li>
                VISA、JCB、MasterCard のマークが付いているクレジットカードがご利用になれます。<br>
                メンテナンス日を除き土・日・祝日を含む365日、24時間いつでもご利用頂けます。
              </li>
            </ul>
            <a href="{{ route("point.charge_top_credit") }}" onclick="event.preventDefault(); document.getElementById('payment-credit').submit();"><p class="login-btn2">クレジットカード</p></a>
          </div>
        </div>
      </div>
   {{-- </div> --}}
 {{-- </div>--}}
@endsection