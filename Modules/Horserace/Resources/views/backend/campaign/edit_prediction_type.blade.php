@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.prediction_type_edit"))
@section('content')
  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.prediction_type"))
@section('breadcrumb_item')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.prediction.type') }}">
        {{ __("horserace::be_sidebar.prediction_type") }}
        </a>
    </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.prediction_type_edit") }}</li>
@endsection
<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
    <div class="ibox">
        <form action="{{ route("admin.prediction_type.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $data["prediction_type"]->id }}">
            <div class="ibox-head">
                <div class="ibox-title">
                {{ __("horserace::be_sidebar.prediction_type_edit") }}
                </div>
            </div>

            <!-- group body -->
            <div class="ibox-body">

                <!-- group detail -->
                <div class="row">

                    <!-- group common -->
                    <div class="col-md-12 col-lg-6">

                        <!-- name -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.name") }}</label>
                                <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        type="text" name="name"
                                        value="{{ $data["prediction_type"]->name }}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- code -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.code") }}</label>
                                <input class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}"
                                    type="text" name="code" disabled
                                    value="{{ $data["prediction_type"]->code }}">
                                @if ($errors->has('code'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- default_point -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_default_point") }}</label>
                                <input class="form-control {{ $errors->has('default_point') ? ' is-invalid' : '' }}"
                                        type="number" name="default_point"
                                        min="0"
                                        value="{{ $data["prediction_type"]->default_point }}">
                                @if ($errors->has('default_point'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('default_point') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Banner Images -->
                        <div class="row mb-3">
                            <!-- Image upload -->
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.image") }}</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="btn btn-primary file-input mr-2 form-control">
                                            <span class="btn-icon">
                                                <i class="la la-cloud-upload"></i>
                                                {{ __("horserace::be_form.btn_choose_file") }}
                                            </span>
                                            <input type="file" id="fileUpload" name="image"
                                                value="{{ $data["prediction_type"]->image }}">
                                        </label>
                                    </div>
                                    <div class="col-md-12 image-holder">
                                    @if(!is_null($data["prediction_type"]->image))
                                        <img class="thumb-image w-100" src="{{ asset($data["prediction_type"]->image ) }}">
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- group table param -->
                    <div class="col-md-12 col-lg-6">

                        <!-- number_of_offers -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_number_of_offers") }}</label>
                                <input class="form-control {{ $errors->has('table_params.number_of_offers') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[number_of_offers]"
                                        value="{{ $data["prediction_type_table_params"]->number_of_offers ?? '' }}">
                                @if ($errors->has('table_params.number_of_offers'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.number_of_offers') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- denomination -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_denomination") }}</label>
                                <select name="table_params[denomination]" class="selectpicker form-control">
                                    <option 
                                        value="{{PREDICTION_TYPE_DENOMINATION_1}}"
                                        {{ 
                                            ($data["prediction_type_table_params"] 
                                            && $data["prediction_type_table_params"]->denomination == PREDICTION_TYPE_DENOMINATION_1)
                                            ? "selected" : "" 
                                        }}
                                    >
                                        {{PREDICTION_TYPE_DENOMINATION_1}}
                                    </option>
                                    <option 
                                        value="{{PREDICTION_TYPE_DENOMINATION_2}}"
                                        {{ 
                                            ($data["prediction_type_table_params"] 
                                            && $data["prediction_type_table_params"]->denomination == PREDICTION_TYPE_DENOMINATION_2)
                                            ? "selected" : "" 
                                        }}
                                    >
                                        {{PREDICTION_TYPE_DENOMINATION_2}}
                                    </option>
                                    <option 
                                        value="{{PREDICTION_TYPE_DENOMINATION_3}}"
                                        {{ 
                                            ($data["prediction_type_table_params"] 
                                            && $data["prediction_type_table_params"]->denomination == PREDICTION_TYPE_DENOMINATION_3)
                                            ? "selected" : "" 
                                        }}
                                    >
                                        {{PREDICTION_TYPE_DENOMINATION_3}}
                                    </option>
                                </select>
                                @if ($errors->has('table_params.denomination'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.denomination') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- score -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_score") }}</label>
                                <input class="form-control {{ $errors->has('table_params.score') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[score]"
                                        value="{{ $data["prediction_type_table_params"]->score ?? '' }}">
                                @if ($errors->has('table_params.score'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.score') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- investment_money -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_investment_money") }}</label>
                                <input class="form-control {{ $errors->has('table_params.investment_money') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[investment_money]"
                                        value="{{ $data["prediction_type_table_params"]->investment_money ?? '' }}">
                                @if ($errors->has('table_params.investment_money'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.investment_money') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- target_amount -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_target_amount") }}</label>
                                <input class="form-control {{ $errors->has('table_params.target_amount') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[target_amount]"
                                        value="{{ $data["prediction_type_table_params"]->target_amount ?? '' }}">
                                @if ($errors->has('table_params.target_amount'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.target_amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- deadline_for_participation -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_deadline_for_participation") }}</label>
                                <input class="form-control {{ $errors->has('table_params.deadline_for_participation') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[deadline_for_participation]"
                                        value="{{ $data["prediction_type_table_params"]->deadline_for_participation ?? '' }}">
                                @if ($errors->has('table_params.deadline_for_participation'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.deadline_for_participation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- release_time -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_release_time") }}</label>
                                <input class="form-control {{ $errors->has('table_params.release_time') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[release_time]"
                                        value="{{ $data["prediction_type_table_params"]->release_time ?? '' }}">
                                @if ($errors->has('table_params.release_time'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.release_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- target_race -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_target_race") }}</label>
                                <input class="form-control {{ $errors->has('table_params.target_race') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[target_race]"
                                        value="{{ $data["prediction_type_table_params"]->target_race ?? '' }}">
                                @if ($errors->has('table_params.target_race'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.target_race') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- participation_fee -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>{{ __("horserace::be_form.prediction_type_participation_fee") }}</label>
                                <input class="form-control {{ $errors->has('table_params.participation_fee') ? ' is-invalid' : '' }}"
                                        type="text" name="table_params[participation_fee]"
                                        value="{{ $data["prediction_type_table_params"]->participation_fee ?? '' }}">
                                @if ($errors->has('table_params.participation_fee'))
                                <span class="invalid-feedback" style="color: red; display: block">
                                    <strong>{{ $errors->first('table_params.participation_fee') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- before open content -->
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <label>{{ __("horserace::be_form.after_buy") }}</label>
                        <textarea id='txa_before_open_content' class="summernote" data-plugin="summernote" data-air-mode="true"
                            name="before_open_content"> {{ $data['prediction_type']->before_open_content ?? '' }} 
                        </textarea>
                    </div>
                </div>
                <!-- after open content -->
                <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label>{{ __("horserace::be_form.result") }}</label>
                            <textarea id='txa_after_open_content' class="summernote" data-plugin="summernote" data-air-mode="true"
                                name="after_open_content"> {{ $data['prediction_type']->after_open_content ?? '' }} 
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>           

            <!-- group btn -->
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
            alert("Pls select only images");
        }
    });
</script>
@endsection
