@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
<!-- main -->

<div id="contents">
	<div class="title">プライバシーポリシー</div>
	<div class="text-area02">
		<div class="info">
			@include('horserace::dynamic_page.privacy')
		</div>
	</div>
</div>

<!-- main -->
@endsection