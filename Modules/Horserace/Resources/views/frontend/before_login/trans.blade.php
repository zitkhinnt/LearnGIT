@extends('horserace::frontend.layouts.before_login.design')
@section('title','About')
@section('content')
<!-- main -->

<div id="contents">


	<div class="title">特定商取引法</div>


	<div id="trans">
		<div class="text-area">
			<div class="column-info">
			@include('horserace::dynamic_page.trans')
			</div>
		</div>
	</div>

</div>

<!-- main -->
@endsection