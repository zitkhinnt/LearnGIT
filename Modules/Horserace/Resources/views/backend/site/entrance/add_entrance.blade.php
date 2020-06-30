@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.entrance_add"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.entrance"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.entrance') }}"> {{ __("horserace::be_sidebar.entrance") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.entrance_add") }}</li>
@endsection

<div class="entrance-content fade-in-up">
  <div class="ibox">

    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.entrance_add") }}
      </div>
      <div class="">

      </div>
    </div>

    <div class="ibox-body">
      <!-- Form Add entrance-->
      <form action="{{ route('admin.entrance.store') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id" value="0">
        <div class="row">
          <!-- Name -->
          <div class="col-lg-4 form-group">
            <label>{{ __("horserace::be_form.entrance_name") }}</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                   type="text" name="name" value="{{ old("name") }}">
            @if ($errors->has('name'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
            @endif
          </div>
          <!-- code -->
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.entrance_default_point") }}</label>
            <input class="form-control {{ $errors->has('default_point') ? ' is-invalid' : '' }}"
                   type="number" name="default_point" value="{{ old("default_point") }}"
                   min="0">
            @if ($errors->has('default_point'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('default_point') }}</strong>
                  </span>
            @endif
          </div>
          <!-- entrance_default_user_stage -->
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.entrance_default_user_stage") }}</label>
            <select class="selectpicker show-tick form-control" name="default_user_stage">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              @foreach($data["user_stage"] as $item)
                <option value="{{ $item->id }}"
                  {{ old("default_user_stage") == $item->id ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
            @if ($errors->has('default_user_stage'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('default_user_stage') }}</strong>
                  </span>
            @endif
          </div>
        </div>

        <!-- Default flg -->
        <div class="row mt-4">
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.entrance_default_flg") }}</label>
            <div class="form-group">
              <label class="checkbox">
                <input type="checkbox" name="default_flg" value="{{ ENTRANCE_DEFAULT_ENABLE }}">
                <span class="input-span"></span>
                {{ __("horserace::be_form.entrance_default_flg") }}
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-sm-10 ">
            <a class="btn btn-secondary" href="{{ route('admin.entrance')}}">
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
      <!--End Form -->
    </div>
  </div>
</div>
<!-- END entrance CONTENT-->
@endsection

@section('javascript')
  <script type="text/javascript">
    // using text area
    $(function () {
      $('#summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
    });

  </script>
@endsection