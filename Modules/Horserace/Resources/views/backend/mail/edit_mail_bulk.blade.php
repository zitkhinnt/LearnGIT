@extends('horserace::backend.layouts.design')
@section('title','Dashboard')
@section('content')
  <!-- Mail template -->

  <!-- -->

  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="ibox">
      <form id="form_mail_bulk" action="{{ route("admin.mail_bulk.store") }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data["mail_bulk"]->id }}">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __("horserace::be_sidebar.add_mail_bulk") }}
          </div>
        </div>

        <div class="ibox-body">
          <!-- Mail template -->
          <div class="row form-inline">
            <div class="col-md-2">
              <label>{{ __("horserace::be_form.mail_template") }}</label>
            </div>
            <div class="col-md-3">
              <select class="selectpicker show-tick form-control mail_template" name="mail_template">
                <option value="">{{ __("horserace::be_form.unset") }}</option>
                @foreach($data["mail_template"] as $item)
                  <option value="{{ $item->id }}">
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <button id="get-mail-template" class="btn btn-info" type="button">
                {{ __("horserace::be_form.btn_get_mail_template") }}
              </button>
            </div>
          </div>
          <hr>
          <!-- -->

          <div class="row">
            <div class="col-md-4 mb-3">
              <!-- Mail form address -->
              <label>{{ __("horserace::be_form.mail_from_address") }}</label>
              <input class="form-control mail_from_address {{ $errors->has('mail_from_address') ? ' is-invalid' : '' }}"
                     type="email" name="mail_from_address"
                     value="{{ $data["mail_bulk"]->mail_from_address }}">
              @if ($errors->has('mail_from_address'))
                <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('mail_from_address') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-md-4 mb-3">
              <!-- Mail form name -->
              <label>{{ __("horserace::be_form.mail_from_name") }}</label>
              <input class="form-control mail_from_name {{ $errors->has('mail_from_name') ? ' is-invalid' : '' }}"
                     type="text" name="mail_from_name"
                     value="{{ $data["mail_bulk"]->mail_from_name }}">
              @if ($errors->has('mail_from_name'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_from_name') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-md-4 mb-3">
              <!-- mail_title -->
              <label>{{ __("horserace::be_form.mail_title") }}</label>
              <input class="form-control mail_title {{ $errors->has('mail_title') ? ' is-invalid' : '' }}"
                     type="text" name="mail_title"
                     value="{{ $data["mail_bulk"]->mail_title }}">
              @if ($errors->has('mail_title'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_title') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="row">
            <!-- reserve_datetime -->
            <div class="col-sm-3 form-group mb-3">
              <label>{{ __("horserace::be_form.reserve_datetime") }}</label>
              <div class="input-group datetime">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control {{ $errors->has('reserve_datetime') ? ' is-invalid' : '' }}"
                       type="text" name="reserve_datetime"
                       value="{{ date_format(date_create($data['mail_bulk']->reserve_datetime), "Y-m-d H:i:00")  }}">
              </div>
              @if ($errors->has('reserve_datetime'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('reserve_datetime') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="row ">
            <!-- Mail body -->
            <div class="col-md-12 mb-3">
              <label>{{ __("horserace::be_form.mail_body") }}</label>
              <textarea class="summernote mail_body" id="summernote" data-plugin="summernote" data-air-mode="true"
                        name="mail_body">{{ $data["mail_bulk"]->mail_body }}</textarea>
              <button class="btn btn-dark mt-3" type="button"
                      data-toggle="modal"
                      data-target="#mail-replace">
                {{ __("horserace::be_form.btn_mail_replace") }}
              </button>
            </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
          <button class="btn btn-primary btn-mail-bulk mr-2" type="button"
                  data-toggle="modal"
                  data-target="#confirmMailBulk">
            {{ __("horserace::be_form.btn_edit_deleted") }}
          </button>
        </div>
        <!-- Condition user -->
        <input type="hidden" name="condition"
               value="{{ $data["mail_bulk"]->condition }}">
      </form>
    </div>
  </div>
  <!-- END PAGE CONTENT-->
  <!-- Popup-->
  @include('horserace::backend.popup.mail_replace')
  @include('horserace::backend.popup.confirm_mail_bulk')
@endsection
@section('javascript')

  <!-- Get mail template-->
  <script>
    $(document).ready(function () {
      $(document).on('click', '#get-mail-template', function () {
        let mail_template_id = $('.mail_template option:selected').val();
        $.ajax({
          url: '{{ route("admin.mail_template.ajax_get") }}' + '?mail_template_id=' + mail_template_id,
          type: "GET",
          dataType: "JSON",
          success: function (response) {
            $('.mail_from_address').val(response.mail_from_address);
            $('.mail_from_name').val(response.mail_from_name);
            $('.mail_title').val(response.mail_title);
            $('.mail_body').val(response.mail_body);
            $('#summernote').summernote('code', response.mail_body);
            console.log(response.mail_body);
          }
        })
      });
    });
  </script>

  <script>
    $(".btn-mail-bulk").click(function () {
      var mail_from_address = $(".mail_from_address").val();
      var mail_from_name = $(".mail_from_name").val();
      var mail_title = $(".mail_title").val();
      var reserve_datetime = $(".reserve_datetime").val();
      var mail_body = $('.mail_body').val();

      // Set value popup
      $(".popup_mail_from_address").html(mail_from_address);
      $(".popup_mail_from_name").html(mail_from_name);
      $(".popup_mail_title").html(mail_title);
      $(".popup_reserve_datetime").html(reserve_datetime);
      $("#summernote-popup").summernote('code', mail_body);
    })
  </script>

  <script>
    $(".btn-confirm").click(function () {
      $("#form_mail_bulk").submit();
    })
  </script>
@endsection