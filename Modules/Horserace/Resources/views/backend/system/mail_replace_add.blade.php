@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.mail_replace_add"))
@section('content')

  <!-- breadcumb -->
  @section('page_title', __("horserace::be_sidebar.mail_replace_add"))
  @section('breadcrumb_item')
    <li class="breadcrumb-item">
      <a href="{{ route('admin.mail_replace') }}"> {{ __("horserace::be_sidebar.mail_replace") }} </a>
    </li>
    <li class="breadcrumb-item">{{ __("horserace::be_sidebar.mail_replace_add") }}</li>
  @endsection

  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="row">
      <div class="col-md-12">
        <div class="ibox ibox-fullheight">
          <div class="ibox-head">
            <div class="ibox-title">
              {{ __("horserace::be_sidebar.mail_replace_add") }}
            </div>
          </div>
          <form class="form-horizontal" action="{{ route('admin.mail_replace.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="0">
            <div class="ibox-body">
              <div class="form-group mb-4 col-md-6">
                <label>{{ __("horserace::be_form.mail_replace_name") }}</label>
                <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                       type="text"
                       name="name" value="{{ old("name") }}">
                @if ($errors->has('name'))
                  <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group mb-4 col-md-12">
                <label>{{ __("horserace::be_form.mail_replace_source") }}</label>
                @if ($errors->has('source'))
                  <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('source') }}</strong>
                  </span>
                @endif
                <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
                          name="source">{{ old("source") }}</textarea>
              </div>
            </div>
            <div class="ibox-footer row mt-4">
              <div class="col-sm-10 ">
                <a class="btn btn-secondary" href="{{ route('admin.mail_replace')}}">
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
@endsection
