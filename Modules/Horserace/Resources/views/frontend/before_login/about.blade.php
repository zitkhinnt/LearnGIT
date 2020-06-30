@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
<!-- main -->
<div id="contents">
	<p><img src="{{ asset('frontend/images/channel/top01.jpg') }}" width="1000" height="1368"/></p>
	<p><img src="{{ asset('frontend/images/channel/top02.jpg') }}" width="1000" height="910"/></p>
	<p><img src="{{ asset('frontend/images/channel/top03.jpg') }}" width="1000" height="564"/></p>

	<div class="form">

		<div class="form-txt fade">
			<p><img src="{{ asset('frontend/images/channel/form01.png') }}" width="730" height="312" /></p>
			<p class="f-man"><img src="{{ asset('frontend/images/channel/form02.png') }}" width="730" height="81" /></p>

			<form action="http://over-the-wall.jp/kami0222/entry.html" method="post" class="sp-none">
				<input type="hidden" name="action_EntryComplete" value="true" />
				<input type="text" value="" name="mail_address" placeholder="メールアドレスを入力して下さい
				">
				<p class="f-com">メールアドレスを入力して「競輪で稼ぐ」ボタンをクリックして下さい</p>
				<input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}" >
			</form>
			<div class="pc-none">
				<div class="form-txt">下記ボタンより空メールを送信してください。
					<div class="m-btn btn">
						<a href="mailto:{{REGISTER_USERNAME}}?subject=競輪チャンネル「仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。?subject=競輪チャンネル「仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。">
							<img src="{{ asset('frontend/images/channel/reg-btn.png') }}"  width="751" height="87"/>
						</a>
					</div>
				</div>
			</div>

			<ul class="f-sns clearfix">
				{{-- <li><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook-b.svg') }}"></a></li>
				<li><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter-b.svg') }}"></a></li>
				<li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google-b.svg') }}"></a></li>
				<li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo-b.svg') }}"></a></li> --}}
			</ul>

		</div>

	</div>

	<p><img src="{{ asset('frontend/images/channel/top05.jpg') }}" width="1000" height="1254"/></p>
	<p><img src="{{ asset('frontend/images/channel/top06.jpg') }}" width="1000" height="138"/></p>
	<div id="result">
		<div class="res clearfix">
			<ul>
				<li><div class="result">
					<p class="p-race">1st・アンビシャス</p>
					<p class="s-race">1レース目</p>
					<p class="place"><img src="{{ asset('frontend/images/channel/p-race01.svg') }}" /></p>
					<p class="race"><img src="{{ asset('frontend/images/channel/race01.svg') }}"/></p>
					<p class="r-date">"19年2月1日<br>コロガシ成功</p>
					<p class="aom">100万3980円達成!!</p>
					<p class="trs01">3連単</p>
					<p class="rank01t">1着</p>
					<p class="rank01">2</p>
					<p class="rank02t">2着</p>
					<p class="rank02">4</p>
					<p class="rank03t">3着</p>
					<p class="rank03">6</p>
				</div></li>
				<li><div class="result">
					<p class="r-arrow"><img src="{{ asset('frontend/images/channel/r-arrow.png') }}" width="70" height="50"/></p>
					<p class="p-race">1st・アンビシャス</p>
					<p class="s-race">1レース目</p>
					<p class="place"><img src="{{ asset('frontend/images/channel/p-race02.svg') }}" /></p>
					<p class="race2"><img src="{{ asset('frontend/images/channel/race01.svg') }}"/></p>
					<p class="r-date">"19年2月1日<br>コロガシ成功</p>
					<p class="aom">100万3980円達成!!</p>
					<p class="trs02">3連単</p>
					<p class="s-race2">2レース目</p>
					<p class="place2"><img src="{{ asset('frontend/images/channel/p-race07.svg') }}"/></p>
					<p class="race3"><img src="{{ asset('frontend/images/channel/race02.svg') }}"/></p>
				</div></li>
				<li><div class="result">
					<p class="p-race">1st・アンビシャス</p>
					<p class="s-race">3レース目</p>
					<p class="place"><img src="{{ asset('frontend/images/channel/p-race03.svg') }}" /></p>
					<p class="race"><img src="{{ asset('frontend/images/channel/race03.svg') }}"/></p>
					<p class="r-date">"19年2月1日<br>コロガシ成功</p>
					<p class="aom">100万3980円達成!!</p>
					<p class="trs01">3連単</p>
					<p class="rank01t">1着</p>
					<p class="rank01">2</p>
					<p class="rank02t">2着</p>
					<p class="rank02">4</p>
					<p class="rank03t">3着</p>
					<p class="rank03">6</p>
				</div></li>
				<li><div class="result">
					<p class="p-race">1st・アンビシャス</p>
					<p class="s-race">4レース目</p>
					<p class="place"><img src="{{ asset('frontend/images/channel/p-race04.svg') }}" /></p>
					<p class="race"><img src="{{ asset('frontend/images/channel/race04.svg') }}"/></p>
					<p class="r-date">"19年2月1日<br>コロガシ成功</p>
					<p class="aom">100万3980円達成!!</p>
					<p class="trs01">3連単</p>
					<p class="rank01t">1着</p>
					<p class="rank01">2</p>
					<p class="rank02t">2着</p>
					<p class="rank02">4</p>
					<p class="rank03t">3着</p>
					<p class="rank03">6</p>
				</div></li>
				<li><div class="result">
					<p class="p-race">1st・アンビシャス</p>
					<p class="s-race">5レース目</p>
					<p class="place"><img src="{{ asset('frontend/images/channel/p-race05.svg') }}" /></p>
					<p class="race"><img src="{{ asset('frontend/images/channel/race05.svg') }}"/></p>
					<p class="r-date">"19年2月1日<br>コロガシ成功</p>
					<p class="aom">90万3980円達成!!</p>
					<p class="trs01">3連単</p>
					<p class="rank01t">1着</p>
					<p class="rank01">2</p>
					<p class="rank02t">2着</p>
					<p class="rank02">4</p>
					<p class="rank03t">3着</p>
					<p class="rank03">6</p>
				</div></li>
				<li><div class="result">
					<p class="p-race">1st・アンビシャス</p>
					<p class="s-race">6レース目</p>
					<p class="place"><img src="{{ asset('frontend/images/channel/p-race06.svg') }}" /></p>
					<p class="race"><img src="{{ asset('frontend/images/channel/race06.svg') }}" /></p>
					<p class="r-date">"19年2月1日<br>コロガシ成功</p>
					<p class="aom">100万3980円達成!!</p>
					<p class="trs01">3連単</p>
					<p class="rank01t">1着</p>
					<p class="rank01">2</p>
					<p class="rank02t">2着</p>
					<p class="rank02">4</p>
					<p class="rank03t">3着</p>
					<p class="rank03">6</p>
				</div></li>
			</ul>
		</div>

	</div>

	<p><img src="{{ asset('frontend/images/channel/top07.jpg') }}" width="1000" height="254"/></p>

	<div class="form02">

		<div class="form02-txt fade">
			<p><img src="{{ asset('frontend/images/channel/form03.png') }}" width="730" height="317" /></p>

			<form action="http://over-the-wall.jp/kami0222/entry.html" method="post" class="sp-none">
				<input type="hidden" name="action_EntryComplete" value="true" />
				<input type="text" value="" name="mail_address" placeholder="メールアドレスを入力して下さい">
				<p class="f-com">メールアドレスを入力して「競輪で稼ぐ」ボタンをクリックして下さい</p>
				<input type="image" class="btn" src="{{ asset('frontend/images/channel/reg-btn.png') }}">
			</form>
			<div class="pc-none">
				<div class="form-txt">下記ボタンより空メールを送信してください。
					<div class="m-btn btn"><a href="mailto:{{REGISTER_USERNAME}}?subject=競輪チャンネル「仮」登録中&body=送信ボタンを押して、本登録を完了させてください。※5分経っても本登録完了メールが届かない場合は、迷惑メールフォルダをご覧ください。それでも届かない場合はお手数ですが「問い合わせフォーム」より直接ご連絡をお願いします。"><img src="{{ asset('frontend/images/channel/reg-btn.png') }}" width="751" height="87"/></a></div>
				</div>
			</div>

			<ul class="f-sns clearfix">
				{{-- <li><a href="{{ route("socialite", array("facebook")) }}"><img src="{{ asset('frontend/images/channel/facebook-b.svg') }}"></a></li>
				<li><a href="{{ route("socialite", array("twitter")) }}"><img src="{{ asset('frontend/images/channel/twitter-b.svg') }}"></a></li>
				<li><a href="{{ route("socialite", array("google")) }}"><img src="{{ asset('frontend/images/channel/google-b.svg') }}"></a></li>
				<li><a href="{{ route("socialite", array("yahoo")) }}"><img src="{{ asset('frontend/images/channel/yahoo-b.svg') }}"></a></li> --}}
			</ul>

		</div>
	</div>
</div>
<!-- main -->
@endsection