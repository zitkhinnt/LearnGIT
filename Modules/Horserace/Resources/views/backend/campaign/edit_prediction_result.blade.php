@extends('horserace::backend.layouts.design')
@section('title','Dashboard')
@section('content')
  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="ibox">
      <form action="{{ route("admin.prediction_result.store") }}" method="POST"
            enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $data["pre_result"]->id }}">
        <input type="hidden" name="prediction_id" value="{{ $data["pre_result"]->prediction_id }}">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __("horserace::be_sidebar.edit_prediction_result") }}
          </div>
        </div>

        <div class="ibox-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <!-- Race name -->
              <label>{{ __("horserace::be_form.race_name") }}</label>
              <input class="form-control mail_from_address {{ $errors->has('race_name') ? ' is-invalid' : '' }}"
                     type="text" name="race_name"
                     value="{{ $data["pre_result"]->race_name }}">
              @if ($errors->has('race_name'))
                <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('race_name') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-md-3 mb-3">
              <!-- Type -->
              <label>{{ __("horserace::be_form.prediction_result_type") }}</label>
              <input class="form-control mail_from_name {{ $errors->has('type') ? ' is-invalid' : '' }}"
                     type="text" name="type"
                     value="{{ $data["pre_result"]->type }}">
              @if ($errors->has('type'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('type') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-md-3 mb-3">
              <!-- venue -->
              <label>{{ __("horserace::be_form.venue") }}</label>
              <select class="selectpicker show-tick form-control {{ $errors->has('venue_id') ? ' is-invalid' : '' }}"
                      name="venue_id">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["venue"] as $item)
                  <option value="{{ $item->id }}"
                    {{ $data["pre_result"]->venue_id ==  $item->id ? "selected" : "" }} >
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
              @if ($errors->has('venue_id'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('venue') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-md-3 mb-3">
              <!-- Prediction type -->
              <label>{{ __("horserace::be_form.prediction_type") }}</label>
              <select class="selectpicker show-tick form-control {{ $errors->has('venue') ? ' is-invalid' : '' }}"
                      name="prediction_type">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ PREDICTION_TYPE_TRIAL_PACK }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_TRIAL_PACK ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_trial_pack") }}
                </option>
                <option value="{{ PREDICTION_TYPE_OWNERS_SECRET }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_OWNERS_SECRET ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_owners_secret") }}
                </option>
                <option value="{{ PREDICTION_TYPE_AGENT_EYE }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_AGENT_EYE ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_agent_eye") }}
                </option>
                <option value="{{ PREDICTION_TYPE_RECEPTION_RACE }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_RECEPTION_RACE ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_reception_race") }}
                </option>
                <option value="{{ PREDICTION_TYPE_THE_STALLION }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_THE_STALLION ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_stallion") }}
                </option>
                <option value="{{ PREDICTION_TYPE_GREAT_NINE }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_GREAT_NINE ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_great_nine") }}
                </option>
                <option value="{{ PREDICTION_TYPE_ONLY_ONE }}"
                  {{ $data["pre_result"]->prediction_type ==  PREDICTION_TYPE_ONLY_ONE ? "selected" : "" }} >
                  {{ __("horserace::be_form.prediction_type_only_one") }}
                </option>
              </select>
              @if ($errors->has('prediction_type'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('prediction_type') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mb-3">
              <!-- Race no -->
              <label>{{ __("horserace::be_form.race_no") }}</label>
              <select class="selectpicker show-tick form-control {{ $errors->has('venue') ? ' is-invalid' : '' }}"
                      name="race_no">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ RACE_NO_1 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_1 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_1") }}
                </option>
                <option value="{{ RACE_NO_2 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_2 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_2") }}
                </option>
                <option value="{{ RACE_NO_3 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_3 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_3") }}
                </option>
                <option value="{{ RACE_NO_4 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_4 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_4") }}
                </option>
                <option value="{{ RACE_NO_5 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_5 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_5") }}
                </option>
                <option value="{{ RACE_NO_6 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_6 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_6") }}
                </option>
                <option value="{{ RACE_NO_7 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_7 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_7") }}
                </option>
                <option value="{{ RACE_NO_8 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_8 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_8") }}
                </option>
                <option value="{{ RACE_NO_9 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_9 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_9") }}
                </option>
                <option value="{{ RACE_NO_10 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_10 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_10") }}
                </option>
                <option value="{{ RACE_NO_11 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_11 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_11") }}
                </option>
                <option value="{{ RACE_NO_12 }}"
                  {{ $data["pre_result"]->race_no ==  RACE_NO_12 ? "selected" : "" }} >
                  {{ __("horserace::be_form.race_no_12") }}
                </option>
              </select>
              @if ($errors->has('prediction_type'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('prediction_type') }}</strong>
                  </span>
              @endif
            </div>

            <div class="col-md-3 mb-3">
              <!-- hit_race -->
              <label>{{ __("horserace::be_form.hit_race") }}</label>
              <input class="form-control mail_title {{ $errors->has('hit_race') ? ' is-invalid' : '' }}"
                     type="number" name="hit_race" min="0" step="0.01"
                     placeholder="0.00"
                     value="{{ $data["pre_result"]->hit_race }}">
              @if ($errors->has('hit_race'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('hit_race') }}</strong>
                  </span>
              @endif
            </div>

            <div class="col-md-3 mb-3">
              <!-- amount -->
              <label>{{ __("horserace::be_form.prediction_result_amount") }}</label>
              <input class="form-control mail_title {{ $errors->has('amount') ? ' is-invalid' : '' }}"
                     type="number" name="amount" min="0"
                     value="{{ $data["pre_result"]->amount }}">
              @if ($errors->has('amount'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('amount') }}</strong>
                  </span>
              @endif
            </div>

            <!-- race_date -->
            <div class="col-sm-3 form-group mb-3">
              <label>{{ __("horserace::be_form.race_date") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control {{ $errors->has('race_date') ? ' is-invalid' : '' }}"
                       type="text" name="race_date" value="{{ $data["pre_result"]->race_date }}">
              </div>
              @if ($errors->has('race_date'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('race_date') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <!-- banner_image -->
              <label>{{ __("horserace::be_form.image") }}</label>
              <div class="row">
                <div class="col-md-4">
                  <label class="btn btn-primary file-input mr-2 form-control">
                    <span class="btn-icon">
                      <i class="la la-cloud-upload"></i>
                      {{ __("horserace::be_form.btn_choose_file") }}
                    </span>
                    <input type="file" id="fileUpload" name="img_banner"
                           value="{{ $data["pre_result"]->img_banner }}" >
                  </label>
                </div>
                <div class="col-md-8 image-holder">
                  <img class="thumb-image" src="{{ asset($data["pre_result"]->img_banner ) }}">
                </div>
              </div>
            </div>

            <!-- reserve_datetime -->
            <div class="col-sm-3 form-group mb-3">
              <label>{{ __("horserace::be_form.reserve_datetime") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control {{ $errors->has('reserve_datetime') ? ' is-invalid' : '' }}"
                       type="text" name="reserve_datetime" value="{{ $data["pre_result"]->reserve_datetime }}">
              </div>
              @if ($errors->has('reserve_datetime'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('reserve_datetime') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="row ">
            <!-- Content -->
            <div class="col-md-12 mb-3">
              <label>{{ __("horserace::be_form.content") }}</label>
              <textarea id="summernote" data-plugin="summernote"
                        data-air-mode="true" class="content summernote {{ $errors->has('content') ? ' is-invalid' : '' }}"
                        name="content">{{ $data["pre_result"]->content }}</textarea>
              @if ($errors->has('content'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('content') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
          <button class="btn btn-primary mr-2" type="submit">
            {{ __("horserace::be_form.btn_edit_deleted") }}
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- END PAGE CONTENT-->
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
    // using jquery for preview image
    $("#fileUpload").on('change', function () {
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
@endsection