@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.search_user"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.search_user"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.search_user") }}</li>
@endsection
<style>
div.dropdown-menu.open{
  max-height: 314px !important;
  overflow: hidden;
}
ul.dropdown-menu.inner{
  max-height: 260px !important;
  overflow-y: auto;
}
</style>

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.user.search.post') }}" method="POST">
      @csrf

      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.search_user") }}
        </div>
        <div class="ibox-title text-right">
          <a class="mb-0 ml-2 btn btn-primary" href="{{ route('admin.list.query.search.user') }}">{{ __("horserace::be_form.list_query") }}</a>
          <a class="mb-0 ml-2 btn btn-success"
             href="{{ route('admin.user.add') }}">
            {{ __("horserace::be_form.add_new") }}
          </a>
        </div>
      </div>

      <div class="ibox-body">

        @if (Session::has('flash_message'))
          <div class="alert alert-{!! Session::get('flash_level') !!}">
            {!! Session::get('flash_message') !!}
          </div>
      @endif
      <!-- Condition -->
        <div class="row">
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.list_search_condition") }}</label>
            <div class="query-search text-left">
              <select class="selectpicker show-tick form-control" name="query_search" id="query_search">
                <option value="-1">{{ __("horserace::be_form.please_select") }}</option>
                @foreach($data['list_query'] as $value)
                  <option value="{{ $value->query }}">{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- login id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.login_id") }}</label>
            <input class="form-control" type="text" name="login_id" value="{{ old("login_id") }}">
          </div>
          <!-- user key -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.user_key") }}</label>
            <input class="form-control" name="user_key" type="text" value="{{ old("user_key") }}">
          </div>
          <!-- point min -->
          <div class="col-md-3 mb-3 ">
            <label>{{ __("horserace::be_form.point_min") }}</label>
            <input class="form-control" type="number" name="point_min" value="{{ old("point_min") }}">
          </div>
          <!-- point max-->
          <div class="col-md-3 mb-3 ">
            <label>{{ __("horserace::be_form.point_max") }}</label>
            <input class="form-control" type="number" name="point_max" value="{{ old("point_max") }}">
          </div>
        </div>
        <div class="row">
          <!-- nick  name -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.nickname") }}</label>
            <input class="form-control" type="text" name="nickname" value="{{ old("nickname") }}">
          </div>

          <!-- member level -->
          <div class="col-md-3 mb-3">
            <label class="form-control-label">
              {{ __("horserace::be_form.member_level") }}
            </label>
            <select class="selectpicker show-tick form-control" name="member_level">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
               <option value="{{ MEMBER_LEVEL_TRIAL }}"
                {{ !is_null(old("member_level")) && old("member_level") == MEMBER_LEVEL_TRIAL ? "selected" : "" }}>
                {{ __("horserace::be_form.member_level_trail") }}
              </option>
              <option value="{{ MEMBER_LEVEL_EXCEPT }}"
                {{ old("member_level") == MEMBER_LEVEL_EXCEPT ? "selected" : "" }}>
                {{ __("horserace::be_form.member_level_except") }}
              </option>
            </select>
          </div>

          <!--deposit_total_amount min -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.deposit_total_amount_min") }}</label>
            <input class="form-control" type="number" name="deposit_total_amount_min"
                   value="{{ old("deposit_total_amount_min") }}">
          </div>
          <!--deposit_total_amount max-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.deposit_total_amount_max") }}</label>
            <input class="form-control" type="number" name="deposit_total_amount_max"
                   value="{{ old("deposit_total_amount_max") }}">
          </div>

          <!-- age-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.age") }}</label>
            <select class="selectpicker show-tick form-control" name="age">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              <option value="{{ AGE_USER_20 }}"
                {{ old("age") == AGE_USER_20 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_20") }}
              </option>
              <option value="{{ AGE_USER_30 }}"
                {{  old("age") == AGE_USER_30 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_30") }}
              </option>
              <option value="{{ AGE_USER_40 }}"
                {{  old("age") == AGE_USER_40 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_40") }}
              </option>
              <option value="{{ AGE_USER_50 }}"
                {{  old("age") == AGE_USER_50 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_50") }}
              </option>
              <option value="{{ AGE_USER_60 }}"
                {{  old("age") == AGE_USER_60 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_60") }}
              </option>
              <option value="{{ AGE_USER_70 }}"
                {{  old("age") == AGE_USER_70 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_70") }}
              </option>
            </select>
          </div>
          <!-- stop_mail -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.stop_mail") }}</label>
            <select class="selectpicker show-tick form-control" name="stop_mail">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              <option value="{{ STOP_MAIL_DISABLE }}">
                {{ __("horserace::be_form.stop_mail_disable")  }}
              </option>
              <option value="{{ STOP_MAIL_ENABLE }}">
                {{ __("horserace::be_form.stop_mail_enable")  }}
              </option>
            </select>
          </div>
        </div>

        <div class="row">
          <!-- gender-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.gender") }}</label>
            <div class="form-control">
              <label class="checkbox checkbox-grey checkbox-primary">
                <input type="checkbox" name="gender[{{ MALE }}]" value="{{ MALE }}"
                  {{ !is_null(old("gender")) &&  old("gender") ==  MALE ? "checked" : "" }} >
                <span class="input-span"></span>{{ __("horserace::be_form.male") }}</label>
              <label class="checkbox checkbox-grey checkbox-primary">
                <input type="checkbox" name="gender[{{ FEMALE }}]" value="{{ FEMALE }}"
                  {{ !is_null(old("gender")) &&  old("gender")  == FEMALE ? "checked" : "" }}>
                <span class="input-span"></span>{{ __("horserace::be_form.female") }}</label>
            </div>
          </div>
          <!-- deposit_total_number min   -->
          <div class=" col-md-3 mb-3">
            <label>{{ __("horserace::be_form.deposit_total_number_min") }}</label>
            <input class="form-control" type="number" name="deposit_total_number_min"
                   value="{{ old("deposit_total_number_min") }}">
          </div>
          <!-- deposit_total_number max -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.deposit_total_number_max") }}</label>
            <input class="form-control" type="number" name="deposit_total_number_max"
                   value="{{ old("deposit_total_number_max") }}">
          </div>

          <!-- mail pc-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.mail_pc") }}</label>
            <input class="form-control" type="text" name="mail_pc" value="{{ old("mail_pc") }}">
          </div>
        </div>
        <div class="row">
          <!-- mail mobile-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.mail_mobile") }}</label>
            <input class="form-control" type="text" name="mail_mobile" value="{{ old("mail_mobile") }}">
          </div>
          <!-- login_number min -->
          <div class="col-md-3 mb-3">
            <label> {{ __("horserace::be_form.login_number_min") }}</label>
            <input class="form-control" type="number" name="login_number_min" value="{{ old("login_number_min") }}">
          </div>
          <!-- login_number max -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.login_number_max") }}</label>
            <input class="form-control" type="number" name="login_number_max" value="{{ old("login_number_max") }}">
          </div>

          <!-- IP-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.ip") }}</label>
            <input class="form-control" type="text" name="ip" value="{{  old("ip") }}">
          </div>
        </div>

        <div class="row">
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
                     value="{{ old("register_time_start") }}">
            </div>
          </div>
          <!-- register_time end -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.register_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="register_time_end" value="{{ old("register_time_end") }}">
            </div>
          </div>

          <!-- Media -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.media_code") }}</label>
            <select class="selectpicker show-tick form-control" name="media_code">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              @foreach($data["media"] as $item)
                <option value="{{ $item->code }}"
                  {{  old("media_code") ==  $item->code ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <!-- entrance_id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.entrance") }}</label>
            <select class="selectpicker show-tick form-control" name="entrance_id">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              @foreach($data["entrance"] as $item)
                <option value="{{ $item->id }}"
                  {{  old("entrance_id") ==  $item->id ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- sns_register -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.sns_register") }}</label>
            <select class="selectpicker show-tick form-control" name="sns_register">
              <option value="">
                {{ __("horserace::be_form.unset") }}
              </option>
              <option value="{{ SNS_REGISTER_TYPE_ALL }}">
                {{ __("horserace::be_form.sns_all")  }}
              </option>
              <option value="{{ SNS_REGISTER_TYPE_TWITTER }}">
                {{ __("horserace::be_form.sns_twitter")  }}
              </option>
              <option value="{{ SNS_REGISTER_TYPE_YAHOO }}">
                {{ __("horserace::be_form.sns_yahoo")  }}
              </option>
              <option value="{{ SNS_REGISTER_TYPE_FACEBOOK }}">
                {{ __("horserace::be_form.sns_facebook")  }}
              </option>
              <option value="{{ SNS_REGISTER_TYPE_GOOGLE }}">
                {{ __("horserace::be_form.sns_google")  }}
              </option>
            </select>
          </div>
          <!-- search summernote -->
          <div class="col-md-3 mb-3">
            <label>
              {{ __("horserace::be_form.summernote") }}
            </label>
            <label style="margin-left:20px"><input type="radio" name="option_summer" value="1"> 完全一致</label>
            <label style="margin-left:10px"><input type="radio" name="option_summer" value="0" checked> 部分一致</label>
            <input class="form-control" type="text" name="summernote" value="{{  old("summernote") }}">
          </div>

          <div class="col-md-3 mb-3">
            <label>
              {{ __("horserace::be_form.summernote_not") }}
            </label>
            <label style="margin-left:20px"><input type="radio" name="option_summer_not" value="1"> 完全一致</label>
            <label style="margin-left:10px"><input type="radio" name="option_summer_not" value="0" checked> 部分一致</label>
            <input class="form-control" type="text" name="summernote_not" value="{{  old("summernote_not") }}">
          </div>
        </div>

        <div class="row">
          <!-- first_deposit_time_start-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.first_deposit_time_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="first_deposit_time_start"
                     value="{{ old("first_deposit_time_start") }}">
            </div>
          </div>

          <!-- first_deposit_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.first_deposit_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="first_deposit_time_end"
                     value="{{ old("first_deposit_time_end") }}">
            </div>
          </div>

          <!-- last_deposit_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_deposit_time_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="last_deposit_time_start"
                     value="{{ old("last_deposit_time_start") }}">
            </div>
          </div>
          <!-- last_deposit_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_deposit_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="last_deposit_time_end"
                     value="{{ old("last_deposit_time_end") }}">
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
                     value="{{ old("first_payment_time_start") }}">
            </div>
          </div>

          <!-- first_payment_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.first_payment_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="first_payment_time_end"
                     value="{{ old("first_payment_time_end") }}">
            </div>
          </div>

          <!-- last_payment_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_payment_time_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="last_payment_time_start"
                     value="{{ old("last_payment_time_start") }}">
            </div>
          </div>
          <!-- last_payment_time-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_payment_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="last_payment_time_end"
                     value="{{ old("last_payment_time_end") }}">
            </div>
          </div>
        </div>

        <div class="row">
          <!-- last_login_time start-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_login_time_start") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="last_login_time_start"
                     value="{{ old("last_login_time_start") }}">
            </div>
          </div>
          <!-- last_login_time end-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_login_time_end") }}</label>
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input class="form-control" type="text" name="last_login_time_end"
                     value="{{ old("last_login_time_end") }}">
            </div>
          </div>

          <!-- last_access_time_start -->
          {{--<div class="col-md-3 mb-3">--}}
          {{--<label>{{ __("horserace::be_form.last_access_time_start") }}</label>--}}
          {{--<div class="input-group date" data-provide="datepicker">--}}
          {{--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>--}}
          {{--<input class="form-control" type="text" name="last_access_time_start"--}}
          {{--value="{{ old("last_access_time_start") }}">--}}
          {{--</div>--}}
          {{--</div>--}}
          <!-- last_acsess_time_end-->
            {{--<div class="col-md-3 mb-3">--}}
            {{--<label>{{ __("horserace::be_form.last_access_time_end") }}</label>--}}
            {{--<div class="input-group date" data-provide="datepicker">--}}
            {{--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>--}}
            {{--<input class="form-control" type="text" name="last_access_time_end"--}}
            {{--value="{{ old("last_access_time_end") }}">--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>

        <div class="row">
          <!-- User stage -->
          <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
          {{-- <select class="selectpicker show-tick form-control ml-3 mb-3 col-md-2" name="specify_stage">
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
                           value="{{ $item->id }}-1">
                    <span class="input-span"></span>
                  </label>
                  <label class="checkbox checkbox-exclude checkbox-primary-exclude">
                    <input class="user_stage" name="user_stage_id[{{ $item->id }}]" type="radio"
                           value="{{ $item->id }}-0">
                    <span class="input-span"></span>
                  </label>
                  {{ $item->name }}
                </div>
              </div>
            @endforeach
          </div>
        </div>

      </div>
      <div class="ibox-footer text-right">
        <button style="margin-right: 8px" type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_save_query">{{ __("horserace::be_form.save_query") }}</button>
        <button class="btn btn-primary mr-2" type="submit">
          {{ __("horserace::be_form.btn_search") }}
        </button>
      </div>
      <div class="modal fade" id="modal_save_query" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="border-radius:20px">
            <div class="modal-header">
              <h4 class="modal-title">{{ __("horserace::be_form.name_query") }}</h4>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" name="name_query">
            </div>
            <div class="modal-footer">
              <!-- <a href="{{ route('admin.add.query.search.user') }}" class="btn btn-primary">save</a> -->
              <input type="submit" class="btn btn-primary" value="{{ __("horserace::be_form.btn_save") }}" onclick='this.form.action="{{ route('admin.add.query.search.user') }}";'>
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ __("horserace::be_form.close") }}</button>
            </div>
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
    // Add bonus point
    // $(document).on('click', 'button.btn-all', function () {
    //   var check = document.getElementsByClassName('user_stage');
    //   for (var i = 0; i < check.length; i++) {
    //     if (check[i].type == 'checkbox') {
    //       check[i].checked = true;
    //     }
    //   }
    // });

     // Remove bonus point
    $(document).on('click', 'button.btn-remove-all', function () {
      var uncheck = document.getElementsByClassName('user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'radio') {
          uncheck[i].checked = false;
        }
      }
    });

        $('input[name*=user_stage_id]').on('click', function(){
      if($(this).attr('previousValue') == 'true'){
        this.checked = false;
      } else {
        $('input[name*=user_stage_id]').attr('previousValue', false);
      }
      $(this).attr('previousValue', this.checked);
    });

    $('#query_search').on('change', function(){
      if(this.value == -1){
        $('input[type=text], input[type=number]').val('');
        $('input[type=checkbox], input[type=radio]').prop('checked',false);
        $('input[name="option_summer"][value="0"]').prop('checked', true);
        $('input[name="option_summer_not"][value="0"]').prop('checked', true);
        $('select').val(null);
        $('select[name="search_match_type"]').val(0);
        $('.selectpicker').selectpicker('refresh');
      }
      else{
        let value = JSON.parse(this.value);
        let result = [];

        for(let i in value){
          result[i] = value[i];
        }
        let array_select = ['member_level', 'age', 'prediction_type', 
        'entrance_id', 'stop_mail', 'sns_register', 'media_code', 'search_match_type'];

        $('input[name*=user_stage_id').prop('checked',false);
        $('input[name*=gender').prop('checked',false);

        for(let i in result){
            if (i == 'user_stage_id'){
              for(let k in result[i]){
                $('input[value="' + result[i][k] + '"]').prop('checked',true);
              }
            }
            else if (i == 'gender'){
              for(let j in result[i]){
                $('input[name="gender[' + result[i][j] + ']"]').prop('checked', true);
              }
            }
            else if (i == 'option_summer'){
              $('input[name="option_summer"][value="'+ result[i] +'"]').prop('checked', true);
            }
            else if (i == 'option_summer_not'){
              $('input[name="option_summer_not"][value="'+ result[i] +'"]').prop('checked', true);
            }
            else if (array_select.includes(i)){
              $('select[name="' + i + '"]').val(result[i]);
            }
            else{
              $('input[name="' + i + '"]').val(result[i]);
            }
        }

        $('.selectpicker').selectpicker('refresh');
      }
    });
  </script>
@endsection
