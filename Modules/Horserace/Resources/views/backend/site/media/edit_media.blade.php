@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.media_edit"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.media"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.media') }}"> {{ __("horserace::be_sidebar.media") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.media_edit") }}</li>
@endsection

<div class="media-content fade-in-up">
  <div class="ibox">

    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.media_edit") }}
      </div>
      <div class="">

      </div>
    </div>

    <div class="ibox-body">
      <!-- Form edit media-->
      <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id" value="{{ $data['media']->id }}">
        <div class="row">
          <!-- Name -->
          <div class="col-lg-4 form-group">
            <label>{{ __("horserace::be_form.media_name") }}</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                   type="text" name="name" value="{{ $data['media']->name }}"
                   placeholder="{{ __("horserace::be_form.media_name") }}">
            @if ($errors->has('name'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
            @endif
          </div>
          <!-- code -->
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.media_code") }}</label>
            <input class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}"
                   type="text" name="code" value="{{ $data['media']->code }}"
                   placeholder="{{ __("horserace::be_form.media_code") }}">
            @if ($errors->has('code'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('media') }}</strong>
                  </span>
            @endif
          </div>
          <!-- link -->
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.link") }}</label>
            <input class="form-control {{ $errors->has('link') ? ' is-invalid' : '' }}"
                   type="text" name="link" value="{{ $data['media']->link }}">
            @if ($errors->has('link'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('link') }}</strong>
                  </span>
            @endif
          </div>
        </div>

        <div class="row">
          <!-- Ad type -->
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.ad_type") }}</label>
            <select class="selectpicker show-tick form-control" name="ad_type" id="ad_type">
              <option value="{{ ADVERTISE_TYPE_AF }}"
                {{ $data["media"]->ad_type == ADVERTISE_TYPE_AF ? "selected" : "" }}>
                {{ __("horserace::be_form.ad_type_af")  }}
              </option>
              <option value="{{ ADVERTISE_TYPE_SHARE }}"
                {{ $data["media"]->ad_type == ADVERTISE_TYPE_SHARE ? "selected" : "" }}>
                {{ __("horserace::be_form.ad_type_share")  }}
              </option>
              <option value="{{ ADVERTISE_TYPE_PERMANENT }}"
                {{ $data["media"]->ad_type == ADVERTISE_TYPE_PERMANENT ? "selected" : "" }}>
                {{ __("horserace::be_form.ad_type_pernament")  }}
              </option>
              </option>
            </select>
          </div>
          <!-- cost -->
          <div class="col-sm-4 form-group">
            <label>{{ __("horserace::be_form.cost") }}</label>
            <span id="ad_cost_span">{{$data["media"]->ad_type == ADVERTISE_TYPE_SHARE ? '（％）' : '（¥）'}}</span>
            <input class="form-control {{ $errors->has('cost') ? ' is-invalid' : '' }}"
                    type="number" name="cost" value="{{ $data['media']->cost }}"
                    placeholder="{{ __("horserace::be_form.media_link") }}">
            @if ($errors->has('cost'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('cost') }}</strong>
                  </span>
            @endif
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-sm-10 ">
            <a class="btn btn-secondary" href="{{ route('admin.media')}}">
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
<!-- END media CONTENT-->
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

    $('#ad_type').on('change', function(){
      let type = document.getElementById('ad_cost_span');
      if(this.value == 1)
        type.innerHTML = '（％）';
      else 
        type.innerHTML = '（¥）';
    });
  </script>
@endsection