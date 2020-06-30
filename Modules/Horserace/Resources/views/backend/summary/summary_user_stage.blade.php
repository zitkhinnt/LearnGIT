@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_user_stage"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_user_stage"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_user_stage") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Table list user stage-->
  <div class="row">
    <div class="col-xl-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            <h5>{{ __('horserace::be_form.daily') }}</h5>
          </div>
        </div>
        <div class="ibox-body">
          <table id="table-report-day-access" class="table table-bordered  mb-5">
            <thead>
            <tr>
              <th>{{ __('horserace::be_form.stage_name') }}</th>
              <th class="text-center">{{ __('horserace::be_form.stage_description') }}</th>
              <th class="text-center">{{ __('horserace::be_form.number_people') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data["number_people"] as $item)
              <tr>
                <td>{{ $item["user_stage_name"] }}</td>
                <td>{{ $item["user_stage_stage"] }}</td>
                <td>{{  number_format($item["user_register"]) . " 人" }}</td>
              </tr>
            @endforeach
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
