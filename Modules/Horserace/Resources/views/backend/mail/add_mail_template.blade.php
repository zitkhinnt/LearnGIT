@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.mail_template_add"))
<style>
  .panel-heading
  {
    display: none;
  }
  .panel-body
  {
    white-space: pre-line;
  }
</style>
@section('content')
  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.mail_template_add"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.mail_template') }}">
      {{ __("horserace::be_sidebar.mail_template") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.mail_template_add") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form id="frmAdminMailTemplateStore" action="{{ route("admin.mail_template.store") }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="0">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.mail_template_add") }}
        </div>
      </div>
      <div class="ibox-body">
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <!-- Mail form address -->
            <label>{{ __("horserace::be_form.mail_from_address") }}</label>
            <input class="form-control {{ $errors->has('mail_from_address') ? ' is-invalid' : '' }}"
                   type="email" name="mail_from_address"
                   value="{{ is_null(old('mail_from_address')) ? MAIL_FROM_ADDRESS : old('mail_from_address') }}">
            @if ($errors->has('mail_from_address'))
              <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('mail_from_address') }}</strong>
                </span>
            @endif
          </div>
          <div class="col-md-6 mb-3">
            <!-- Name -->
            <label>{{ __("horserace::be_form.name_mail_template") }}</label>
            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                   type="text" name="name"
                   value="{{ old('name') }}">
            @if ($errors->has('name'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
            @endif
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <!-- Mail form name -->
            <label>{{ __("horserace::be_form.mail_from_name") }}</label>
            <input class="form-control {{ $errors->has('mail_from_name') ? ' is-invalid' : '' }}"
                   type="text" name="mail_from_name"
                   value="{{ is_null(old('mail_from_name')) ? MAIL_FROM_NAME : old('mail_from_name') }}">
            @if ($errors->has('mail_from_name'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_from_name') }}</strong>
                  </span>
            @endif
          </div>
          <div class="col-md-3 mb-3">
            <!-- Type -->
            <label>{{ __("horserace::be_form.type_mail_template") }}</label>
            <select class="selectpicker show-tick form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"
                    name="type">
              <option value="{{ null }}">
                {{ __("horserace::be_form.unset") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_REGISTER }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_REGISTER ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_register") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_PAYMENT }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_PAYMENT ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_payment") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_DEPOSIT }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_DEPOSIT ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_deposit") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_BULK }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_BULK ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_bulk") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_SCHEDULE }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_SCHEDULE ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_schedule") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_CONTACT }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_CONTACT ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_contact") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_FORGET_PASSWORD }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_FORGET_PASSWORD ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_forget_password") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_CHANGE_MAIL_PC }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_CHANGE_MAIL_PC ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_change_mail_pc") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_CHANGE_MAIL_MOBILE }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_CHANGE_MAIL_MOBILE ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_change_mail_mobile") }}
              </option>
              <option value="{{ MAIL_TEMPLATE_TYPE_ORDER }}"
                {{ old('type') == MAIL_TEMPLATE_TYPE_ORDER ? "selected" : "" }}>
                {{ __("horserace::be_form.mail_template_type_order") }}
              </option>
            </select>
            @if ($errors->has('type'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('type') }}</strong>
                  </span>
            @endif
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <!-- Title -->
            <label>{{ __("horserace::be_form.mail_title") }}</label>
            <input class="form-control {{ $errors->has('mail_title') ? ' is-invalid' : '' }}"
                   type="text" name="mail_title"
                   value="{{ old('mail_title') }}">
            @if ($errors->has('mail_title'))
              <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_title') }}</strong>
                  </span>
            @endif
          </div>
          <div class="col-md-6 mb-3">

          </div>
        </div>

        <div class="row mb-3">
          <!-- Mail body -->
          <div class="col-md-12 mb-3">
            <label>{{ __("horserace::be_form.mail_body") }}</label>
            @if ($errors->has('mail_body'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('mail_body') }}</strong>
              </span>
            @endif
            <!-- <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
                      name="mail_body">{{ old('mail_body') }}</textarea> -->
            <textarea class="form-control mail_body" rows="15" data-air-mode="true"
                      name="mail_body">{{ old('mail_body') }}</textarea>
            <button class="btn btn-dark mt-3" type="button"
                    data-toggle="modal"
                    data-target="#mail-replace">
              {{ __("horserace::be_form.btn_mail_replace") }}
            </button>
          </div>
        </div>
      </div>
      <div class="ibox-footer row mt-4">
        <div class="col-sm-10 ">
          <a class="btn btn-secondary" href="{{ route('admin.mail_template')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>
        <div class="col-sm-2 ">
          <div class="text-right">
            <button class="btn btn-primary mr-2" type="submit">
              {{ __("horserace::be_form.btn_add") }}
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- popup -->
@include('horserace::backend.popup.mail_replace')

<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
  <!-- <script>
    // using text area
    $(function () {
      $('#summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
    });
  </script> -->

<script>
    $(".summernote").summernote
    (
      { 
    
      }
    ).on("summernote.enter", function(we, e)
    { 
        $(this).summernote("pasteHTML", "<br><br>"); 
        e.preventDefault(); 
    });
  </script>
    
<script>
  $(".summernote").summernote
    (
      { 
          
      }
    ).on("summernote.paste", function(we, e)
    { 
        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text'); 
       
        e.preventDefault();          
        // Firefox fix
        setTimeout(function () {
              bufferText = bufferText.replace(/\r?\n/gi, '<br>');
              document.execCommand("insertHTML", false, bufferText);
          }, 10);
    });
  
</script>
  
  <script>    

      $('#frmAdminMailTemplateStore').submit(function() 
      {
        var template_plaint_text = $("#frmAdminMailTemplateStore .summernote").val();
        var index_begin =  template_plaint_text.indexOf("<style");
        var index_end = template_plaint_text.indexOf("</style>");   
        template_plaint_text =  template_plaint_text.replace(template_plaint_text.substring(index_begin, index_end), "");
        template_plaint_text = template_plaint_text.replace(/<\/p>/gi, "\n")
                .replace(/<br\/?>/gi, "\n")
                .replace(/<\/?[^>]+(>|$)/gi, "");
        $("#frmAdminMailTemplateStore .summernote").val(template_plaint_text);
       
      });
    </script>
@endsection