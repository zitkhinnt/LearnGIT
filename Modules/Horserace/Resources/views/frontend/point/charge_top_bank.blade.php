@extends('horserace::frontend.layouts.design')
@section('title','charge top bank')
@section('content')
<div class="title">チップ購入</div>

  {{--<div id="point">--}}

    {{--<div class="text-area">--}}

      <div id="txt-area">
        <div id="point">
          <p>下記のお申込み内容で宜しければ、「お申込みを確定する」を押して下さい。</p>
          <div class="p-title mt15">お申込み内容</div>
          <table>
            <tbody>
            <tr>
              <th colspan="2">商品</th>
            </tr>
            <tr>
              <td>{{ number_format($data['point']) }}pt</td>
              <td class="c-pay2">{{ number_format($data['price']) }}円</td>
            </tr>
            <tr>
              <th colspan="2">お支払い方法</th>
            </tr>
            <tr>
              <td colspan="2">銀行振込</td>
            </tr>
            </tbody>
          </table>
          
          <div class="center mt15 fade">
            <a href="{{ route("point.charge_top_bank_comp") }}" id="myBtn"
               onclick="event.preventDefault();checkExistBankSendid();">              
                   <p class="login-btn2">お申し込みを確定する</p>
            </a>

            {{--<form id="payment-top-bank" action="{{ route("point.charge_top_bank_comp") }}" method="POST"--}}
            {{--style="display: none;">--}}
            {{--@csrf--}}
            {{--<input type="hidden" name="price" value="{{ $data["price"] }}">--}}
            {{--<input type="hidden" name="point" value="{{ $data["point"] }}">--}}
            {{--<input type="hidden" name="method" value="{{ METHOD_BANK }}">--}}
            {{--<input type="hidden" name="checksum" value="{{ $data["checksum"] }}">--}}
            {{--</form>--}}

           

            <form id="payment-bank" action="{{ route("point.charge_top_bank") }}" method="POST"
                      style="display: none;">
                  @csrf
                <input type="hidden" name="price" value="{{$data["price"]}}">
                <input type="hidden" name="point" value="{{$data['point']}}">
                <input type="hidden" name="method" value="{{$data['method']}}">
                <input type="hidden" name="comfirm" value=true>
            </form>

            <form id="payment-top-bank"
                  action="https://secure.telecomcredit.co.jp/banktransfer/settle/transfer_request.pl"
                  method="POST"
                  style="display: none;">
              <input type="hidden" name="clientip" value="{{ CLIENT_ID }}">
              <input type="hidden" name="sendid" value="{{$data["login_id"] }}">
              <input type="hidden" name="money" value="{{$data["price"] }}">
              <input type="hidden" name="email" value="{{$data["mail_pc"] }}">
              {{--<input type="hidden" name="testmode" value="on">--}}
              {{--<input type="hidden" name="redirect_url" value="{{ route("home") }}">--}}
              <input type="hidden" name="redirect_back_url" value="{{ route("home", ["deposit" => "success"]) }}">
              <input id='checksum' type="hidden" name="option" value="{{isset($data["checksum"])?$data['checksum']:''}}">
            </form>
          </div>
          <p>※返品（返金）に関する特約：ポイントの返金は受け付けておりません。デジタルコンテンツでの情報サービスという商品の性質上、返金は行っておりません。また、返品依頼も受け付けておりません。</p>
        </div>
      </div>
    {{--</div>--}}
  {{--</div>--}}
  <script>

  //  @if(isset($data['checksum']))
  //   var checksum = document.getElementById('checksum').value;
  //   if(checksum!='')
  //     document.getElementById('payment-top-bank').submit();
  //  @endif
  // </script> 
    
@endsection

@section('javascript')
<script>
  function checkExistBankSendid() {
    var sendid = $('input[name ="sendid"]').val();
    if(sendid){
      if(sendid.length != 0){
        $('#myBtn').hide();
        document.getElementById('payment-top-bank').submit();
      }else{
        modal.style.display = "block";
      }
    }else{
      modal.style.display = "block";
    }
  }
</script>
<script>
  // Get the modal
  var modal = document.getElementById("myModal");
  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
    window.location.href= '{{ route('point') }}';
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
      window.location.href= '{{ route('point') }}';
    }
  }
</script>
@endsection

<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <h2>競艇オニアツ</h2>
    <p>送信内容が正しく取得できませんでした。再度購入操作をやり直して下さい。</p>
    <button class="close">OK</button>
  </div>
</div>
<style>
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content/Box */
  .modal-content {
    text-align: center;
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 300px; /* Could be more or less, depending on screen size */
  }
  .modal-content h2{
    margin: 14px 0px;
    font-size: 24px;
    line-height: 1.5em;
  }
  .modal-content p{
    margin: 14px 0px;
    padding: 0px;
    font-size: 20px;
    line-height: 1.5em;
  }

  /* The Close Button */
  .close {
    color: #352e2e;
    position: relative;
    font-size: 28px;
    font-weight: bold;
    border: none;
    background: none;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
</style>