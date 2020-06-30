@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_media_rank"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_media_rank"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_media_rank") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Year -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __('horserace::be_form.summary_type') }}
          </div>
        </div>
        <div class="ibox-body">
          <form action="{{ route("admin.summary.media_rank") }}" method="GET">
            <label>{{ __("horserace::be_form.summary_type") }}</label>
            <select name="summary_type" class="selectpicker show-tick">
              <option value="" selected="selected">
                {{ __('horserace::be_form.unset') }}
              </option>
              <option value="{{ SUMMARY_TYPE_PAYMENT }}">
                {{ __('horserace::be_form.summary_type_payment') }}
              </option>
              <option value="{{ SUMMARY_TYPE_NOT_PAYMENT }}">
                {{ __('horserace::be_form.summary_type_not_payment') }}
              </option>
              <option value="{{ SUMMARY_TYPE_NOT_LOGIN }}">
                {{ __('horserace::be_form.summary_type_not_login') }}
              </option>

            </select>
            <button type="submit" class="btn btn-dark">
              {{ __("horserace::be_form.btn_search") }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Table media rank -->
  <div class="row">
    <div class="col-xl-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">

          </div>
        </div>
        <div class="ibox-body">
          <table id="table-report-day-access" class="table table-bordered  mb-5">
            <thead>
            <tr class="bg-city-lights">
              <th>{{ __('horserace::be_form.rank') }}</th>
              <th>{{ __('horserace::be_form.media_code') }}</th>
              <th>{{ __('horserace::be_form.media_name') }}</th>
              <th>{{ __('horserace::be_form.access_count') }}</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
@endsection
