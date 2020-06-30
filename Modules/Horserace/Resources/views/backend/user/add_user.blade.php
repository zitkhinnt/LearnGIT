@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.add_user"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.add_user"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.user.search') }}">
      {{ __("horserace::be_sidebar.search_user") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.add_user") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.user.store') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="0">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.add_user") }}
        </div>
      </div>
      @if (Session::has('flash_message'))
          <div style="background-color: red;" class="alert alert-{!! Session::get('flash_level') !!}">
            {!! Session::get('flash_message') !!}
          </div>
      @endif
      <div class="ibox-body">
        <div class="row">
          <!-- login id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.login_id") }}</label>
            <input class="form-control" value="{{ !is_null(old("login_id")) ? old("login_id") : $data['login_id'] }}"
                   type="text" name="login_id" readonly>
            @if ($errors->has('login_id'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('login_id') }}</strong>
              </span>
            @endif
          </div>
          <!-- user key -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.user_key") }}</label>
            <input class="form-control" value="{{ !is_null(old("user_key")) ? old("user_key") : $data['user_key'] }}"
                   name="user_key" type="text" readonly>
          </div>
          <!-- mail pc-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.mail_pc") }}</label>
            <input class="form-control" type="email" name="mail_pc" value="{{ old("mail_pc") }}">
            @if ($errors->has('mail_pc'))
              <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('mail_pc') }}</strong>
                </span>
            @endif
          </div>
          <!-- mail mobile-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.mail_mobile") }}</label>
            <input class="form-control" type="email" name="mail_mobile" value="{{ old("mail_mobile") }}">
            @if ($errors->has('mail_mobile'))
              <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('mail_mobile') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="row">
          <!-- password-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.password") }}</label>
            <input class="form-control" type="text" name="password"
                   value="{{ !is_null(old("password")) ? old("password") : $data['password'] }}">
          </div>
          <!-- nick  name -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.nickname") }}</label>
            <input class="form-control" type="text" name="nickname" value="{{ old("nickname") }}">
            @if ($errors->has('nickname'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('nickname') }}</strong>
              </span>
            @endif
          </div>
          <!-- member level -->
          <!-- <div class="col-md-2 mb-3">
            <label class="form-control-label">
              {{ __("horserace::be_form.member_level") }}
            </label>
            <select class="selectpicker show-tick form-control" name="member_level">
               <option value="{{ MEMBER_LEVEL_TRIAL }}"
                {{ !is_null(old("member_level")) && old("member_level") == MEMBER_LEVEL_TRIAL ? "selected" : "" }}>
                {{ __("horserace::be_form.member_level_trail") }}
              </option>

              <option value="{{ MEMBER_LEVEL_EXCEPT }}"
                {{ old("member_level") == MEMBER_LEVEL_EXCEPT ? "selected" : "" }}>
                {{ __("horserace::be_form.member_level_except") }}
              </option>
            </select>
          </div> -->
          <!-- Media -->
                    <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.media_code") }}</label>
            <select class="selectpicker show-tick form-control" name="media_code">
              @foreach($data["media"] as $item)
                <option value="{{ $item->code }}"
                  {{  old("media_code") ==  $item->code ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
          </div>
          <!-- entrance_id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.entrance") }}</label>
            <select class="selectpicker show-tick form-control" name="entrance_id">
              @foreach($data["entrance"] as $item)
                <option value="{{ $item->id }}"
                  {{  old("entrance_id") ==  $item->id ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <!-- age-->
          <div class="col-md-2 mb-3">
            <label>{{ __("horserace::be_form.age") }}</label>
            <select class="selectpicker show-tick form-control" name="age">
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

          <!-- gender-->
          <div class="col-md-2 mb-3">
            <label>{{ __("horserace::be_form.gender") }}</label>
            <div class="d-flex mt-2">
              <label class="radio radio-inline radio-grey radio-primary">
                <input type="radio" name="gender" value="{{ MALE }}" checked>
                <span class="input-span">
                  </span>{{ __("horserace::be_form.male") }}</label>
              <label class="radio radio-inline radio-grey radio-primary">
                <input type="radio" name="gender" value="{{ FEMALE }}">
                <span class="input-span">
                  </span>{{ __("horserace::be_form.female") }}</label>
            </div>
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
                           value="{{ $item->id }}"
                      {{ isset(old("user_stage_id")[$item->id]) ? "checked" : "" }}>
                    <span class="input-span"></span>
                    {{ $item->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row">

        </div>
        <div class="row">
          <!-- Memo -->
          <div class="col-lg-12 mb-3">
            <label>{{ __("horserace::be_form.memo") }}</label>
            <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
                      name="memo"> </textarea>
          </div>
        </div>
      </div>

      <div class="ibox-footer row mt-4">
        <div class="col-sm-10 ">
          <a class="btn btn-secondary" href="{{ route('admin.user.search')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>
        <div class="col-sm-2 ">
          <div class="text-right">
            <button type="submit" class="btn btn-primary btn-air mr-2">
              {{ __("horserace::be_form.btn_add") }}
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
  <script>
    // using text area
    $(function () {
      $('#summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
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
<script>     
  window.addEventListener( "pageshow", function ( event )
  {
      var historyTraversal = event.persisted || 
                          ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
      if ( historyTraversal )
      {
      // Handle page restore.;
      window.location.reload();
      }
  });
</script>
