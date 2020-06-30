@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.search_user_login_history"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.search_user_login_history"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.search_user_login_history") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.user.login_history') }}" method="POST">
      @csrf
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.search_user_login_history") }}
        </div>
        <div class="ibox-title text-right">

        </div>
      </div>

      <div class="ibox-body">
        @if (Session::has('flash_message'))
          <div class="alert alert-{!! Session::get('flash_level') !!}">
            {!! Session::get('flash_message') !!}
          </div>
        @endif

        <div class="row">
          <!-- login id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.login_id") }}</label>
            <input class="form-control" type="text" name="login_id">
          </div>
          <!-- login time start -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_login_time_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="login_time_start">
            </div>
          </div>
          <!-- login time end -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_login_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="login_time_end">
            </div>
          </div>
        </div>

      </div>
      <div class="ibox-footer text-right">
        <button class="btn btn-primary mr-2" type="submit">
          {{ __("horserace::be_form.btn_search") }}
        </button>
      </div>
    </form>
  </div>
</div>
<!-- END PAGE CONTENT-->

@endsection
@section('javascript')
@endsection