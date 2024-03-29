@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.add_mail_schedule"))
@section('content')
  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="ibox">
      <form action="{{ route("admin.mail_schedule.store") }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data["mail_schedule"]->id }}">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __("horserace::be_sidebar.add_mail_schedule") }}
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
                     value="{{ $data["mail_schedule"]->mail_from_address }}">
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
                     value="{{  $data["mail_schedule"]->mail_from_name }}">
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
                     value="{{ $data["mail_schedule"]->mail_title }}">
              @if ($errors->has('mail_title'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_title') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="row">
            <!-- daily_hour -->
            <?php
            if (!is_null($data["mail_schedule"]->elapsed_time)) {
              $elapsed_time = explode(":", $data["mail_schedule"]->elapsed_time);
              $data_elapsed_day = $elapsed_time[0];
              $data_elapsed_hour = $elapsed_time[1];
              $data_elapsed_minute = $elapsed_time[2];
            } else {
              $data_elapsed_day = null;
              $data_elapsed_hour = null;
              $data_elapsed_minute = null;
            }
            ?>
            <div class="col-md-3 mb-3">
              <!-- properties -->
              <label>{{ __("horserace::be_form.mail_schedule_properties") }}</label>
              <select class="selectpicker show-tick form-control" name="properties" id="properties"
                      onchange="mailTypeReadOnly();">
                <option value="{{ MAIL_SCHEDULE_PROPERTIES_ELAPSED }}"
                  {{ $data["mail_schedule"]->properties == MAIL_SCHEDULE_PROPERTIES_ELAPSED ? "selected" : "" }}>
                  {{ __("horserace::be_form.mail_schedule_properties_elapsed") }}
                </option>
                <option value="{{ MAIL_SCHEDULE_PROPERTIES_DESIGNATION }}"
                  {{ $data["mail_schedule"]->properties == MAIL_SCHEDULE_PROPERTIES_DESIGNATION ? "selected" : "" }}>
                  {{ __("horserace::be_form.mail_schedule_properties_designation") }}
                </option>
              </select>
              @if ($errors->has('properties'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('properties') }}</strong>
                  </span>
              @endif
            </div>

            <!-- day -->
            <div class="col-md-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.day") }}</label>
                <select class="show-tick form-control mail_template" name="properties_day" id="properties_day">
                  @for($day = 0; $day <= 28; $day++)
                    <option value="{{ $day }}"
                      {{ $data_elapsed_day == $day ? "selected" :  ""}}>
                      {{ $day }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
            <!-- hour -->
            <div class="col-md-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.hour") }}</label>
                <select class="show-tick form-control mail_template" name="properties_hour"
                        id="properties_hour">
                  @for($hour = 0; $hour <= 23; $hour++)
                    <option value="{{ $hour }}"
                      {{ $data_elapsed_hour == $hour ? "selected" :  ""}}>
                      {{ $hour }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
            <!-- minute -->
            <div class="col-md-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.minute") }}</label>
                <select class="show-tick form-control mail_template" name="properties_minute"
                        id="properties_minute">
                  @for($minute = 0; $minute <= 60; $minute+= 5 )
                    <option value="{{ $minute }}"
                      {{ $data_elapsed_minute == $minute ? "selected" :  ""}}>
                      {{ $minute }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>

            <div class="col-md-3 mb-3">
              <!-- target -->
              <label>{{ __("horserace::be_form.mail_schedule_target") }}</label>
              <select class="show-tick form-control" name="target" id="target">
                <option value="{{ MAIL_SCHEDULE_TARGET_REGISTER }}"
                  {{ $data["mail_schedule"]->target == MAIL_SCHEDULE_TARGET_REGISTER ? "selected" : "" }}>
                  {{ __("horserace::be_form.mail_schedule_target_register") }}
                </option>
                <option value="{{ MAIL_SCHEDULE_TARGET_PAYMENT }}"
                  {{ $data["mail_schedule"]->target == MAIL_SCHEDULE_TARGET_PAYMENT ? "selected" : "" }}>
                  {{ __("horserace::be_form.mail_schedule_target_payment") }}
                </option>
                <option value="{{ MAIL_SCHEDULE_TARGET_DEPOSIT }}"
                  {{ $data["mail_schedule"]->target == MAIL_SCHEDULE_TARGET_DEPOSIT ? "selected" : "" }}>
                  {{ __("horserace::be_form.mail_schedule_target_deposit") }}
                </option>
                <option value="{{ MAIL_SCHEDULE_TARGET_USER_INTERIM }}"
                  {{ $data["mail_schedule"]->target == MAIL_SCHEDULE_TARGET_USER_INTERIM ? "selected" : "" }}>
                  {{ __("horserace::be_form.mail_schedule_user_interim") }}
                </option>
              </select>
              @if ($errors->has('target'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('target') }}</strong>
                  </span>
              @endif
            </div>

          </div>

          <div class="row">
            <!-- Check daily -->
            <div class="col-sm-1 form-group mb-3">
              <div class="form-group mt-5">
                <label class="radio">
                  <input type="radio" name="schedule_type" id="daily" disabled
                         class="{{ $errors->has('schedule_type') ? ' is-invalid' : '' }}"
                         value="{{ MAIL_SCHEDULE_TYPE_DAILY }}"
                    {{ $data["mail_schedule"]->schedule_type == MAIL_SCHEDULE_TYPE_DAILY ? "checked" : "" }}>
                  <span class="input-span"></span>
                  {{ __("horserace::be_form.daily") }}
                </label>
                @if ($errors->has('schedule_type'))
                  <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('schedule_type') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <!-- daily_hour -->
            <?php
            if (!is_null($data["mail_schedule"]->daily_hour)) {
              $daily_hour = explode(":", $data["mail_schedule"]->daily_hour);
              $data_daily_hour = $daily_hour[0];
              $data_daily_minute = $daily_hour[1];
            } else {
              $data_daily_hour = null;
              $data_daily_minute = null;
            }
            ?>
            <div class="col-sm-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.hour") }}</label>
                <select class="show-tick form-control mail_template" name="daily_hour" id="daily_hour"
                        disabled="disabled">
                  @for($hour = 0; $hour <= 23; $hour++)
                    <option value="{{ $hour }}"
                      {{ $data_daily_hour == $hour ? "selected" :  ""}}>
                      {{ $hour }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
            <!-- daily_minute -->
            <div class="col-sm-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.minute") }}</label>
                <select class="show-tick form-control mail_template" name="daily_minute" id="daily_minute"
                        disabled="disabled">
                  @for($minute = 0; $minute <= 60; $minute+= 5 )
                    <option value="{{ $minute }}"
                      {{ $data_daily_minute == $minute ? "selected" :  ""}}>
                      {{ $minute }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
            <!-- weekly -->
            <div class="col-sm-1 form-group mb-3">
              <div class="form-group mt-5">
                <label class="radio">
                  <input type="radio" name="schedule_type" id="weekly" disabled
                         value="{{ MAIL_SCHEDULE_TYPE_WEEKLY }}"
                    {{ $data["mail_schedule"]->schedule_type == MAIL_SCHEDULE_TYPE_WEEKLY ? "checked" : "" }}>
                  <span class="input-span"></span>
                  {{ __("horserace::be_form.weekly") }}
                </label>
              </div>
            </div>
            <!-- day -->
            <div class="col-sm-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.day_of_week") }}</label>
                <select class="show-tick form-control mail_template" name="day_of_week" id="weekly_day"
                        disabled="disabled">
                  <option value="{{ SUNDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == SUNDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.sunday") }}
                  </option>
                  <option value="{{ MONDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == MONDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.monday") }}
                  </option>
                  <option value="{{ TUESDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == TUESDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.tuesday") }}
                  </option>
                  <option value="{{ WEDNESDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == WEDNESDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.wednesday") }}
                  </option>
                  <option value="{{ THURSDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == THURSDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.thursday") }}
                  </option>
                  <option value="{{ FRIDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == FRIDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.friday") }}
                  </option>
                  <option value="{{ SATURDAY }}"
                    {{ $data["mail_schedule"]->day_of_week == SATURDAY ? "selected" :  ""}}>
                    {{ __("horserace::be_form.saturday") }}
                  </option>
                </select>
              </div>
            </div>
            <!-- hour -->
            <?php
            if (!is_null($data["mail_schedule"]->week_time_send)) {
              $week_time_send = explode(":", $data["mail_schedule"]->week_time_send);
              $data_hour = $week_time_send[0];
              $data_minute = $week_time_send[1];
            } else {
              $data_hour = null;
              $data_minute = null;
            }
            ?>
            <div class="col-sm-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.hour") }}</label>
                <select class="show-tick form-control mail_template" name="hour" id="weekly_hour" disabled="disabled">
                  @for($hour = 0; $hour <= 23; $hour++)
                    <option value="{{ $hour }}"
                      {{ $data_hour == $hour ? "selected" :  ""}}>
                      {{ $hour }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
            <!-- minute -->
            <div class="col-sm-2 form-group mb-3">
              <div class="form-group">
                <label>{{ __("horserace::be_form.minute") }}</label>
                <select class="show-tick form-control mail_template" name="minute" id="weekly_minute"
                        disabled="disabled">
                  @for($minute = 0; $minute <= 60; $minute+= 5 )
                    <option value="{{ $minute }}"
                      {{ $data_minute == $minute ? "selected" :  ""}}>
                      {{ $minute }}
                    </option>
                  @endfor
                </select>
              </div>
            </div>
          </div>
          <div class="row ">
            <!-- Mail body -->
            <div class="col-md-12 mb-3">
              <label>{{ __("horserace::be_form.mail_body") }}</label>
              <textarea class="summernote mail_body" id="summernote" data-plugin="summernote" data-air-mode="true"
                        name="mail_body">{{ $data["mail_schedule"]->mail_body }}</textarea>
            </div>
            <button class="btn btn-dark mt-3" type="button"
                    data-toggle="modal"
                    data-target="#mail-replace">
              {{ __("horserace::be_form.btn_mail_replace") }}
            </button>
          </div>

          <hr>
          <!-- Condition -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <h4>{{ __("horserace::be_sidebar.search_user") }}</h4>
            </div>
          </div>
          <div class="row">
            <!-- login id -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control" type="text" name="login_id" value="{{ $data["condition"]["login_id"] }}">
            </div>
            <!-- user key -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.user_key") }}</label>
              <input class="form-control" name="user_key" type="text" value="{{ $data["condition"]["user_key"] }}">
            </div>
            <!-- point min -->
            <div class="col-md-3 mb-3 ">
              <label>{{ __("horserace::be_form.point_min") }}</label>
              <input class="form-control" type="number" name="point_min" value="{{ $data["condition"]["point_min"] }}">
            </div>
            <!-- point max-->
            <div class="col-md-3 mb-3 ">
              <label>{{ __("horserace::be_form.point_max") }}</label>
              <input class="form-control" type="number" name="point_max" value="{{ $data["condition"]["point_max"] }}">
            </div>
          </div>
          <div class="row">
            <!-- nick  name -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.nickname") }}</label>
              <input class="form-control" type="text" name="nickname" value="{{ $data["condition"]["nickname"] }}">
            </div>

            <!-- member level -->
            <!-- <div class="col-md-3 mb-3">
              <label class="form-control-label">
                {{ __("horserace::be_form.member_level") }}
              </label>
              <select class="selectpicker show-tick form-control" name="member_level">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ MEMBER_LEVEL_TRIAL }}"
                  {{ !is_null($data["condition"]["member_level"]) && $data["condition"]["member_level"] == MEMBER_LEVEL_TRIAL ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_trail") }}
                </option>
                <option value="{{ MEMBER_LEVEL_GOLD }}"
                  {{ $data["condition"]["member_level"] == MEMBER_LEVEL_GOLD ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_gold") }}
                </option>
                <option value="{{ MEMBER_LEVEL_DIAMOND }}"
                  {{ $data["condition"]["member_level"] == MEMBER_LEVEL_DIAMOND ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_diamond") }}
                </option>
                <option value="{{ MEMBER_LEVEL_CRYSTAL }}"
                  {{ $data["condition"]["member_level"] == MEMBER_LEVEL_CRYSTAL ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_crystal") }}
                </option>
                <option value="{{ MEMBER_LEVEL_EXCEPT }}"
                  {{ $data["condition"]["member_level"] == MEMBER_LEVEL_EXCEPT ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_except") }}
                </option>
              </select>
            </div> -->

            <!--deposit_total_amount min -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_amount_min") }}</label>
              <input class="form-control" type="number" name="deposit_total_amount_min"
                     value="{{ $data["condition"]["deposit_total_amount_min"] }}">
            </div>
            <!--deposit_total_amount max-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_amount_max") }}</label>
              <input class="form-control" type="number" name="deposit_total_amount_max"
                     value="{{ $data["condition"]["deposit_total_amount_max"] }}">
            </div>
          </div>
          <div class="row">
            <!-- age-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.age") }}</label>
              <select class="selectpicker show-tick form-control" name="age">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ AGE_USER_20 }}"
                  {{ $data["condition"]["age"] == AGE_USER_20 ? "selected" : "" }}>
                  {{ __("horserace::be_form.age_20") }}
                </option>
                <option value="{{ AGE_USER_30 }}"
                  {{  $data["condition"]["age"] == AGE_USER_30 ? "selected" : "" }}>
                  {{ __("horserace::be_form.age_30") }}
                </option>
                <option value="{{ AGE_USER_40 }}"
                  {{  $data["condition"]["age"] == AGE_USER_40 ? "selected" : "" }}>
                  {{ __("horserace::be_form.age_40") }}
                </option>
                <option value="{{ AGE_USER_50 }}"
                  {{  $data["condition"]["age"] == AGE_USER_50 ? "selected" : "" }}>
                  {{ __("horserace::be_form.age_50") }}
                </option>
                <option value="{{ AGE_USER_60 }}"
                  {{  $data["condition"]["age"] == AGE_USER_60 ? "selected" : "" }}>
                  {{ __("horserace::be_form.age_60") }}
                </option>
                <option value="{{ AGE_USER_70 }}"
                  {{  $data["condition"]["age"] == AGE_USER_70 ? "selected" : "" }}>
                  {{ __("horserace::be_form.age_70") }}
                </option>
              </select>
            </div>
            <!-- gender-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.gender") }}</label>
              <div class="form-control">
                <label class="checkbox checkbox-grey checkbox-primary">
                  <input type="checkbox" name="gender[{{ MALE }}]" value="{{ MALE }}"
                    {{ isset($data["condition"]["gender"][0]) && $data["condition"]["gender"][MALE] ==  MALE ? "checked" : "" }} >
                  <span class="input-span"></span>{{ __("horserace::be_form.male") }}</label>
                <label class="checkbox checkbox-grey checkbox-primary">
                  <input type="checkbox" name="gender[{{ FEMALE }}]" value="{{ FEMALE }}"
                    {{ isset($data["condition"]["gender"][1]) ==  FEMALE ? "checked" : "" }} >
                  <span class="input-span"></span>{{ __("horserace::be_form.female") }}</label>
              </div>
            </div>
            <!-- deposit_total_number min   -->
            <div class=" col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_number_min") }}</label>
              <input class="form-control" type="number" name="deposit_total_number_min"
                     value="{{ $data["condition"]["deposit_total_number_min"] }}">
            </div>
            <!-- deposit_total_number max -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_number_max") }}</label>
              <input class="form-control" type="number" name="deposit_total_number_max"
                     value="{{ $data["condition"]["deposit_total_number_max"] }}">
            </div>
          </div>

          <div class="row">
            <!-- mail pc-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.mail_pc") }}</label>
              <input class="form-control" type="text" name="mail_pc" value="{{ $data["condition"]["mail_pc"] }}">
            </div>
            <!-- mail mobile-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.mail_mobile") }}</label>
              <input class="form-control" type="text" name="mail_mobile"
                     value="{{ $data["condition"]["mail_mobile"] }}">
            </div>
            <!-- login_number min -->
            <div class="col-md-3 mb-3">
              <label> {{ __("horserace::be_form.login_number_min") }}</label>
              <input class="form-control" type="number" name="login_number_min"
                     value="{{ $data["condition"]["login_number_min"] }}">
            </div>
            <!-- login_number max -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.login_number_max") }}</label>
              <input class="form-control" type="number" name="login_number_max"
                     value="{{ $data["condition"]["login_number_max"] }}">
            </div>
          </div>

          <div class="row">
            <!-- IP-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.ip") }}</label>
              <input class="form-control" type="text" name="ip" value="{{ $data["condition"]["ip"] }}">
            </div>
            <!-- Prediction type -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.prediction_type") }}</label>
              <select
                class="selectpicker show-tick form-control" name="prediction_type">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["prediction_type"] as $item)
                  <option value="{{ $item->id }}"
                    {{ old("prediction_type") ==  $item->id ? "selected" : "" }} >
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- register_time start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.register_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="register_time_start"
                       value="{{ is_null($data["condition"]["register_time_start"]) ? "" :  date_format(date_create($data["condition"]["register_time_start"]), "Y-m-d") }}">
              </div>
            </div>
            <!-- register_time end -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.register_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="register_time_end"
                       value="{{ is_null($data["condition"]["register_time_end"]) ? "" : date_format(date_create($data["condition"]["register_time_end"]), "Y-m-d") }}">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Media -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.media_code") }}</label>
              <select class="selectpicker show-tick form-control" name="media_code">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["media"] as $item)
                  <option value="{{ $item->code }}"
                    {{  $data["condition"]["media_code"] ==  $item->code ? "selected" : "" }}>
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- entrance_id -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.entrance") }}</label>
              <select class="selectpicker show-tick form-control" name="entrance_id">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["entrance"] as $item)
                  <option value="{{ $item->id }}"
                    {{  isset($data["condition"]["entrance_id"]) && $data["condition"]["entrance_id"] ==  $item->id ? "selected" : "" }}>
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- stop_mail -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.stop_mail") }}</label>
              <select class="selectpicker show-tick form-control" name="stop_mail">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ STOP_MAIL_DISABLE }}"
                  {{ isset($data["condition"]["stop_mail"]) && $data["condition"]["stop_mail"] ==  STOP_MAIL_DISABLE ? "selected" : "" }}>
                  {{ __("horserace::be_form.stop_mail_disable")  }}
                </option>
                <option value="{{ STOP_MAIL_ENABLE }}"
                  {{ isset($data["condition"]["stop_mail"]) && $data["condition"]["stop_mail"] ==  STOP_MAIL_ENABLE ? "selected" : "" }}>
                  {{ __("horserace::be_form.stop_mail_enable")  }}
                </option>
              </select>
            </div>
          </div>


          <div class="row">
            <!-- first_deposit_time_start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_deposit_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="first_deposit_time_start"
                       value="{{ is_null($data["condition"]["first_deposit_time_start"]) ? "" : date_format(date_create($data["condition"]["first_deposit_time_start"]), "Y-m-d") }}">
              </div>
            </div>

            <!-- first_deposit_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_deposit_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="first_deposit_time_end"
                       value="{{ is_null($data["condition"]["first_deposit_time_end"]) ? "" : date_format(date_create($data["condition"]["first_deposit_time_end"]), "Y-m-d") }}">
              </div>
            </div>

            <!-- last_deposit_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_deposit_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="last_deposit_time_start"
                       value="{{ is_null($data["condition"]["last_deposit_time_start"]) ? "" : date_format(date_create($data["condition"]["last_deposit_time_start"]), "Y-m-d") }}">
              </div>
            </div>
            <!-- last_deposit_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_deposit_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="last_deposit_time_end"
                       value="{{ is_null($data["condition"]["last_deposit_time_end"]) ? "" : date_format(date_create($data["condition"]["last_deposit_time_end"]), "Y-m-d") }}">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- first_payment_time_start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_payment_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="first_payment_time_start"
                       value="{{ is_null($data["condition"]["first_payment_time_start"]) ? "" : date_format(date_create($data["condition"]["first_payment_time_start"]), "Y-m-d") }}">
              </div>
            </div>

            <!-- first_payment_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_payment_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="first_payment_time_end"
                       value="{{ is_null($data["condition"]["first_payment_time_end"]) ? "" : date_format(date_create($data["condition"]["first_payment_time_end"]), "Y-m-d") }}">
              </div>
            </div>

            <!-- last_payment_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_payment_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="last_payment_time_start"
                       value="{{ is_null($data["condition"]["last_payment_time_start"]) ? "" : date_format(date_create($data["condition"]["last_payment_time_start"]), "Y-m-d") }}">
              </div>
            </div>
            <!-- last_payment_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_payment_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="last_payment_time_end"
                       value="{{ is_null($data["condition"]["last_payment_time_end"]) ? "" : date_format(date_create($data["condition"]["last_payment_time_end"]), "Y-m-d") }}">
              </div>
            </div>
          </div>

          <div class="row">


          </div>


          <div class="row">
            <!-- last_login_time start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_login_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="last_login_time_start"
                       value="{{ is_null($data["condition"]["last_login_time_start"]) ? "" : date_format(date_create($data["condition"]["last_login_time_start"]), "Y-m-d") }}">
              </div>
            </div>
            <!-- last_login_time end-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_login_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="text" name="last_login_time_end"
                       value="{{ is_null($data["condition"]["last_login_time_end"]) ? "" : date_format(date_create($data["condition"]["last_login_time_end"]), "Y-m-d") }}">
              </div>
            </div>

            <!-- last_access_time_start -->
          {{--<div class="col-md-3 mb-3">--}}
          {{--<label>{{ __("horserace::be_form.last_access_time_start") }}</label>--}}
          {{--<div class="input-group date" data-provide="datepicker">--}}
          {{--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>--}}
          {{--<input class="form-control" type="text" name="last_access_time_start"--}}
          {{--value="{{ is_null($data["condition"]["last_access_time_start"]) ? "" : date_format(date_create($data["condition"]["last_access_time_start"]), "Y-m-d") }}">--}}
          {{--</div>--}}
          {{--</div>--}}
          <!-- last_acsess_time_end-->
            {{--<div class="col-md-3 mb-3">--}}
            {{--<label>{{ __("horserace::be_form.last_access_time_end") }}</label>--}}
            {{--<div class="input-group date" data-provide="datepicker">--}}
            {{--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>--}}
            {{--<input class="form-control" type="text" name="last_access_time_end"--}}
            {{--value="{{ is_null($data["condition"]["last_access_time_end"]) ? "" : date_format(date_create($data["condition"]["last_access_time_end"]), "Y-m-d") }}">--}}
            {{--</div>--}}
            {{--</div>--}}
          </div>


          <div class="row">
            <!-- User stage -->
            {{-- <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
            <select class="selectpicker show-tick form-control ml-3 mb-3 col-md-2" name="specify_stage">
              <option value="{{ USER_STAGE_MATCH }}" selected>
                {{ __("horserace::be_form.user_stage_match") }}
              </option>
              <option value="{{ USER_STAGE_EXCLUSION }}">
                {{ __("horserace::be_form.user_stage_exclusion") }}
              </option>
            </select> --}}
            {{-- <button class="btn btn-dark ml-3 mb-3 btn-all"
                    type="button">
              {{ __("horserace::be_form.btn_user_stage_all") }}
            </button> --}}
  
            <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
  
            <button class="btn btn-dark ml-3 mb-3 btn-remove-all"
                    type="button">
              {{ __("horserace::be_form.btn_user_stage_remove_all") }}
            </button>
  
            <select class="selectpicker show-tick form-control ml-3 mb-3 col-md-2" name="search_match_type" id="search_match_type">
              <option value="{{ USER_STAGE_MATCH_ALL }}">
                {{ __("horserace::be_form.search_match_all") }}
              </option>
              <option value="{{ USER_STAGE_MATCH_PORTION }}" selected>
                {{ __("horserace::be_form.search_match_portion") }}
              </option>
            </select>
  
            <div class="col-md-12 mb-3 row">
              @foreach($data["user_stage"] as $item)
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="checkbox checkbox-primary">
                      <input class="user_stage" name="user_stage_id[{{ $item->id }}]" type="radio"
                             value="{{ $item->id }}-1"
                             @if (isset($data["condition"]["user_stage_id"][$item->id]) && $data["condition"]["user_stage_id"][$item->id] == $item->id . '-1')
                             checked
                             @endif>
                      <span class="input-span"></span>
                    </label>
  
                    <label class="checkbox checkbox-exclude checkbox-primary-exclude">
                      <input class="user_stage" name="user_stage_id[{{ $item->id }}]" type="radio"
                             value="{{ $item->id }}-0"
                             @if (isset($data["condition"]["user_stage_id"][$item->id]) && $data["condition"]["user_stage_id"][$item->id] == $item->id . '-0')
                             checked
                             @endif>
                      <span class="input-span"></span>
                    </label>
                    {{ $item->name }}
                  </div>
                </div>
              @endforeach
            </div>
          </div>


          <div class="row">

          </div>


          <div class="row">
            <!-- register_time-->
            <div class="col-md-6 mb-3">
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
  <!-- Popup-->
  @include('horserace::backend.popup.mail_replace')
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

    var type_schedule = $("input[name=schedule_type]:checked").val();
    var type_mail = document.getElementById("properties").value;

    $(document).ready(function () {
      if (type_mail == '{{ MAIL_SCHEDULE_PROPERTIES_ELAPSED }}') {
        document.getElementById("properties_day").disabled = false;
        document.getElementById("properties_hour").disabled = false;
        document.getElementById("properties_minute").disabled = false;
        document.getElementById("target").disabled = false;
        document.getElementById("daily").disabled = true;
        document.getElementById("daily").checked = false;
        document.getElementById("weekly").disabled = true;
        document.getElementById("weekly").checked = false;

        document.getElementById("daily_hour").disabled = true;
        document.getElementById("daily_minute").disabled = true;
        document.getElementById("weekly_day").disabled = true;
        document.getElementById("weekly_hour").disabled = true;
        document.getElementById("weekly_minute").disabled = true;

      } else if (type_mail == '{{ MAIL_SCHEDULE_PROPERTIES_DESIGNATION }}') {
        document.getElementById("properties_day").disabled = true;
        document.getElementById("properties_hour").disabled = true;
        document.getElementById("properties_minute").disabled = true;
        document.getElementById("target").disabled = true;
        document.getElementById("daily").disabled = false;
        document.getElementById("weekly").disabled = false;
      }

      if (type_schedule == '{{ MAIL_SCHEDULE_TYPE_DAILY }}') {
        console.log(type_schedule);
        //enable
        document.getElementById("daily_hour").disabled = false;
        document.getElementById("daily_minute").disabled = false;
        //disable
        document.getElementById("weekly_day").disabled = true;
        document.getElementById("weekly_hour").disabled = true;
        document.getElementById("weekly_minute").disabled = true;
      } else if (type_schedule == '{{ MAIL_SCHEDULE_TYPE_WEEKLY }}') {
        console.log(type_schedule);
        //enable
        document.getElementById("weekly_day").disabled = false;
        document.getElementById("weekly_hour").disabled = false;
        document.getElementById("weekly_minute").disabled = false;
        //disable
        document.getElementById("daily_hour").disabled = true;
        document.getElementById("daily_minute").disabled = true;
      }
    });

    // mail type
    function mailTypeReadOnly() {
      var type = document.getElementById("properties").value;

      if (type == '{{ MAIL_SCHEDULE_PROPERTIES_ELAPSED }}') {
        document.getElementById("properties_day").disabled = false;
        document.getElementById("properties_hour").disabled = false;
        document.getElementById("properties_minute").disabled = false;
        document.getElementById("target").disabled = false;
        document.getElementById("daily").disabled = true;
        document.getElementById("daily").checked = false;
        document.getElementById("weekly").disabled = true;
        document.getElementById("weekly").checked = false;

        document.getElementById("daily_hour").disabled = true;
        document.getElementById("daily_minute").disabled = true;
        document.getElementById("weekly_day").disabled = true;
        document.getElementById("weekly_hour").disabled = true;
        document.getElementById("weekly_minute").disabled = true;

      } else if (type == '{{ MAIL_SCHEDULE_PROPERTIES_DESIGNATION }}') {
        document.getElementById("properties_day").disabled = true;
        document.getElementById("properties_hour").disabled = true;
        document.getElementById("properties_minute").disabled = true;
        document.getElementById("target").disabled = true;
        document.getElementById("daily").disabled = false;
        document.getElementById("weekly").disabled = false;
      }
    }

    // schedule type
    $(document).on('click', '[name="schedule_type"]', function () {

      if ($(this).val() == '{{ MAIL_SCHEDULE_TYPE_DAILY }}') {
        console.log($(this).val());
        //enable
        $('#daily_hour').attr('disabled', false);
        $('#daily_minute').attr('disabled', false);
        //disable
        $('#weekly_day').attr('disabled', true);
        $('#weekly_hour').attr('disabled', true);
        $('#weekly_minute').attr('disabled', true);
      } else if ($(this).val() == '{{ MAIL_SCHEDULE_TYPE_WEEKLY }}') {
        console.log($(this).val());
        //enable
        $('#weekly_day').attr('disabled', false);
        $('#weekly_hour').attr('disabled', false);
        $('#weekly_minute').attr('disabled', false);
        //disable
        $('#daily_hour').attr('disabled', true);
        $('#daily_minute').attr('disabled', true);
      } //else {
      //   //disable
      //   $('#daily_hour').attr('disabled', true);
      //   $('#daily_minute').attr('disabled', true);
      //   $('#weekly_day').attr('disabled', true);
      //   $('#weekly_hour').attr('disabled', true);
      //   $('#weekly_minute').attr('disabled', true);
      // }
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
@endsection