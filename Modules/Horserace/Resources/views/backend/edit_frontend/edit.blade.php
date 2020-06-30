@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.prediction_type_edit"))
@section('content')
  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.frontend_edit"))
@section('breadcrumb_item')

@endsection
<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form action="{{ route('admin.image.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="ibox-body">

        <div class="row">
          <!-- Image upload -->
          <!-- Banner Images -->
          <div class="col-md-6 mb-3 ">
            <label>{{ __("horserace::be_form.image") }}</label>
            <div class="row">
              <div class="col-md-4">
                <label class="btn btn-primary file-input mr-2 form-control">
                    <span class="btn-icon">
                      <i class="la la-cloud-upload"></i>
                      {{ __("horserace::be_form.btn_choose_file") }}
                    </span>
                  <input type="file" id="fileUpload" name="image_attention" value="">

                </label>
              </div>
              <div class="col-md-12 image-holder">
              <img class="thumb-image" 
              src="{{  asset($data['frontendimages'][IMAGE_FRONTEND_CODE_ATTENTION]['image'])  }}"/>
              </div>
            </div>
          </div>
        </div>

      <div class="ibox-footer text-right">
        <button class="btn btn-primary mr-2" type="submit">
          {{ __("horserace::be_form.btn_save") }}
        </button>
      </div>
    </form>
  </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
   <script>
    // using jquery for preview image
    $("#fileUpload").on('change', function () {
      //Get count of selected files
      var countFiles = $(this)[0].files.length;
      var imgPath = $(this)[0].value;
      var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      var image_holder = $(".image-holder");
      image_holder.empty();
      if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
        if (typeof(FileReader) != "undefined") {
          //loop for each file selected for uploaded.
          for (var i = 0; i < countFiles; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $("<img />", {
                "src": e.target.result,
                "class": "thumb-image"
              }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[i]);
          }
        } else {
          alert("This browser does not support FileReader.");
        }
      } else {
        alert("Please select only images");
      }
    });
  </script>
@endsection
