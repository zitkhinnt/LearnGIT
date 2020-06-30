@extends('horserace::frontend.layouts.design')
@section('title','charge top bank complete')
@section('content')

  <div class="plan-head">
    <img src="{{ asset('frontend/images/channel/login/title-point.png' )}}" width="860" height="92">
  </div>

  <div id="point">

    <div class="text-area">

      <div class="column-info">
        <div class="info">
          <p>払込予約が完了しました。 下記振込先までお振込み手続きをお願いします。<br>
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

          <table>
            <tbody>
            <tr>
              <th>銀行名</th>
              <td>楽天銀行</td>
            </tr>
            <tr>
              <th>支店番号</th>
              <td>第二営業支店&nbsp;（252）</td>
            </tr>
            <tr>
              <th>口座番号</th>
              <td>普通&nbsp;：&nbsp;00000</td>
            </tr>
            <tr>
              <th>口座名義</th>
              <td>アアアアアア</td>
            </tr>
            </tbody>
          </table>

          <p>ＩＤ番号にてお振込みできない場合は、お名前にてお振込み後、 サポートデスクまでお振込みされたお名前をご連絡下さいますようお願い致します。 <br>
            <br>
            ※尚、ご連絡がない場合は、弊社では責任を負いかねますのでご注意下さい。 <br>
            ※お振込から入金確認まで若干時間がかかる場合がございます。 <br>
            ※お振込み手数料は、お客様のご負担となります。ご了承下さい。 <br>
            ※1pt＝100円、返品に関する特約：デジタルコンテンツでの情報サービスという商品の性質上、返品・返金対応は行っておりません。 <br>
            ※午後3時以降にご入金頂いた場合のご入金確認は翌銀行営業日の扱いです。 <br>
            ※お振込み確認が取れましたら「入金完了メール」を配信致します。<br>
          </p>

          <div class="center mt15 fade">
            <a href="{{ route("home") }}">
              <img src="{{ asset('frontend/images/channel/login/top-btn.png' )}}" alt="トップページへ戻る" width="400"
                   height="80" class="btn">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection