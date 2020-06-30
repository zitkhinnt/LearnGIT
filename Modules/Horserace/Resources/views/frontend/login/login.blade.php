@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
  <!-- main -->
  <div id="contents">
    <div class="bg01">
        <img src="{{ asset('frontend/images/channel/top01.png') }}"/>
    </div>
    <div class="bg02">
        <img class="sp-none" src="{{ asset('frontend/images/channel/top02.png') }}"/>
        <img class="pc-none" src="{{ asset('frontend/images/channel/sp-top02.png') }}"/>
        <span class="human">
            <img src="{{ asset('frontend/images/channel/bg01.svg') }}" width="100%">
        </span>
    </div>
    <div class="bg03">
        <img src="{{ asset('frontend/images/channel/top03.jpg') }}"/>
    </div>
    <div class="bg04">
        <img src="{{ asset('frontend/images/channel/top04.png') }}"/>
    </div>
    <div class="form">
        <div class="form-area">
            <div class="form-txt fade">
                <p hidden><img src="{{asset($data['frontendimages'][IMAGE_FRONTEND_CODE_ATTENTION]['image'])}}" width="730"/></p>
                <p class="f-man" hidden><img src="{{ asset('frontend/images/channel/form02.png') }}" width="730"/></p>

                <div class="pc-none">
                    <div class="top-ar"><img src="{{ asset('frontend/images/channel/top-ar.png') }}"></div>
                    <div class="form-txt">
                      下記ボタンより空メールを送信してください	。
                      <form action="{{ route("register") }}" method="post">
                        {{ csrf_field() }}          
                        <input type="hidden" name="ref" value="{{ $data["ref"] }}">
                        <p class="f-com">当サイトの情報を入手するアドレスを入力して下記のボタンを押して下さい</p>
                        <input type="email" placeholder="メールアドレスを入力してください"
                              class="form-controll email-txt" name="email"
                              value="" required>
                        @if ($errors->has('email'))
                          <span class="invalid-feedback" style="color: red; display: block">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                        <input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
                      </form>
                    </div>
                  </div>

                <form action="{{ route("register") }}" method="post" class="sp-none">
                  {{ csrf_field() }}          
                  <input type="hidden" name="ref" value="{{ $data["ref"] }}">
                  <div class="top-ar sp-none"><img src="{{ asset('frontend/images/channel/top-ar.png') }}"></div>
                  <p class="f-com">メールアドレス入力後、下のボタンを押してください。</p>
                  <input type="email" placeholder="メールアドレスを入力してください"
                        class="form-controll email-txt" name="email"
                        value="" required>
                  @if ($errors->has('email'))
                    <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                  <input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
                </form>
                <p class="f-com02">※20歳未満の方はご利用頂けません。<br>
                  ※注 メール受信に制限設定をしている方は、お手数ですが『info@keirin-ch.com』からのメールを受け取れる様に設定して下さい。<br>
                  また、yahooメール、gmailなどのフリーメールの場合、迷惑メールフォルダに配信される、またはメールそのものが届かない可能性が御座いますのでご注意下さい。<br>
                </p>

                <!-- <div class="pc-none">
                  <div class="form-txt">下記ボタンより空メールを送信してください。
                    <div class="m-btn btn">
                      <a href="mailto:{{REGISTER_USERNAME}}?subject=「競輪チャンネル仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。">
                        <img src="{{ asset('frontend/images/channel/reg-btn.png') }}" width="751" height="87"/>
                      </a>
                    </div>
                  </div>
                </div> -->
        
                <ul class="f-sns clearfix" hidden>
                  {{-- <li style="display:none;"><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook-b.svg') }}"></a></li>
                  <li style="display:none;"><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter-b.svg') }}"></a></li>
                  <li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google-b.svg') }}"></a></li>
                  <li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo-b.svg') }}"></a></li> --}}
                </ul>
        
              </div>
        </div>
      </div>
    <div class="bg05">
        <img src="{{ asset('frontend/images/channel/top05.png') }}"/>
    </div>
    <div class="bg06">
        <img src="{{ asset('frontend/images/channel/top06.png') }}"/>
    </div>
    <div class="bg07">
        <img src="{{ asset('frontend/images/channel/top07.png') }}"/>
    </div>
    <div class="bg08">
        <img src="{{ asset('frontend/images/channel/top08.png') }}"/>
    </div>
    <div class="form">
        <div class="form-area">
            <div class="form-txt fade">
                <p hidden><img src="{{asset($data['frontendimages'][IMAGE_FRONTEND_CODE_ATTENTION]['image'])}}" width="730"/></p>
                <p class="f-man" hidden><img src="{{ asset('frontend/images/channel/form02.png') }}" width="730"/></p>

                <div class="pc-none">
                  <div class="top-ar"><img src="{{ asset('frontend/images/channel/top-ar.png') }}"></div>
                  <div class="form-txt">
                    下記ボタンより空メールを送信してください	。
                    <form action="{{ route("register") }}" method="post">
                      {{ csrf_field() }}          
                      <input type="hidden" name="ref" value="{{ $data["ref"] }}">
                      <p class="f-com">当サイトの情報を入手するアドレスを入力して下記のボタンを押して下さい</p>
                      <input type="email" placeholder="メールアドレスを入力してください"
                            class="form-controll email-txt" name="email"
                            value="" required>
                      @if ($errors->has('email'))
                        <span class="invalid-feedback" style="color: red; display: block">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                      @endif
                      <input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
                    </form>
                  </div>
                </div>

                <form action="{{ route("register") }}" method="post" class="sp-none">
                  {{ csrf_field() }}          
                  <input type="hidden" name="ref" value="{{ $data["ref"] }}">
                  <div class="top-ar sp-none"><img src="{{ asset('frontend/images/channel/top-ar.png') }}"></div>
                  <p class="f-com">メールアドレス入力後、下のボタンを押してください。</p>
                  <input type="email" placeholder="メールアドレスを入力してください"
                        class="form-controll email-txt" name="email"
                        value="" required>
                  @if ($errors->has('email'))
                    <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                  <input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
                </form>
                <p class="f-com02">※20歳未満の方はご利用頂けません。<br>
                  ※注 メール受信に制限設定をしている方は、お手数ですが『info@keirin-ch.com』からのメールを受け取れる様に設定して下さい。<br>
                  また、yahooメール、gmailなどのフリーメールの場合、迷惑メールフォルダに配信される、またはメールそのものが届かない可能性が御座いますのでご注意下さい。<br>
                </p>

                <!-- <div class="pc-none">
                  <div class="form-txt">下記ボタンより空メールを送信してください。
                    <div class="m-btn btn">
                      <a href="mailto:{{REGISTER_USERNAME}}?subject=競輪チャンネル「仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。">
                        <img src="{{ asset('frontend/images/channel/reg-btn.png') }}" width="751" height="87"/>
                      </a>
                    </div>
                  </div>
                </div> -->
        
                <ul class="f-sns clearfix" hidden>
                  {{-- <li style="display:none;"><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook-b.svg') }}"></a></li>
                  <li style="display:none;"><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter-b.svg') }}"></a></li>
                  <li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google-b.svg') }}"></a></li>
                  <li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo-b.svg') }}"></a></li> --}}
                </ul>
        
              </div>
        </div>
      </div>

    <div class="bg09">
        <img src="{{ asset('frontend/images/channel/top09.png') }}"/>
    </div>
    {{-- hide --}}
    <div class="form" hidden>
      <div class="form-txt fade">
        <p><img src="{{asset($data['frontendimages'][IMAGE_FRONTEND_CODE_ATTENTION]['image'])}}" width="730"/></p>
        <p class="f-man"><img src="{{ asset('frontend/images/channel/form02.png') }}" width="730"/></p>

        <form action="{{ route("register") }}" method="post">
          {{ csrf_field() }}          
          <input type="hidden" name="ref" value="{{ $data["ref"] }}">
          <input type="email" placeholder="メールアドレスを入力してください"
                class="form-controll email-txt" name="email"
                value="" required>
          @if ($errors->has('email'))
            <span class="invalid-feedback" style="color: red; display: block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
         <p class="f-com">当サイトの情報を入手するアドレスを入力して下記のボタンを押して下さい</p>
          <input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
        </form>
        <!-- <div class="pc-none">
          <div class="form-txt">下記ボタンより空メールを送信してください。
            <div class="m-btn btn">
              <a href="mailto:{{REGISTER_USERNAME}}?subject=競輪チャンネル「仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。">
                <img src="{{ asset('frontend/images/channel/reg-btn.png') }}" width="751" height="87"/>
              </a>
            </div>
          </div>
        </div> -->

        <ul class="f-sns clearfix">
          {{-- <li style="display:none;"><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook-b.svg') }}"></a></li>
          <li style="display:none;"><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter-b.svg') }}"></a></li>
          <li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google-b.svg') }}"></a></li>
          <li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo-b.svg') }}"></a></li> --}}
        </ul>

      </div>

    </div>
    {{-- end-hide --}}

    @if(isset($data['result']["items"]))
    <div id="result" hidden>
      <div class="res clearfix">
        <ul>
          @foreach($data['result']["items"] as $key => $item)
            @switch($item["double"])
              @case(DOUBLE_OFF)
              <li>
                <div class="result">
                  <p class="p-race">{{ $item["course_text"] }}</p>
                  <p class="s-race">{{ $item["race_no_1_title"] }}</p>
                  <p class="place">
                    <img src="{{ asset('frontend/images/venue/' . $item["place_1_img"]) }}"/>
                  </p>
                  <p class="race">
                    <img src="{{ asset(raceNoToImg($item["race_no_1_num"])) }} "/>
                  </p>
                  <p class="r-date">"{{ date_format(date_create($item["date"]), "y年m月d日") }}<br>{{ $item["korogashi"] }}
                  </p>
                  <p class="aom">{{ $item["won_man"] . "万" . $item["won_yen"] }}円達成!!</p>
                  <p class="trs01">{{ ticketToStr($item["ticket_type"]) }}</p>
                  @if($item["ticket_type"] == TICKET_TYPE_1)
                    <p class="rank01t">1着</p>
                    <p class="rank01">{{ $item["bike_number_1"] }}</p>
                    <p class="rank02t">2着</p>
                    <p class="rank02">{{ $item["bike_number_2"] }}</p>
                  @else
                    <p class="rank01t">1着</p>
                    <p class="rank01">{{ $item["bike_number_1"] }}</p>
                    <p class="rank02t">2着</p>
                    <p class="rank02">{{ $item["bike_number_2"] }}</p>
                    <p class="rank03t">3着</p>
                    <p class="rank03">{{ $item["bike_number_3"] }}</p>
                  @endif
                </div>
              </li>
              @break

              @case(DOUBLE_ON)
              <li>
                <div class="result">
                  <p class="r-arrow">
                    <img src="{{ asset('frontend/images/channel/login/r-arrow.png') }}" width="70"
                         height="50"/>
                  </p>
                  <p class="p-race">{{ $item["course_text"] }}</p>
                  <p class="s-race">{{ $item["race_no_1_title"] }}</p>
                  <p class="place">
                    <img src="{{ asset('frontend/images/venue/' . $item["place_1_img"]) }}"/>
                  </p>
                  <p class="race2">
                    <img src="{{ asset(raceNoToImg($item["race_no_1_num"])) }} "/>
                  </p>
                  <p class="r-date">"{{ date_format(date_create($item["date"]), "y年m月d日") }}<br>{{ $item["korogashi"] }}
                  </p>
                  <p class="aom">{{ $item["won_man"] . "万" . $item["won_yen"] }}円達成!!</p>
                  <p class="trs02">{{ ticketToStr($item["ticket_type"]) }}</p>
                  <p class="s-race2">{{ $item["race_no_2_title"] }}</p>
                  <p class="place2">
                    <img src="{{ asset('frontend/images/venue/' . $item["place_2_img"]) }}"/>
                  </p>
                  <p class="race3">
                    <img src="{{ asset(raceNoToImg($item["race_no_2_num"])) }} "/>
                  </p>
                </div>
              </li>
              @break

            @endswitch
          @endforeach

        </ul>
      </div>
    </div>
    @endif

    <p hidden><img src="{{ asset('frontend/images/channel/top07.jpg') }}" width="1000" height="254"/></p>
    <div class="form02" hidden>

      <div class="form02-txt fade">
        <p><img src="{{ asset('frontend/images/channel/form03.png') }}" width="730" height="317"/></p>

        <form action="{{ route("register") }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="ref" value="{{ $data["ref"] }}">
          <input type="email" placeholder="メールアドレスを入力してください"
                 class="form-control email-txt" name="email"
                 value="" required>
          @if ($errors->has('email'))
            <span class="invalid-feedback" style="color: red; display: block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif

          <p class="f-com">当サイトの情報を入手するアドレスを入力して下記のボタンを押して下さい</p>
          <input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
        </form>
        <!-- <div class="pc-none">
          <div class="form-txt">下記ボタンより空メールを送信してください。
            <div class="m-btn btn"><a href="mailto:{{REGISTER_USERNAME}}?subject=競輪チャンネル「仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。"><img src="{{ asset('frontend/images/channel/reg-btn.png') }}"
                                                              width="751" height="87"/></a></div>
          </div>
        </div> -->

        <ul class="f-sns clearfix">
          {{-- <li style="display:none;"><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook-b.svg') }}"></a></li>
          <li style="display:none;"><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter-b.svg') }}"></a></li>
          <li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google-b.svg') }}"></a></li>
          <li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo-b.svg') }}"></a></li> --}}
        </ul>

      </div>
    </div>
  </div>
  <!-- main -->
@endsection
<script>
    
  window.addEventListener( "pageshow", function ( event )
  {
      var historyTraversal = event.persisted || 
                          ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
      if ( historyTraversal )
      {
      // Handle page restore.;
      window.location.reload();
      }
  });
</script>