@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.gift_edit"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.gift"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.gift') }}"> {{ __("horserace::be_sidebar.gift") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.gift_edit") }}</li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">

    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.gift_edit") }}
      </div>
      <div class="">
      </div>
    </div>

    <div class="ibox-body">
      <!-- Form Add Gift-->
      <form action="{{ route('admin.gift.store') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id" value="{{ $data['gift']->id }}">
        <div class="row">
          <!-- Name -->
          <div class="col-sm-6 form-group">
            <label>{{ __("horserace::be_form.name") }}</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                   type="text" name="name" value="{{ $data['gift']->name }}"
                   placeholder="{{ __("horserace::be_form.name") }}">
            @if ($errors->has('name'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
            @endif
          </div>
          <!-- Point -->
          <div class="col-sm-6 form-group">
            <label>{{ __("horserace::be_form.point") }}</label>
            <input class="form-control {{ $errors->has('point') ? ' is-invalid' : '' }}"
                   type="number" name="point" min="0" value="{{ $data['gift']->point }}"
                   placeholder="{{ __("horserace::be_form.point_number") }}">
            @if ($errors->has('point'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('point') }}</strong>
                  </span>
            @endif
          </div>
        </div>
        <div class="row">
          <!-- Type -->
          <div class="col-sm-3 form-group">
            <label>{{ __("horserace::be_form.gift_type") }}</label>
            <select class="selectpicker show-tick form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"
                    name="type" id="type" onchange="sendDateReadOnly();">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              <option value="{{ GIFT_TYPE_REGISTER }}"
                {{ $data['gift']->type == GIFT_TYPE_REGISTER ? "selected" : "" }}>
                {{ __("horserace::be_form.gift_type_register") }}
              </option>
              <option value="{{ GIFT_TYPE_PAYMENT }}"
                {{ $data['gift']->type == GIFT_TYPE_PAYMENT ? "selected" : "" }}>
                {{ __("horserace::be_form.gift_type_payment") }}
              </option>
              <option value="{{ GIFT_TYPE_DEPOSIT }}"
                {{ $data['gift']->type == GIFT_TYPE_DEPOSIT ? "selected" : "" }}>
                {{ __("horserace::be_form.gift_type_deposit") }}
              </option>
              <option value="{{ GIFT_TYPE_PREDICTION }}"
                {{ $data['gift']->type == GIFT_TYPE_PREDICTION ? "selected" : "" }}>
                {{ __("horserace::be_form.gift_type_prediction") }}
              </option>
              <option value="{{ GIFT_TYPE_EVENT }}"
                {{ $data['gift']->type == GIFT_TYPE_EVENT ? "selected" : "" }}>
                {{ __("horserace::be_form.gift_type_event") }}
              </option>
            </select>
            @if ($errors->has('type'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('type') }}</strong>
                  </span>
            @endif
          </div>
          <!-- Send date -->
          <div class="col-sm-3 form-group">
            <label>{{ __("horserace::be_form.gift_send_date") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="send_date"
                     value="{{ !is_null($data['gift']->send_date) ? date_format(date_create($data['gift']->send_date), "Y-m-d") : '' }}"
                     id="send_date" disabled>
            </div>
          </div>
          <!-- Start date -->
          <div class="col-md-3 form-group">
            <label>{{ __("horserace::be_form.date_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control {{ $errors->has('start_time') ? ' is-invalid' : '' }}"
                     type="text" name="start_time"
                     value="{{ date_format(date_create($data['gift']->start_time), "Y-m-d") }}">
            </div>
            @if ($errors->has('start_time'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('start_time') }}</strong>
                  </span>
            @endif
          </div>
          <!-- End date -->
          <div class="col-sm-3 form-group">
            <label>{{ __("horserace::be_form.date_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control {{ $errors->has('end_time') ? ' is-invalid' : '' }}"
                     id="demo" type="text" name="end_time"
                     value="{{ date_format(date_create($data['gift']->end_time), "Y-m-d") }}">
            </div>
            @if ($errors->has('end_time'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('end_time') }}</strong>
                  </span>
            @endif
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-12">
            <label>{{ __("horserace::be_form.content") }}</label>
            @if ($errors->has('content'))
              <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('content') }}</strong>
                  </span>
            @endif
            <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
                      name="content">{{ $data['gift']->content}}</textarea>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-10 ">
            <a class="btn btn-secondary" href="{{ route('admin.gift')}}">
              {{ __("horserace::be_form.btn_back") }}
            </a>
          </div>
          <div class="col-sm-2 ">
            <div class="text-right">
              <button type="submit" class="btn btn-primary btn-air mr-2">
                {{ __("horserace::be_form.btn_edit_deleted") }}
              </button>
            </div>
          </div>
        </div>
      </form>
      <!--End Form -->
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection

@section('javascript')
  <script type="text/javascript">
    $(document).ready(function() {
      var type = document.getElementById("type").value;

      if (type == '{{ GIFT_TYPE_EVENT }}') {
        document.getElementById("send_date").disabled = false;
      }
    });   

    function sendDateReadOnly() {
      var type = document.getElementById("type").value;

      if (type == {{ GIFT_TYPE_EVENT }}) {
        document.getElementById("send_date").disabled = false;
      }
      else {
        document.getElementById("send_date").disabled = true;
        document.getElementById("send_date").value = "";
      }
    }
  </script>
@endsection