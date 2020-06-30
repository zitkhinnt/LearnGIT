<form action="{{ route('admin.update.query.search.user') }}" method="POST">
  @csrf
  <input type="hidden" name="id_query_search" id="id_query_search" value="">
  <div class="modal fade" id="querySearchUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <!-- condition name -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.name_query") }}</label>
              <input class="form-control name_query" type="text" name="name_query" value="">
            </div>
          </div>
          <div class="row">
            <!-- login id -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.login_id") }}</label>
              <input class="form-control login_id" type="text" name="login_id" value="">
            </div>
            <!-- user key -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.user_key") }}</label>
              <input class="form-control user_key" name="user_key" type="text" value="">
            </div>
            <!-- point min -->
            <div class="col-md-3 mb-3 ">
              <label>{{ __("horserace::be_form.point_min") }}</label>
              <input class="form-control point_min" type="number" name="point_min" value="">
            </div>
            <!-- point max-->
            <div class="col-md-3 mb-3 ">
              <label>{{ __("horserace::be_form.point_max") }}</label>
              <input class="form-control point_max" type="number" name="point_max" value="">
            </div>
          </div>
          <div class="row">
            <!-- nick  name -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.nickname") }}</label>
              <input class="form-control nickname" type="text" name="nickname" value="">
            </div>

            <!-- member level -->
            <div class="col-md-3 mb-3">
              <label class="form-control-label">
                {{ __("horserace::be_form.member_level") }}
              </label>
              <select class="selectpicker show-tick form-control" name="member_level">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ MEMBER_LEVEL_TRIAL }}"
                  {{ !is_null(old("member_level")) && old("member_level") == MEMBER_LEVEL_TRIAL ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_trail") }}
                </option>
                <option value="{{ MEMBER_LEVEL_EXCEPT }}"
                  {{ old("member_level") == MEMBER_LEVEL_EXCEPT ? "selected" : "" }}>
                  {{ __("horserace::be_form.member_level_except") }}
                </option>
              </select>
            </div>
    
            <!-- member level -->
            <!-- <div class="col-md-3 mb-3">
              <label class="form-control-label">
                {{ __("horserace::be_form.member_level") }}
              </label>
              <select class="show-tick form-control member_level" name="member_level" disabled>
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ MEMBER_LEVEL_TRIAL }}">
                  {{ __("horserace::be_form.member_level_trail") }}
                </option>
                <option value="{{ MEMBER_LEVEL_GOLD }}">
                  {{ __("horserace::be_form.member_level_gold") }}
                </option>
                <option value="{{ MEMBER_LEVEL_DIAMOND }}">
                  {{ __("horserace::be_form.member_level_diamond") }}
                </option>
                <option value="{{ MEMBER_LEVEL_CRYSTAL }}">
                  {{ __("horserace::be_form.member_level_crystal") }}
                </option>
                <option value="{{ MEMBER_LEVEL_EXCEPT }}">
                  {{ __("horserace::be_form.member_level_except") }}
                </option>
              </select>
            </div> -->

            <!--deposit_total_amount min -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_amount_min") }}</label>
              <input class="form-control deposit_total_amount_min" type="number" name="deposit_total_amount_min" value="">
            </div>
            <!--deposit_total_amount max-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_amount_max") }}</label>
              <input class="form-control deposit_total_amount_max" type="number" name="deposit_total_amount_max" value="">
            </div>
          </div>
          <div class="row">
            <!-- age-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.age") }}</label>
              <select class="show-tick form-control age" name="age">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ AGE_USER_20 }}">
                  {{ __("horserace::be_form.age_20") }}
                </option>
                <option value="{{ AGE_USER_30 }}">
                  {{ __("horserace::be_form.age_30") }}
                </option>
                <option value="{{ AGE_USER_40 }}">
                  {{ __("horserace::be_form.age_40") }}
                </option>
                <option value="{{ AGE_USER_50 }}">
                  {{ __("horserace::be_form.age_50") }}
                </option>
                <option value="{{ AGE_USER_60 }}">
                  {{ __("horserace::be_form.age_60") }}
                </option>
                <option value="{{ AGE_USER_70 }}" }>
                  {{ __("horserace::be_form.age_70") }}
                </option>
              </select>
            </div>
            <!-- gender-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.gender") }}</label>
              <div class="form-control">
                <label class="checkbox checkbox-grey checkbox-primary">
                  <input type="checkbox" name="gender[{{ MALE }}]" value="{{ MALE }}" class="gender-{{ MALE }}">
                  <span class="input-span"></span>{{ __("horserace::be_form.male") }}</label>
                <label class="checkbox checkbox-grey checkbox-primary">
                  <input type="checkbox" name="gender[{{ FEMALE }}]" value="{{ FEMALE }}" class="gender-{{ FEMALE }}">
                  <span class="input-span"></span>{{ __("horserace::be_form.female") }}</label>
              </div>
            </div>
            <!-- deposit_total_number min   -->
            <div class=" col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_number_min") }}</label>
              <input class="form-control deposit_total_number_min" type="number" name="deposit_total_number_min" value="">
            </div>
            <!-- deposit_total_number max -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.deposit_total_number_max") }}</label>
              <input class="form-control deposit_total_number_max" type="number" name="deposit_total_number_max" value="">
            </div>
          </div>

          <div class="row">
            <!-- mail pc-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.mail_pc") }}</label>
              <input class="form-control mail_pc" type="text" name="mail_pc" value="">
            </div>
            <!-- mail mobile-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.mail_mobile") }}</label>
              <input class="form-control mail_mobile" type="text" name="mail_mobile" value="">
            </div>
            <!-- login_number min -->
            <div class="col-md-3 mb-3">
              <label> {{ __("horserace::be_form.login_number_min") }}</label>
              <input class="form-control login_number_min" type="number" name="login_number_min" value="">
            </div>
            <!-- login_number max -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.login_number_max") }}</label>
              <input class="form-control login_number_max" type="number" name="login_number_max" value="">
            </div>
          </div>

          <div class="row">
            <!-- IP-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.ip") }}</label>
              <input class="form-control ip" type="text" name="ip" value="">
            </div>
            <!-- Prediction type -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.prediction_type") }}</label>
              <select class="show-tick form-control prediction_type" name="prediction_type">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["prediction_type"] as $item)
                  <option value="{{ $item->id }}"
                    {{ old("prediction_type") ==  $item->id ? "selected" : "" }} >
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- register_time start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.register_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control register_time_start" type="text" name="register_time_start" value="">
              </div>
            </div>
            <!-- register_time end -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.register_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control register_time_end" type="text" name="register_time_end" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Media -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.media_code") }}</label>
              <select class="show-tick form-control media_code" name="media_code">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["media"] as $item)
                  <option value="{{ $item->code }}">
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- entrance_id -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.entrance") }}</label>
              <select class="selectpicker show-tick form-control" name="entrance_id">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                @foreach($data["entrance"] as $item)
                  <option value="{{ $item->id }}"
                    {{  old("entrance_id") ==  $item->id ? "selected" : "" }}>
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- stop_mail -->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.stop_mail") }}</label>
              <select class="show-tick form-control stop_mail" name="stop_mail">
                <option value="{{ null }}">
                  {{ __("horserace::be_form.unset") }}
                </option>
                <option value="{{ STOP_MAIL_DISABLE }}">
                  {{ __("horserace::be_form.stop_mail_disable")  }}
                </option>
                <option value="{{ STOP_MAIL_ENABLE }}">
                  {{ __("horserace::be_form.stop_mail_enable")  }}
                </option>
              </select>
            </div>

            <!-- sns_register -->
            <div class="col-md-3 mb-3">
                <label>{{ __("horserace::be_form.sns_register") }}</label>
                <select class="selectpicker show-tick form-control" name="sns_register">
                  <option value="">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  <option value="{{ SNS_REGISTER_TYPE_ALL }}">
                    {{ __("horserace::be_form.sns_all")  }}
                  </option>
                  <option value="{{ SNS_REGISTER_TYPE_TWITTER }}">
                    {{ __("horserace::be_form.sns_twitter")  }}
                  </option>
                  <option value="{{ SNS_REGISTER_TYPE_YAHOO }}">
                    {{ __("horserace::be_form.sns_yahoo")  }}
                  </option>
                  <option value="{{ SNS_REGISTER_TYPE_FACEBOOK }}">
                    {{ __("horserace::be_form.sns_facebook")  }}
                  </option>
                  <option value="{{ SNS_REGISTER_TYPE_GOOGLE }}">
                    {{ __("horserace::be_form.sns_google")  }}
                  </option>
                </select>
            </div>

            <!-- search summernote -->
            <div class="col-md-6 mb-6">
                <label>
                  {{ __("horserace::be_form.summernote") }}
                </label>
                <label style="margin-left:20px"><input type="radio" name="option_summer" value="1"> 完全一致</label>
                <label style="margin-left:20px"><input type="radio" name="option_summer" value="0" checked> 部分一致</label>
                
                <input class="form-control" type="text" name="summernote" value="{{  old("summernote") }}">
            </div>

            <div class="col-md-6 mb-6">
              <label>
                {{ __("horserace::be_form.summernote_not") }}
              </label>
              <label style="margin-left:20px"><input type="radio" name="option_summer_not" value="1"> 完全一致</label>
              <label style="margin-left:20px"><input type="radio" name="option_summer_not" value="0" checked> 部分一致</label>
              <input class="form-control" type="text" name="summernote_not" value="{{  old("summernote_not") }}">
            </div>

          </div>

          <div class="row" style="margin-top:15px">
            <!-- first_deposit_time_start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_deposit_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control first_deposit_time_start" type="text" name="first_deposit_time_start" value="">
              </div>
            </div>

            <!-- first_deposit_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_deposit_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control first_deposit_time_end" type="text" name="first_deposit_time_end" value="">
              </div>
            </div>

            <!-- last_deposit_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_deposit_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control last_deposit_time_start" type="text" name="last_deposit_time_start" value="">
              </div>
            </div>
            <!-- last_deposit_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_deposit_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control last_deposit_time_end" type="text" name="last_deposit_time_end" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- first_payment_time_start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_payment_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control first_payment_time_start" type="text" name="first_payment_time_start" value="">
              </div>
            </div>

            <!-- first_payment_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.first_payment_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control first_payment_time_end" type="text" name="first_payment_time_end" value="">
              </div>
            </div>

            <!-- last_payment_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_payment_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control last_payment_time_start" type="text" name="last_payment_time_start" value="">
              </div>
            </div>
            <!-- last_payment_time-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_payment_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control last_payment_time_end" type="text" name="last_payment_time_end" value="">
              </div>
            </div>
          </div>


          <div class="row">
            <!-- last_login_time start-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_login_time_start") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control last_login_time_start" type="text" name="last_login_time_start" value="">
              </div>
            </div>
            <!-- last_login_time end-->
            <div class="col-md-3 mb-3">
              <label>{{ __("horserace::be_form.last_login_time_end") }}</label>
              <div class="input-group date" data-provide="datepicker">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control last_login_time_end" type="text" name="last_login_time_end" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- User stage -->
            <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
            <select class="selectpicker show-tick form-control ml-3 mb-3 col-md-2" name="search_match_type" id="search_match_type">
              <option value="{{ USER_STAGE_MATCH_ALL }}">
                {{ __("horserace::be_form.search_match_all") }}
              </option>
              <option value="{{ USER_STAGE_MATCH_PORTION }}" selected>
                {{ __("horserace::be_form.search_match_portion") }}
              </option>
            </select>
            <div class="col-md-12 mb-3 row">
              @foreach($data["user_stage"] as $item)
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="checkbox checkbox-primary">
                      <input class="user_stage" name="user_stage_id[{{ $item->id }}]" type="radio"
                            value="{{ $item->id }}-1">
                      <span class="input-span"></span>
                    </label>

                    <label class="checkbox checkbox-exclude checkbox-primary-exclude">
                      <input class="user_stage" name="user_stage_id[{{ $item->id }}]" type="radio"
                            value="{{ $item->id }}-0">
                      <span class="input-span"></span>
                    </label>
                    {{ $item->name }}
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="submit" class="btn btn-warning" value="{{ __("horserace::be_form.btn_save") }}">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            {{ __("horserace::be_form.close") }}
          </button>
        </div>
      </div>
    </div>
  </div>
</form>