@extends('horserace::frontend.layouts.design')
@section('title','charge top credit complete')
@section('content')

  <div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-point.png' )}}" width="860"
         height="92">
  </div>
  <div id="point">
    <div class="text-area">
      <div class="column-info">
        <div class="info">
          <p>決済が完了しました。<br>
            引き続き当サイトをご利用下さい。</p>
          <div class="p-title mt15">お申込み内容</div>
          <table>
            <tbody>
            <tr>
              <th colspan="2">商品</th>
            </tr>
            <tr>
              <td>30pt</td>
              <td class="c-pay2">3,000円</td>
            </tr>
            <tr>
              <th colspan="2">お支払い方法</th>
            </tr>
            <tr>
              <td colspan="2">銀行振込</td>
            </tr>
            </tbody>
          </table>
          <p>※1pt＝100円、返品に関する特約：デジタルコンテンツでの情報サービスという商品の性質上、返品・返金対応は行っておりません。 <br>
            ※お振込み確認が取れましたら「入金完了メール」を配信致します。<br>
          </p>

          <div class="center mt15 fade">
            <a href="index.html">
              <img src="frontend/images/channel/login/top-btn.png ') }}" alt="トップページへ戻る" width="400" height="80"
                   class="btn">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection