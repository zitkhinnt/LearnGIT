@extends('horserace::backend.layouts.design')
@section('title','Dashboard')
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
  <!-- Mail template -->

  <!-- -->

  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="ibox">
      <form id="form_mail_bulk" action="{{ route("admin.mail_bulk.store") }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="0">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __("horserace::be_sidebar.add_mail_bulk") }}
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
                     value="{{ old('mail_from_address') }}">
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
                     value="{{ old('mail_from_name') }}">
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
                     value="{{ old('mail_title') }}">
              @if ($errors->has('mail_title'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_title') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="row">
            <!-- reserve_datetime -->
            <div class="col-sm-3 form-group mb-3">
              <label>{{ __("horserace::be_form.reserve_datetime") }}</label>
              <div class="input-group datetime">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control reserve_datetime {{ $errors->has('reserve_datetime') ? ' is-invalid' : '' }}"
                       type="text" name="reserve_datetime" value="{{ old("reserve_datetime") }}">
              </div>
              @if ($errors->has('reserve_datetime'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('reserve_datetime') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="row ">
            <!-- Mail body -->
            <div class="col-md-12 mb-3">
              <label>{{ __("horserace::be_form.mail_body") }}</label>
              <!-- <textarea id="summernote" data-plugin="summernote" data-air-mode="true" class="summernote mail_body"
                        name="mail_body">{{ old('mail_body') }}</textarea> -->
              <textarea data-air-mode="true" class="form-control mail_body" rows="15"  name="mail_body">{{ old('mail_body') }}</textarea>
              <button class="btn btn-dark mt-3" type="button"
                      data-toggle="modal"
                      data-target="#mail-replace">
                {{ __("horserace::be_form.btn_mail_replace") }}
              </button>
            </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
          <button class="btn btn-primary btn-mail-bulk mr-2" type="button"
                  data-toggle="modal"
                  data-target="#confirmMailBulk">
            {{ __("horserace::be_form.btn_book_mail") }}
          </button>
        </div>
        <!-- Condition user -->
        <input type="hidden" name="condition"
               value="{{ !is_null(old('condition')) ? old('condition') : $data["condition"] }}">
      </form>
    </div>
  </div>
  <!-- END PAGE CONTENT-->
  <!-- Popup-->
  @include('horserace::backend.popup.mail_replace')
  @include('horserace::backend.popup.confirm_mail_bulk')
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
            // $('#summernote').summernote('code', response.mail_body);
            $('#summernote').val(response.mail_body);
          }
        })
      });
    });
  </script>

  <script>
    $(".btn-mail-bulk").click(function () {
      var mail_from_address = $(".mail_from_address").val();
      var mail_from_name = $(".mail_from_name").val();
      var mail_title = $(".mail_title").val();
      var reserve_datetime = $(".reserve_datetime").val();
      var mail_body = $('.mail_body').val();

      // Set value popup
      $(".popup_mail_from_address").html(mail_from_address);
      $(".popup_mail_from_name").html(mail_from_name);
      $(".popup_mail_title").html(mail_title);
      $(".popup_reserve_datetime").html(reserve_datetime);
      // $("#summernote-popup").summernote('code', mail_body);
      $("#summernote-popup").val(mail_body);
    })
  </script>

  <script>
    $(".btn-confirm").click(function () {
      $("#form_mail_bulk").submit();
    })
  </script>  
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

    // $('#form_mail_bulk').submit(function() 
    // {
    //   var template_plaint_text = $("#form_mail_bulk .summernote").val();
    //   var index_begin =  template_plaint_text.indexOf("<style");
    //   var index_end = template_plaint_text.indexOf("</style>");   
    //   template_plaint_text =  template_plaint_text.replace(template_plaint_text.substring(index_begin, index_end), "");
    //   template_plaint_text = template_plaint_text.replace(/<\/p>/gi, "\n")
    //           .replace(/<br\/?>/gi, "\n")
    //           .replace(/<\/?[^>]+(>|$)/gi, "");
    //   $("#form_mail_bulk .summernote").val(template_plaint_text);
     
    // });
  </script>
      
@endsection
