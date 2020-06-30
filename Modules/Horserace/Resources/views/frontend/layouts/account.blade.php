<div id="member-info" class="clearfix">
	<ul id="member-info-area">
		<li class="info_id">会員ID</li>
		<li class="info_num">{{ Auth::user()->login_id }}</li>
		<li class="info_id">保有ポイント</li>
		<li class="info_num">{{ number_format(Auth::user()->user_point) }}pt</li>
	</ul>
	<div class="mypage-btn"><a href="{{route('mypage')}}">マイページ</a></div>
</div>