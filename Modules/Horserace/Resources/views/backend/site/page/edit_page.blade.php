@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.page_edit"))
@section('content')

  <!-- breadcumb -->
  @section('page_title', __("horserace::be_sidebar.page"))
  @section('breadcrumb_item')
    <li class="breadcrumb-item">
      <a href="{{ route('admin.page') }}"> {{ __("horserace::be_sidebar.page") }} </a>
    </li>
    <li class="breadcrumb-item">{{ __("horserace::be_sidebar.page_edit") }}</li>
  @endsection

  <div class="page-content fade-in-up">
    <div class="ibox">

      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.page_edit") }}
        </div>
        <div class="">

        </div>
      </div>

      <div class="ibox-body">
        <!-- Form edit Page-->
        <form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{!! csrf_token() !!}">
          <input type="hidden" name="id" value="{{ $data['edit']->id }}">
          <div class="row">
            <!-- Name -->
            <div class="col-lg-4 form-group">
              <label>{{ __("horserace::be_form.name") }}</label>
              <input class="form-control form-control-solid {{ $errors->has('name') ? ' is-invalid' : '' }}"
                     type="text" name="name" value="{{ $data['edit']->name }}"
                     placeholder="{{ __("horserace::be_form.page_name") }}">
              @if ($errors->has('name'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>
            <!-- code -->
            <div class="col-sm-4 form-group">
              <label>{{ __("horserace::be_form.code") }}</label>
              <input class="form-control form-control-solid {{ $errors->has('code') ? ' is-invalid' : '' }}"
                     type="text" name="code" value="{{ $data['edit']->code }}"
                     placeholder="{{ __("horserace::be_form.page_code") }}" readOnly>
              @if ($errors->has('code'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('page') }}</strong>
                  </span>
              @endif
            </div>
            <!-- link -->
            <div class="col-sm-4 form-group">
              <label>{{ __("horserace::be_form.link") }}</label>
              <input class="form-control form-control-solid {{ $errors->has('link') ? ' is-invalid' : '' }}"
                     type="text" name="link" value="{{ $data['edit']->link }}"
                     placeholder="{{ __("horserace::be_form.page_link") }}" readOnly>
              @if ($errors->has('link'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('link') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <!-- source -->
          <div class="row mt-4">
            <div class="col-sm-12">
              <label>{{ __("horserace::be_form.source") }}</label>
              <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
                        name="source">{{ $data['edit']->source }}</textarea>
              @if ($errors->has('source'))
                <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('source') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-10 ">
              <a class="btn btn-secondary" href="{{ route('admin.page')}}">
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
  <!-- END PAGE CONTENT-->
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
