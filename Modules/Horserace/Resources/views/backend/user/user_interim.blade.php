@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.user_interim"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.user_interim"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.user_interim") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.user_interim.search.post') }}" method="POST">
      @csrf
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.user_interim") }}
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
          <!-- mail pc-->
          <div class="col-md-6 mb-3">
            <label>{{ __("horserace::be_form.mail_address") }}</label>
            <input class="form-control" type="text" name="mail_pc">
          </div>
          <!-- last_payment_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.interim_register_time_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="interim_register_time_start">
            </div>
          </div>
          <!-- last_payment_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.interim_register_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="interim_register_time_end">
            </div>
          </div>
        </div>
        <div class="row">
          <!-- IP-->
          <div class="col-md-6 mb-3">
            <label>{{ __("horserace::be_form.ip") }}</label>
            <input class="form-control" type="text" name="ip">
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
  <script>
    // using text area
    $(function () {
      $('#summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
    });

  </script>
@endsection