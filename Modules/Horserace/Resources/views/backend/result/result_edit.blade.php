@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.result"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.result"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.blog') }}"> {{ __("horserace::be_sidebar.result") }} </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.result_edit") }}</li>
@endsection

<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.result_edit") }}
      </div>
      <div class="">
      </div>
    </div>

    <div class="ibox-body">
      <!-- Form Add blog-->
      <form action="{{ route('admin.result.store') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="id" value="{{ $data['result']->id }}">

        <div class="row">
          <div class="col-lg-12">
            <div class="row">
              <!-- course -->
              {{--<div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.course") }}</label>
                <input class="form-control {{ $errors->has('course_text') ? ' is-invalid' : '' }}"
                    type="text" name="course_text" value="{{ $data['result']->course_text }}"
                    placeholder="{{ __("horserace::be_form.course_text") }}">
                @if ($errors->has('course_text'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('course_text') }}</strong>
                </span>
                @endif
              </div>--}}

               <!-- course -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.course") }}</label>
                <select
                  class="selectpicker show-tick form-control {{ $errors->has('prediction_type') ? ' is-invalid' : '' }}"
                  name="course" id="course">
                  @foreach($data["prediction_type"] as $item)
                    <option value="{{ $item->id }}"
                      {{ $data['result']->course ==  $item->id ? "selected" : "" }} >
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
                @if ($errors->has('course'))
                  <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('course') }}</strong>
                  </span>
                @endif
              </div>

              <!-- double -->
              <div class="col-lg-3">
                <div class="col-sm-12 form-group">
                  <label>{{ __("horserace::be_form.double") }}</label>
                  <select
                    class="selectpicker show-tick form-control {{ $errors->has('double') ? ' is-invalid' : '' }}"
                    name="double" id="double" onchange="resultReadOnly();">
                    <option value="{{ DOUBLE_ON }}"
                      {{ $data['result']->double == DOUBLE_ON ? "selected" : ""}} >
                      {{ __("horserace::be_form.double_on") }}
                    </option>
                    <option value="{{ DOUBLE_OFF }}"
                      {{  $data['result']->double == DOUBLE_OFF ? "selected" : ""}} >
                      {{  __("horserace::be_form.double_off") }}
                    </option>
                  </select>
                  @if ($errors->has('double'))
                    <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('double') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <!-- date -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.date") }}</label>
                <div class="input-group date">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}"
                         type="text" value="{{ $data['result']->date }}" name="date">
                </div>
                @if ($errors->has('date'))
                  <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('date') }}</strong>
                  </span>
                @endif
              </div>

              <!-- korogashi -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.korogashi") }}</label>
                <input class="form-control {{ $errors->has('korogashi') ? ' is-invalid' : '' }}"
                       type="text" name="korogashi" value="{{ $data['result']->korogashi }}"
                       placeholder="{{ __("horserace::be_form.korogashi") }}">
                @if ($errors->has('korogashi'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('korogashi') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="row">
              <!-- race_no_1_title -->
              <div class="col-sm-3 form-group" style="display:none;">
                <label>{{ __("horserace::be_form.race_no_1_title") }}</label>
                <input class="form-control {{ $errors->has('race_no_1_title') ? ' is-invalid' : '' }}"
                       type="text" name="race_no_1_title" value="{{ $data['result']->race_no_1_title }}"
                       placeholder="{{ __("horserace::be_form.race_no_1_title") }}">
                @if ($errors->has('race_no_1_title'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('race_no_1_title') }}</strong>
                    </span>
                @endif
              </div>

              <!-- race_no_1 -->
              <div class="dropdown col-lg-3">
                <div class="col-sm-12 form-group">
                  <label>{{ __("horserace::be_form.race_no_1_num") }}</label>
                  <select
                    class="form-control {{ $errors->has('race_no_1_num') ? ' is-invalid' : '' }}"
                    name="race_no_1_num">
                    <option value="{{ null }}">
                      {{ __("horserace::be_form.unset") }}
                    </option>
                    <option value="{{ RACE_NO_1 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_1 ? "selected" : ""}} >
                      {{ __("horserace::be_form.race_no_1") }}
                    </option>
                    <option value="{{ RACE_NO_2 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_2 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_2") }}
                    </option>
                    <option value="{{ RACE_NO_3 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_3 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_3") }}
                    </option>
                    <option value="{{ RACE_NO_4 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_4 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_4") }}
                    </option>
                    <option value="{{ RACE_NO_5 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_5 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_5")  }}
                    </option>
                    <option value="{{ RACE_NO_6 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_6 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_6")  }}
                    </option>
                    <option value="{{ RACE_NO_7 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_7 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_7")  }}
                    </option>
                    <option value="{{ RACE_NO_8 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_8 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_8")  }}
                    </option>
                    <option value="{{ RACE_NO_9 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_9 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_9")  }}
                    </option>
                    <option value="{{ RACE_NO_10 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_10 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_10")  }}
                    </option>
                    <option value="{{ RACE_NO_11 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_11 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_11")  }}
                    </option>
                    <option value="{{ RACE_NO_12 }}"
                      {{ $data['result']->race_no_1_num == RACE_NO_12? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_12")  }}
                    </option>
                  </select>
                  @if ($errors->has('race_no_1_num'))
                    <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('race_no_1_num') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <!-- place_1 -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.place_1") }}</label>
                <select
                  class="form-control {{ $errors->has('place_1') ? ' is-invalid' : '' }}"
                  name="place_1">
                  <option value="{{ null }}">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  @foreach($data["venue"] as $item)
                    <option value="{{ $item->id }}"
                      {{ $data['result']->place_1 ==  $item->id ? "selected" : "" }} >
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
                @if ($errors->has('place_1'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('place_1') }}</strong>
                    </span>
                @endif
              </div>
              <!-- race_no_2_num -->
              <div class="col-lg-3">
                <div class="col-sm-12 form-group">
                  <label>{{ __("horserace::be_form.race_no_2_num") }}</label>
                  <select
                    class=" show-tick form-control {{ $errors->has('race_no_2_num') ? ' is-invalid' : '' }}"
                    name="race_no_2_num" id="race_no_2_num">
                    <option value="{{ null }}">
                      {{ __("horserace::be_form.unset") }}
                    </option>
                    <option value="{{ RACE_NO_1 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_1 ? "selected" : ""}} >
                      {{ __("horserace::be_form.race_no_1") }}
                    </option>
                    <option value="{{ RACE_NO_2 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_2 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_2") }}
                    </option>
                    <option value="{{ RACE_NO_3 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_3 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_3") }}
                    </option>
                    <option value="{{ RACE_NO_4 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_4 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_4") }}
                    </option>
                    <option value="{{ RACE_NO_5 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_5 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_5")  }}
                    </option>
                    <option value="{{ RACE_NO_6 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_6 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_6")  }}
                    </option>
                    <option value="{{ RACE_NO_7 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_7 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_7")  }}
                    </option>
                    <option value="{{ RACE_NO_8 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_8 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_8")  }}
                    </option>
                    <option value="{{ RACE_NO_9 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_9 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_9")  }}
                    </option>
                    <option value="{{ RACE_NO_10 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_10 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_10")  }}
                    </option>
                    <option value="{{ RACE_NO_11 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_11 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_11")  }}
                    </option>
                    <option value="{{ RACE_NO_12 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_12? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_12")  }}
                    </option>
                  </select>
                  @if ($errors->has('race_no_2_num'))
                    <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('race_no_2_num') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <!-- place_2 -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.place_2") }}</label>
                <select
                  class=" form-control {{ $errors->has('place_2') ? ' is-invalid' : '' }}"
                  name="place_2" id="place_2">
                  <option value="{{ null }}">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  @foreach($data["venue"] as $item)
                    <option value="{{ $item->id }}"
                      {{ $data['result']->place_2 ==  $item->id ? "selected" : "" }} >
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
                @if ($errors->has('place_2'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('place_2') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="row">
              <!-- race_no_2_title -->
              <div class="col-sm-3 form-group" style="display:none;">
                <label>{{ __("horserace::be_form.race_no_2_title") }}</label>
                <input class="form-control {{ $errors->has('race_no_2_title') ? ' is-invalid' : '' }}"
                       type="text" name="race_no_2_title" id="race_no_2_title"
                       value="{{ $data['result']->race_no_2_title }}"
                       placeholder="{{ __("horserace::be_form.race_no_2_title") }}">
                @if ($errors->has('race_no_2_title'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('race_no_2_title') }}</strong>
                    </span>
                @endif
              </div>

              <!-- race_no_2_num -->
              {{--<div class="col-lg-3">
                <div class="col-sm-12 form-group">
                  <label>{{ __("horserace::be_form.race_no_2_num") }}</label>
                  <select
                    class=" show-tick form-control {{ $errors->has('race_no_2_num') ? ' is-invalid' : '' }}"
                    name="race_no_2_num" id="race_no_2_num">
                    <option value="{{ null }}">
                      {{ __("horserace::be_form.unset") }}
                    </option>
                    <option value="{{ RACE_NO_1 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_1 ? "selected" : ""}} >
                      {{ __("horserace::be_form.race_no_1") }}
                    </option>
                    <option value="{{ RACE_NO_2 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_2 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_2") }}
                    </option>
                    <option value="{{ RACE_NO_3 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_3 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_3") }}
                    </option>
                    <option value="{{ RACE_NO_4 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_4 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_4") }}
                    </option>
                    <option value="{{ RACE_NO_5 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_5 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_5")  }}
                    </option>
                    <option value="{{ RACE_NO_6 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_6 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_6")  }}
                    </option>
                    <option value="{{ RACE_NO_7 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_7 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_7")  }}
                    </option>
                    <option value="{{ RACE_NO_8 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_8 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_8")  }}
                    </option>
                    <option value="{{ RACE_NO_9 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_9 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_9")  }}
                    </option>
                    <option value="{{ RACE_NO_10 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_10 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_10")  }}
                    </option>
                    <option value="{{ RACE_NO_11 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_11 ? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_11")  }}
                    </option>
                    <option value="{{ RACE_NO_12 }}"
                      {{ $data['result']->race_no_2_num == RACE_NO_12? "selected" : ""}} >
                      {{  __("horserace::be_form.race_no_12")  }}
                    </option>
                  </select>
                  @if ($errors->has('race_no_2_num'))
                    <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('race_no_2_num') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <!-- place_2 -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.place_2") }}</label>
                <select
                  class=" show-tick form-control {{ $errors->has('place_2') ? ' is-invalid' : '' }}"
                  name="place_2" id="place_2">
                  <option value="{{ null }}">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  @foreach($data["venue"] as $item)
                    <option value="{{ $item->id }}"
                      {{ $data['result']->place_2 ==  $item->id ? "selected" : "" }} >
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
                @if ($errors->has('place_2'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('place_2') }}</strong>
                    </span>
                @endif
              </div>--}}
            </div>

            <div class="row">
              <!-- ticket_type -->
              <div class="col-sm-3 form-group">
                <label>{{ __("horserace::be_form.ticket_type") }}</label>
                <select
                  class="selectpicker show-tick form-control {{ $errors->has('place_2') ? ' is-invalid' : '' }}"
                  name="ticket_type">
                  <option value="{{ null }}">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  <option value="{{ TICKET_TYPE_1 }}"
                    {{ $data['result']->ticket_type == TICKET_TYPE_1 ? "selected" : ""}} >
                    {{ __("horserace::be_form.ticket_type_1") }}
                  </option>
                  <option value="{{ TICKET_TYPE_2 }}"
                    {{ $data['result']->ticket_type == TICKET_TYPE_2 ? "selected" : ""}} >
                    {{  __("horserace::be_form.ticket_type_2") }}
                  </option>
                  <option value="{{ TICKET_TYPE_3 }}"
                    {{ $data['result']->ticket_type == TICKET_TYPE_3 ? "selected" : ""}} >
                    {{  __("horserace::be_form.ticket_type_3") }}
                  </option>
                </select>
                @if ($errors->has('ticket_type'))
                  <span class="invalid-feedback" style="color: red; display: block">
                      <strong>{{ $errors->first('ticket_type') }}</strong>
                    </span>
                @endif
              </div>

              <!-- bike_number 1 -->
              <div class="col-lg-3 mb-3">
                <label>{{ __("horserace::be_form.bike_number") }}</label>
                <div class="row">
                  <label class="col-form-label pr-0 ml-2">1着</label>
                  <div class="col-sm-2 pr-0 pl-0">
                    <input name="bike_number_1" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->bike_number_1}}">
                  </div>
                  <label class="col-form-label pr-0 ml-2">2着</label>
                  <div class="col-sm-2 pr-0 pl-0">
                    <input name="bike_number_2" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->bike_number_2}}">
                  </div>
                  <label class="col-form-label pr-0 ml-2">3着</label>
                  <div class="col-sm-2 pr-0 pl-0">
                    <input name="bike_number_3" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->bike_number_3}}">
                  </div>
                </div>
              </div>

               <!-- bike_number 2 -->
               <div class="col-lg-3 mb-3">
                <label>{{ __("horserace::be_form.bike_number") }}</label>
                <div class="row">
                  <label class="col-form-label pr-0 ml-2">1着</label>
                  <div class="col-sm-2 pr-0 pl-0">
                    <input id ='bike_number_1_2' name="bike_number_1_2" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->bike_number_1_2}}">
                  </div>
                  <label class="col-form-label pr-0 ml-2">2着</label>
                  <div class="col-sm-2 pr-0 pl-0">
                    <input id ='bike_number_2_2' name="bike_number_2_2" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->bike_number_2_2}}">
                  </div>
                  <label class="col-form-label pr-0 ml-2">3着</label>
                  <div class="col-sm-2 pr-0 pl-0">
                    <input id ='bike_number_3_2' name="bike_number_3_2" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->bike_number_3_2}}">
                  </div>
                </div>
              </div>

              <!-- won -->
              <div class="col-sm-3 mb-3">
                <label>{{ __("horserace::be_form.won") }}</label>
                <div class="row">
                  <div class="col-sm-3 pr-0 pl-0">
                    <input name="won_man" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->won_man}}">
                  </div>
                  <label class="col-form-label ml-2 pr-0">万</label>

                  <div class="col-sm-3 pr-0 pl-0  ml-3">
                    <input name="won_yen" class="form-control pr-0" type="number" min="0"
                           value="{{$data['result']->won_yen}}">
                  </div>
                  <label class="col-form-label ml-2 pr-0">円</label>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="row mt-4">
          <div class="col-sm-10 ">
            <a class="btn btn-secondary" href="{{ route('admin.result')}}">
              {{ __("horserace::be_form.btn_back") }}
            </a>
          </div>
          <div class="col-sm-2 ">
            <div class="text-right">
              <button type="submit" class="btn btn-primary btn-air mr-2">
                {{ __("horserace::be_form.btn_edit") }}
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
    $(document).ready(function () {
      resultReadOnly();
    })

    function resultReadOnly() {
      var type = document.getElementById("double").value;

      if (type == '{{ DOUBLE_OFF }}') {
        document.getElementById("race_no_2_title").readOnly = true;
        document.getElementById("race_no_2_num").disabled = true;
        document.getElementById("place_2").disabled = true;
        document.getElementById("bike_number_1_2").disabled = true;
        document.getElementById("bike_number_2_2").disabled = true;
        document.getElementById("bike_number_3_2").disabled = true;

      } else if (type == '{{ DOUBLE_ON }}') {
        document.getElementById("race_no_2_title").readOnly = false;
        document.getElementById("race_no_2_num").disabled = false;
        document.getElementById("place_2").disabled = false;
        document.getElementById("bike_number_1_2").disabled = false;
        document.getElementById("bike_number_2_2").disabled = false;
        document.getElementById("bike_number_3_2").disabled = false;
      }
    }
  </script>
@endsection