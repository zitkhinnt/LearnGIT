@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.partner_edit"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.partner"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.partner') }}"> {{ __("horserace::be_sidebar.partner") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.partner_edit") }}</li>
@endsection
<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.partner.store') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $data["partner"]->id }}">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.partner_edit") }}
        </div>
      </div>
      <div class="ibox-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.name") }}</label>
              <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text"
                     value="{{ $data['partner']->name }}" name="name">
              @if ($errors->has('name'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.media_code_prefix") }}</label>
              <input class="form-control {{ $errors->has('media_code') ? ' is-invalid' : '' }}"
                     type="text" name="media_code" value="{{ $data['partner']->media_code}}">
              @if ($errors->has('media_code'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('media_code') }}</strong>
                  </span>
              @endif
            </div>
            <!-- show payment -->
            <div class="form-group mb-4">
              <label class="checkbox">
                <input class="form-control" type="checkbox" name="billing_flg"
                       {{ $data["partner"]->billing_flg == BILLING_FLG_ENABLE ? "checked" : "" }}
                       value="{{ BILLING_FLG_ENABLE }}">
                <span class="input-span"></span>
                {{ __("horserace::be_form.billing_flg") }}
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control {{ $errors->has('login_id') ? ' is-invalid' : '' }}"
                     type="text"
                     value="{{ $data['partner']->login_id }}" name="login_id">
              @if ($errors->has('login_id'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('login_id') }}</strong>
                  </span>
              @endif
            </div>
            <div class="form-group mb-4">
              <label>{{ __("horserace::be_form.password") }}</label>
              <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                     type="text" value="{{ $data['partner']->password_text }}" name="password">
              @if ($errors->has('password'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('password') }}</strong>
                   </span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="ibox-footer row mt-4">
        <div class="col-sm-10 ">
          <a class="btn btn-secondary" href="{{ route('admin.partner')}}">
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
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
