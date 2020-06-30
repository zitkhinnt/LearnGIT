@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.blog_edit"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.blog"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.blog') }}"> {{ __("horserace::be_sidebar.blog") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.blog_edit") }}</li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.blog_edit") }}
      </div>
      <div class="">
      </div>
    </div>

    <div class="ibox-body">
      <!-- Form edit Blog-->
      <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id" value="{{ $data['edit']->id }}">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <!-- title -->
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.blog_title") }}</label>
                <input class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                       type="text" name="title"
                       placeholder="{{ __("horserace::be_form.title") }}"
                       value="{{ $data['edit']->title }}">
                @if ($errors->has('title'))
                  <span class="invalid-feedback" style="color: red; display: block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <!-- status -->
<!--           <div class="col-lg-3">
            <div class="col-sm-12 form-group">
              <label>{{ __("horserace::be_form.rate") }}</label>
              <select class="selectpicker show-tick form-control" name="status">
                <option value="{{ BLOG_STATUS_0 }}"
                  {{ $data['edit']->status == BLOG_STATUS_0 ? "selected" : "" }}>
                  {{ __("horserace::be_form.blog_status_0") }}
                </option>
                <option value="{{ BLOG_STATUS_1 }}"
                  {{ $data['edit']->status == BLOG_STATUS_1 ? "selected" : "" }}>
                  {{ __("horserace::be_form.blog_status_1") }}
                </option>
                <option value="{{ BLOG_STATUS_2 }}"
                  {{ $data['edit']->status == BLOG_STATUS_2 ? "selected" : "" }}>
                  {{ __("horserace::be_form.blog_status_2") }}
                </option>
                <option value="{{ BLOG_STATUS_3 }}"
                  {{ $data['edit']->status == BLOG_STATUS_3 ? "selected" : "" }}>
                  {{ __("horserace::be_form.blog_status_3") }}
                </option>
                <option value="{{ BLOG_STATUS_4 }}"
                  {{ $data['edit']->status == BLOG_STATUS_4 ? "selected" : "" }}>
                  {{ __("horserace::be_form.blog_status_4") }}
                </option>
                <option value="{{ BLOG_STATUS_5 }}"
                  {{ $data['edit']->status == BLOG_STATUS_5 ? "selected" : "" }}>
                  {{ __("horserace::be_form.blog_status_5") }}
                </option>
              </select>
            </div>
          </div> -->
          <!-- Public at -->
          <div class="col-lg-3">
            <div class="col-sm-12 form-group">
              <label>{{ __("horserace::be_form.public_at") }}</label>
              <div class="input-group datetime">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control {{ $errors->has('public_at') ? ' is-invalid' : '' }}"
                       type="text" value="{{ date_format(date_create($data['edit']->public_at), "Y-m-d H:i:s")  }}"
                       name="public_at">
              </div>
              @if ($errors->has('public_at'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('public_at') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="col-lg-3">
            <div class="col-sm-12 form-group">
              <label>{{ __("horserace::be_form.public_end") }}</label>
              <div class="input-group datetime">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control {{ $errors->has('public_end') ? 'is-invalid' : '' }}" 
                value="{{ date_format(date_create($data['edit']->public_end), "Y-m-d H:i:s") }}" name="public_end">
              </div>
              @if($errors->has('public_end'))
                  <span class="invalid-feedback" style="color:red; display:block">
                    <strong>{{ $errors->first('public_end') }}</strong>
                  </span>
                @endif
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <!-- content -->
          <div class="col-sm-12">
            <label>{{ __("horserace::be_form.content") }}</label>
            <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
                      name="content">{{ $data['edit']->content }}</textarea>
            @if ($errors->has('content'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-10 ">
            <a class="btn btn-secondary" href="{{ route('admin.blog')}}">
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
