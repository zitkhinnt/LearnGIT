@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.prediction_add"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.prediction"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.prediction') }}">
      {{ __("horserace::be_sidebar.prediction") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.prediction_add") }}</li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.prediction.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" value="0">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.prediction_add") }}
        </div>
      </div>

      <div class="ibox-body">
        <div class="row">
          <!-- Prediction name -->
          <div class="col-md-6 mb-3">
            <label>{{ __("horserace::be_form.prediction_name") }}</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                   type="text" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>
          <!-- Start Date -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.prediction_start_time") }}</label>
            <div class="input-group datetime">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control {{ $errors->has('start_time') ? ' is-invalid' : '' }}"
                     type="text" value="{{ old('start_time') }}" name="start_time">
            </div>
            @if ($errors->has('start_time'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('start_time') }}</strong>
              </span>
            @endif
          </div>
          <!-- End Date -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.prediction_end_time") }}</label>
            <div class="input-group datetime">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control {{ $errors->has('end_time') ? ' is-invalid' : '' }}"
                     type="text" value="{{ old('end_time') }}" name="end_time">
            </div>
            @if ($errors->has('end_time'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('end_time') }}</strong>
              </span>
            @endif
          </div>
        </div>

        <div class="row">
          <!-- status -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.prediction_status") }}</label>
            <select class="selectpicker show-tick form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"
                    name="status">
              <option value="{{ PREDICTION_STATUS_OPEN }}"
                {{ old("status") == PREDICTION_STATUS_OPEN ? "selected" : ""}}>
                {{ __("horserace::be_form.prediction_status_open") }}
              </option>
              <option value="{{ PREDICTION_STATUS_REMAIN }}"
                {{ old("status") == PREDICTION_STATUS_REMAIN ? "selected" : ""}}>
                {{ __("horserace::be_form.prediction_status_remain") }}
              </option>
              <option value="{{ PREDICTION_STATUS_DONE }}"
                {{ old("status") == PREDICTION_STATUS_DONE ? "selected" : ""}}>
                {{ __("horserace::be_form.prediction_status_done") }}
              </option>
            </select>
            @if ($errors->has('status'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('status') }}</strong>
              </span>
            @endif
          </div>
          <!-- Prediction type -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.type") }}</label>
            <select
              class="selectpicker show-tick form-control {{ $errors->has('prediction_type') ? ' is-invalid' : '' }}"
              name="prediction_type" id="prediction_type"
              onchange="bannerImage();">
              <option value="">
                {{ __("horserace::be_form.unset") }}
              </option>
              @foreach($data["prediction_type"] as $item)
                <option value="{{ $item->id }}"
                  {{ old("prediction_type") ==  $item->id ? "selected" : "" }} >
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
            @if ($errors->has('prediction_type'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('prediction_type') }}</strong>
              </span>
            @endif
          </div>
          <!-- member level -->
          <!-- <div class="col-md-3 mb-3">
            <label class="form-control-label">
              {{ __("horserace::be_form.member_level") }}
            </label>
            <select
              class="selectpicker show-tick form-control {{ $errors->has('member_level') ? ' is-invalid' : '' }}"
              name="member_level" disabled>
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              <option value="{{ MEMBER_LEVEL_TRIAL }}" selected
                {{ !is_null(old('member_level')) && old('member_level') == MEMBER_LEVEL_TRIAL ? "selected" : ""}} >
                {{ __("horserace::be_form.member_level_trail") }}
              </option>
              <option value="{{ MEMBER_LEVEL_GOLD }}"
                {{ old('member_level') == MEMBER_LEVEL_GOLD ? "selected" : ""}} >
                {{ __("horserace::be_form.member_level_gold") }}
              </option>
              <option value="{{ MEMBER_LEVEL_DIAMOND }}"
                {{ old('member_level') == MEMBER_LEVEL_DIAMOND ? "selected" : ""}} >
                {{ __("horserace::be_form.member_level_diamond") }}
              </option>
              <option value="{{ MEMBER_LEVEL_CRYSTAL }}"
                {{ old('member_level') == MEMBER_LEVEL_CRYSTAL ? "selected" : ""}} >
                {{ __("horserace::be_form.member_level_crystal") }}
              </option>
              <option value="{{ MEMBER_SPECIAL }}"
                {{ old('member_level') == MEMBER_SPECIAL ? "selected" : ""}} >
                {{ __("horserace::be_form.member_special") }}
              </option>
            </select>
            @if ($errors->has('member_level'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('member_level') }}</strong>
              </span>
            @endif
          </div> -->
          <!-- Info start time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.prediction_info_start_time") }}</label>
            <div class="input-group datetime">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control {{ $errors->has('info_start_time') ? ' is-invalid' : '' }}"
                     type="text" value="{{ old('info_start_time') }}" name="info_start_time">
            </div>
            @if ($errors->has('info_start_time'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('info_start_time') }}</strong>
              </span>
            @endif
          </div>
          <!-- Finish recruit time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.prediction_finish_recruit_time") }}</label>
            <div class="input-group datetime">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control {{ $errors->has('prediction_finish_recruit_time') ? ' is-invalid' : '' }}"
                     type="text" value="{{ old('prediction_finish_recruit_time') }}" name="prediction_finish_recruit_time">
            </div>
            @if ($errors->has('prediction_finish_recruit_time'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('prediction_finish_recruit_time') }}</strong>
              </span>
            @endif
          </div>
        </div>

        <div class="row">
          <!-- default point -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.default_point") }}</label>

            <input class="form-control {{ $errors->has('default_point') ? ' is-invalid' : '' }}"
                name="default_point" type="number" min="0"
                value="{{ old('default_point') }}"
                id="txt_default_point"
            >
            @if ($errors->has('default_point'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('default_point') }}</strong>
              </span>
            @endif
          </div>
          <!-- Display Order-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.display_order") }}</label>
            <input class="form-control {{ $errors->has('display_order') ? ' is-invalid' : '' }}"
                   name="display_order" type="number" min="0"
                   value="{{ !is_null(old('display_order')) ? old('display_order') : 0 }}">
            @if ($errors->has('display_order'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('display_order') }}</strong>
              </span>
            @endif
          </div>
        </div>

        <div class="row">
          <!-- User stage -->
          <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
          <button class="btn btn-dark ml-3 mb-3 btn-all"
                  type="button">
            {{ __("horserace::be_form.btn_user_stage_all") }}
          </button>

          <button class="btn btn-dark ml-3 mb-3 btn-remove-all"
                  type="button">
            {{ __("horserace::be_form.btn_user_stage_remove_all") }}
          </button>
          <div class="col-md-12 mb-3 row">
            @foreach($data["user_stage"] as $item)
              <div class="col-md-3">
                <div class="form-group">
                  <label class="checkbox checkbox-primary">
                    <input class="user_stage" name="user_stage_id[{{ $item->id }}]" type="checkbox"
                           value="{{ $item->id }}">
                    <span class="input-span"></span>
                    {{ $item->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>


        <div class="row">
          <!-- Banner Images default -->
          <div class="col-md-6 mb-3 ">
            <label>{{ __("horserace::be_form.image_default") }}</label>

            @foreach($data["prediction_type"] as $item)
              <div class="row img_banner" id="pre_type_{{ $item->id }}">
                <div class="col-md-12">
                  <img class="thumb-image" src="{{ asset($item->image) }}">
                </div>
              </div>
              <p id="pre_content_{{ $item->id }}" style="display:none;">
                 {{ $item->before_open_content }}
              </p>
              <p id="after_content_{{ $item->id }}" style="display:none;">
                 {{ $item->after_open_content }}
              </p>
              <p id="pre_point_{{ $item->id }}" style="display:none;">
                 {{ $item->default_point }}
              </p>
            @endforeach
          </div>

          <!-- Banner image upload -->
          <div class="col-md-6 mb-3 ">
            <label>{{ __("horserace::be_form.image") }}</label>
            <div class="row">
              <div class="col-md-4">
                <label class="btn btn-primary file-input mr-2 form-control">
                    <span class="btn-icon">
                      <i class="la la-cloud-upload"></i>
                      {{ __("horserace::be_form.btn_choose_file") }}
                    </span>
                  <input type="file" id="fileUpload" name="img_banner">
                </label>
              </div>
              <div class="col-md-12 image-holder">

              </div>
            </div>
          </div>
        </div>

        <!-- Content --> 
        <!-- <div class="row">         
          <div class="col-lg-12 mb-3">
            <label>{{ __("horserace::be_form.prediction_content") }}</label>
            @if ($errors->has('content'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('content') }}</strong>
              </span>
            @endif
            <textarea class="summernote" data-plugin="summernote" data-air-mode="true"
                      name="content"> {{ old('content') }}  </textarea>
          </div>
        </div> -->
        <!-- After buy -->
         <div class="row">
          <div class="col-lg-12 mb-3">
            <label>{{ __("horserace::be_form.after_buy") }}</label>
            <textarea id='txa_after_buy' class="summernote" data-plugin="summernote" data-air-mode="true"
                      name="after_buy"> {{ old('after_buy') }} </textarea>
          </div>
        </div>

        <div class="row">        
          <!-- Result -->
          <div class="col-lg-12 mb-3">
            <label>{{ __("horserace::be_form.result") }}</label>
            <textarea id='txa_result' class="summernote" data-plugin="summernote" data-air-mode="true"
                      name="result"> {{ old('result') }} </textarea>
          </div>
        </div>
      </div>
      <div class="ibox-footer row">
        <div class="col-sm-10 ">
          <a class="btn btn-secondary" href="{{ route('admin.prediction')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>
        <div class="col-sm-2 ">
          <div class="text-right">
            <button type="submit" class="btn btn-primary btn-air mr-2">
              {{ __("horserace::be_form.btn_save") }}
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- END PAGE CONTENT-->

@endsection
@section('javascript')
  <script type="text/javascript">


    // using text area
    $(function () {
      $('.summernote').summernote();
      $('.summernote_air').summernote({
        airMode: true
      });
    });
    // using jquery for preview image
    $("#fileUpload").on('change', function () {
      $('.img_banner').hide();
      //Get count of selected files
      var countFiles = $(this)[0].files.length;
      var imgPath = $(this)[0].value;
      var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      var image_holder = $(".image-holder");
      image_holder.empty();
      if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
        if (typeof(FileReader) != "undefined") {
          //loop for each file selected for uploaded.
          for (var i = 0; i < countFiles; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $("<img />", {
                "src": e.target.result,
                "class": "thumb-image"
              }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[i]);
          }
        } else {
          alert("This browser does not support FileReader.");
        }
      } else {
        alert("Pls select only images");
      }
    });

  </script>

  <script type="text/javascript">
    // Add bonus point
    $(document).on('click', 'button.btn-all', function () {
      var check = document.getElementsByClassName('user_stage');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    });

    // Remove bonus point
    $(document).on('click', 'button.btn-remove-all', function () {
      var uncheck = document.getElementsByClassName('user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    });
  </script>

  <script>
    $(document).ready(function () {
      bannerImage();
    });

    // Banner image show
    function bannerImage() {
      $(".image-holder").hide();
      $("#fileUpload").val("");
      var type = document.getElementById("prediction_type").value;
      $('.img_banner').hide();
      $('#pre_type_' + type).show();

      // load before open content
      var content = $('#pre_content_' + type).text();
      $('#txa_after_buy').summernote("code", content);

      // load after open content
      var content = $('#after_content_' + type).text();
      $('#txa_result').summernote("code", content);

      // load default point
      var point_default =  $('#pre_point_' + type).text().trim();
      $('#txt_default_point').val(point_default);
    }
  </script>
@endsection
