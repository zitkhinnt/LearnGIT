@extends('horserace::backend.layouts.design')

<style>
  #divcheckAllUserStage
  {
    background-color: turquoise !important;
    font-weight: bold !important;
    color: black !important;
  }
#checkbox-dropdown-container {
	background: #99d3de;
	padding: 20px;
}
.custom-select {
    display: inline-block;
    padding: 5px 15px;
    border: #80b2bb 1px solid;
    color: #3892a2;
    border-radius: 2px;
    width: 100%;
    cursor:pointer;
    
}
div#custom-select-option-box {
    background: #FFF;
    border: #80b2bb 1px solid;
    color: #3892a2;
    border-radius: 2px;
    width: 100%;
    z-index:1000;
    display:none;
    position: absolute !important;
}

.custom-select-option {
    width: 100%;
    padding: 5px 15px;
    margin: 1px 0px;
    cursor: pointer;
    color: #717171 !important;
}
.panel-body
{
  white-space: pre-line;
}
.panel-heading
{
  display: none;
}
.content-email{
  white-space: pre-line; 
  padding-top: 10px;
}

</style>
@section('title', __("horserace::be_sidebar.mail_contact"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.mail_contact"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.mail_contact") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="flexbox-b mb-5">
    <span class="mr-4 static-badge badge-pink"><i class="la la-envelope"></i></span>
    <div>
      <h5 class="font-strong">
        {{ MAIL_FROM_NAME }}
      </h5>
      <div class="text-light">
        {{ MAIL_FROM_ADDRESS }}
      </div>
    </div>
  </div>
  <!-- Message success -->
  @if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!}">
      {!! Session::get('flash_message') !!}
    </div>
  @endif

<!-- Form Search  -->
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_form.mail_search") }}
      </div>
      <div class="">
      </div>
    </div>
    <div class="ibox-body">
      <!-- Form Add blog-->
      <form id="frmSearchMailContact" action="{{ route('admin.mail_contact') }}" method="GET" enctype="multipart/form-data">    
        <div class="row">
          <!-- key word -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.keyword") }}</label>
                <input class="form-control form-control"
                       type="text" name="keyword"
                       value="{{ isset($data["search"]["keyword"]) ? $data["search"]["keyword"] : "" }}"
                       placeholder="{{ __("horserace::be_form.keyword") }}">
              </div>
            </div>
          </div>
          <!-- date start -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.reception_datetime_start") }}</label>
                <div class="input-group date" data-provide="datepicker">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input class="form-control" type="text" name="start_date"
                         value="{{ isset($data["search"]["start_date"]) ? $data["search"]["start_date"] : "" }}">
                </div>
              </div>
            </div>
          </div>
          <!-- date end -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.reception_datetime_end") }}</label>
                <div class="input-group date" data-provide="datepicker">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input class="form-control" type="text" name="start_end"
                         value="{{ isset($data["search"]["start_end"]) ? $data["search"]["start_end"] : "" }}">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- login id -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.login_id") }}</label>
                <input class="form-control form-control "
                       type="text" name="login_id"
                       value="{{ isset($data["search"]["login_id"]) ? $data["search"]["login_id"] : "" }}"
                       placeholder="{{ __("horserace::be_form.login_id") }}">
              </div>
            </div>
          </div>
          <!-- mail pc -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.mail_pc") }}</label>
                <input class="form-control form-control"
                       type="text" name="mail_pc"
                       value="{{ isset($data["search"]["mail_pc"]) ? $data["search"]["mail_pc"] : "" }}"
                       placeholder="{{ __("horserace::be_form.mail_pc") }}">
              </div>
            </div>
          </div>
          <!-- read unread -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.read_unread") }}</label>
                <select class="selectpicker show-tick form-control"
                        name="read_unread">
                  <option value="0">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  <option value="{{ UNREAD }}"
                    {{ isset($data["search"]["read_unread"]) &&
                      $data["search"]["read_unread"] == UNREAD ? "selected" : "" }}>
                    {{ __("horserace::be_form.unread") }}
                  </option>
                  <option value="{{ READ }}"
                    {{ isset($data["search"]["read_unread"]) &&
                    $data["search"]["read_unread"] == READ ? "selected" : "" }}>
                    {{ __("horserace::be_form.read") }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- member level  -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.member_level") }}</label>
                <select class="selectpicker show-tick form-control" name="member_level">
                  <option value="{{ null }}">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  <option value="{{ MEMBER_LEVEL_TRIAL }}"
                    {{ isset($data["search"]["member_level"]) && $data["search"]["member_level"] == MEMBER_LEVEL_TRIAL ? "selected" : "" }}>
                    {{ __("horserace::be_form.member_level_trail") }}
                  </option>
                  <option style="display:none;" value="{{ MEMBER_LEVEL_GOLD }}"
                    {{ isset($data["search"]["member_level"]) && $data["search"]["member_level"] == MEMBER_LEVEL_GOLD ? "selected" : "" }}>
                    {{ __("horserace::be_form.member_level_gold") }}
                  </option>
                  <option style="display:none;" value="{{ MEMBER_LEVEL_DIAMOND }}"
                    {{ isset($data["search"]["member_level"]) && $data["search"]["member_level"] == MEMBER_LEVEL_DIAMOND ? "selected" : "" }}>
                    {{ __("horserace::be_form.member_level_diamond") }}
                  </option>
                  <option style="display:none;" value="{{ MEMBER_LEVEL_CRYSTAL }}"
                    {{ isset($data["search"]["member_level"]) && $data["search"]["member_level"] == MEMBER_LEVEL_CRYSTAL ? "selected" : "" }}>
                    {{ __("horserace::be_form.member_level_crystal") }}
                  </option>
                  <option value="{{ MEMBER_LEVEL_EXCEPT }}"
                    {{ isset($data["search"]["member_level"]) && $data["search"]["member_level"] == MEMBER_LEVEL_EXCEPT ? "selected" : "" }}>
                    {{ __("horserace::be_form.member_level_except") }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- user stage -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.user_stage") }}</label>        
                
                <div  class="custom-select" id="select_user_stage" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{isset($data["search"]["user_stage"])?"": __("horserace::be_form.unset")}}</div>
                  <div id="custom-select-option-box">
                  <input class="list_user_stage" type="hidden" name="user_stage" value="">                    

                    <div class="custom-select-option" id="divcheckAllUserStage">
                        <input onchange="toggleFillColor(this);"
                        class="user_stage_checkbox" type="checkbox" id="checkAllUserStage" 
                        value="0" {{isset($data["search"]["user_stage"]) && explode(",",$data["search"]["user_stage"])[0]==0?"checked":""}}>{{ __("horserace::be_form.btn_check_on")}}
                    </div>
                    @php
                    if(isset($data["search"]["user_stage"]))
                      $list_searh_user_stage =  explode(",",$data["search"]["user_stage"]);                     
                    @endphp                  
                   
                    @foreach($data["user_stage"] as $item)
                      <div class="custom-select-option">
                        <input onchange="toggleFillColor(this);"
                          class="user_stage_checkbox" type="checkbox"    
                          value={{ $item->id }}  {{ isset($data["search"]["user_stage"]) && in_array($item->id, $list_searh_user_stage ) ? "checked" : "" }}>
                      {{ $item->name }}
                      </div>      
                    @endforeach                   
                  </div>
                </div>
            </div>
          </div>

          <!-- media code -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.media_code") }}</label>
                <select class="selectpicker show-tick form-control" name="media_code">
                  <option value="">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  @foreach($data["media"] as $item)
                    <option value={{ $item->code }}
                      {{ isset($data["search"]["media_code"]) && $data["search"]["media_code"] == $item->code ? "selected" : "" }}>
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <!-- payment -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.payment") }}</label>
                <select class="selectpicker show-tick form-control" name="payment">
                  <option value="">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  <option value="deposit"
                    {{ isset($data["search"]["payment"]) && $data["search"]["payment"] == "deposit" ? "selected" : "" }}>
                    {{ __("horserace::be_form.deposit") }}
                  </option>
                  <option value="payment"
                    {{ isset($data["search"]["payment"]) && $data["search"]["payment"] == "payment" ? "selected" : "" }}>
                    {{ __("horserace::be_form.payment") }}
                  </option>

                </select>
              </div>
            </div>
          </div>
          <!-- order -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.order") }}</label>
                <select class="selectpicker show-tick form-control" name="order">
                  <option value="">
                    {{ __("horserace::be_form.unset") }}
                  </option>
                  <option value="created_at_asc"
                    {{ isset($data["search"]["order"]) && $data["search"]["order"] == "created_at_asc" ? "selected" : "" }}>
                    {{ __("horserace::be_form.reception_datetime") . ':' . __("horserace::be_form.asc") }}
                  </option>
                  <option value="created_at_desc"
                    {{ isset($data["search"]["order"]) && $data["search"]["order"] == "created_at_desc" ? "selected" : "" }}>
                    {{ __("horserace::be_form.reception_datetime") . ':' . __("horserace::be_form.desc")  }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <!-- date start -->
          <div class="col-lg-4">
            <div class="row">
              <div class="col-sm-12 form-group m-4 p-0 ">
                <button class="btn btn-primary mr-2 mt-2" style="width:100px;" type="submit">
                  {{ __("horserace::be_form.btn_search") }}
                </button>
              </div>
            </div>
          </div>

        </div>
      </form>
      <!--End Form -->
    </div>
  </div>

  <!-- Mail Teamplate -->
  <div class="page-content fade-in-up col-md-8">
    <div class="ibox">
      <form id="frmSendListMail" action="{{ route("admin.mail_contact.sendlist") }}" method="POST">
        {{ csrf_field() }}     

        <div class="ibox-body">
          <!-- Mail template -->
          <div class="row form-inline">
            <div class="col-md-3">
              <label>{{ __("horserace::be_form.mail_template") }}</label>
            </div>
            <div class="col-md-7">
              <select id="selectTemplateSendMorse" class="selectpicker show-tick form-control mail_template" name="mail_template">
                <option value="">{{ __("horserace::be_form.unset") }}</option>
                @foreach($data["mail_template"] as $item)
                  <option value="{{ $item->id }}">
                    {{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>       
          </div>
          <hr>
          <!-- -->

          <div class="row">            
            <div class="col-md-12 mb-4">
              <input class="form-control mail_title {{ $errors->has('mail_title') ? ' is-invalid' : '' }}"
                     type="text" name="mail_title"
                     value="{{ old('mail_title') }}" placeholder={{__("horserace::be_form.mail_title")}}>
              @if ($errors->has('mail_title'))
                <span class="invalid-feedback" style="color: red; display: block">
                    <strong>{{ $errors->first('mail_title') }}</strong>
                  </span>
              @endif
            </div>
          </div>         

          <div class="row">
            <!-- Mail body -->
            <div class="col-md-12 mb-4">
              <!-- <textarea id="summernote" data-plugin="summernote" data-air-mode="true" class="summernote mail_body"
                        name="mail_body">{{ old('mail_body') }}</textarea> -->
               <!-- {{-- <textarea id="summernote_plain_template"  class="mail_body"
                name="mail_body" style="width:100%; min-height:200px" >{{ old('mail_body') }}</textarea>--}} -->
                <textarea class="form-control mail_body" rows="15" data-air-mode="true"
                      name="mail_body">{{ old('mail_body') }}</textarea>
                      {{-- <textarea id="summernote_plain_template"  class="form-control mail_body"
                name="mail_body" style="width:100%; min-height:200px" >{{ old('mail_body') }}</textarea>--}}
                <button class="btn btn-dark mt-3" type="button" data-toggle="modal" data-target="#mail-replace">
                  {{ __("horserace::be_form.btn_mail_replace") }}
                </button>            
            </div>
          </div>
         
          <input class="list_user_id" type="hidden" name="list_user_id" value="">
          <input class="list_mail_to_name" type="hidden" name="list_mail_to_name" value="">
          <input class="list_mail_to_address" type="hidden" name="list_mail_to_address" value="">
          <div class="form-group text-right">
              <button class="btn btn-info">
                {{ __("horserace::be_form.btn_send") }}
              </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- END MAIL TEMPLATE -->

  <!-- Update -->
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title d-flex">
        <button class="ml-3 btn btn-secondary btn_check_on" onclick="check_on();">
          {{ __("horserace::be_form.btn_check_on")}}
        </button>
        <button class="ml-3 btn btn-secondary btn_check_off" onclick="check_off();">
          {{ __("horserace::be_form.btn_check_off")}}
        </button>
        <!-- Read all -->
        <form id="form_read_all" action="{{ route("admin.mail_contact.admin_read_all") }}" method="POST">
          {{ csrf_field() }}
          <input class="list_user_id" type="hidden" name="list_user_id" value="">
          <button class="ml-3 btn btn-warning mail_contact_read_all" type="button">
            {{ __("horserace::be_form.btn_mail_contact_read_all")}}
          </button>
        </form>

        <!-- Deleted mail contact user -->
        <form id="form_deleted_all" action="{{ route("admin.mail_contact.admin_deleted_all") }}" method="POST">
          {{ csrf_field() }}
          <input class="list_user_id" type="hidden" name="list_user_id" value="">
          <button class="ml-3 btn btn-danger mail_contact_deleted_all" type="button">
            {{ __("horserace::be_form.btn_mail_contact_deleted_all")}}
          </button>
        </form>
      </div>
      <div class="">
      </div>
    </div>
  </div>
  <!-- Show form info mail contact  -->
  @if(isset($arr_mail_contact) )
    @foreach($arr_mail_contact as $key => $item )
      @if(is_numeric($key))      
        <div class="ibox {{ $arr_mail_contact[$key]['user_info']->admin_not_read > 0 ? "bg-peach" : "" }}">
          <div class="ibox-head">
            <div class="ibox-title">
              <label class="checkbox">
                <input type="checkbox" class="user_id_checkbox"
                       name="user_id_[{{ $arr_mail_contact[$key]['user_info']->id }}]"
                       value="{{ $arr_mail_contact[$key]['user_info']->id }}">
                <span class="input-span"></span>
                @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
                {{ replaceStringEmail($arr_mail_contact[$key]['user_info']->login_id) }}
                @else
                {{ $arr_mail_contact[$key]['user_info']->login_id }}
                @endif
              </label>
            </div>
            <div class="">
            </div>
          </div>
          <div class="ibox-body">
            <!-- User infor -->
            <div class="row">
              <!-- login id -->
              <div class="col-md-12 form-group d-flex">
                <label>{{ __("horserace::be_form.login_id") . ": " }}
                  <a href="{{ route('admin.user.edit', $arr_mail_contact[$key]['user_info']->id ) }}">
                    <strong class="text-blue">
                      {{ $arr_mail_contact[$key]['user_info']->login_id }}
                    </strong>
                  </a>
                </label>

                <label class="ml-3">{{ __("horserace::be_form.name")  . ": " }}
                  <strong>
                    {{ $arr_mail_contact[$key]['user_info']->nickname }}
                  </strong>
                </label>

                <label class="ml-3">{{ __("horserace::be_form.media_code")  . ": " }}
                  <strong>
                    {{ $arr_mail_contact[$key]['user_info']->media_code }}
                  </strong>
                </label>

                <label class="ml-3">{{ __("horserace::be_form.total_mail") . ': ' }}
                  <strong>
                    {{ $item['user_info']->total_mail . ' (' .
                    __("horserace::be_form.send") . ': ' . $arr_mail_contact[$key]['user_info']->admin_send . ' | ' .
                     __("horserace::be_form.receive") . ': ' . $arr_mail_contact[$key]['user_info']->user_send . ' )'}}
                  </strong>
                </label>
                <!-- Deleted mail contact user -->
                <form action="{{ route("admin.mail_contact.admin_deleted") }}" method="POST">
                  {{ csrf_field() }}
                  <input class="user_id" type="hidden" name="user_id"
                         value="{{ $arr_mail_contact[$key]['user_info']->id }}">
                  <input class="mail_pc" type="hidden" name="mail_pc"
                         value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}">
                  <button class="ml-3 btn btn-danger">
                    {{ __("horserace::be_form.btn_mail_contact")}}
                  </button>
                </form>

                <!-- Mail ban -->
                <form action="{{ route("admin.mail_contact.mail_ban") }}" method="POST">
                  {{ csrf_field() }}
                  <input class="mail_pc" type="hidden" name="mail_pc"
                         value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}">
                  <button class="ml-3 btn btn-danger">
                    {{ __("horserace::be_form.btn_mail_ban")}}
                  </button>
                </form>

              </div>
            </div>

            <div class="row">
              <!-- User stage -->
              <div class="col-sm-12 form-group">
                <label>{{ __("horserace::be_form.user_stage") . ': ' }}
                  <strong>
                    {{ $arr_mail_contact[$key]['user_info']->user_stage_str }}
                  </strong>
                </label>
              </div>
              <!-- Read mail contact user -->
              <form action="{{ route("admin.mail_contact.admin_read") }}" method="GET">
                <input class="user_id" type="hidden" name="user_id"
                       value="{{ $arr_mail_contact[$key]['user_info']->id }}">
                <input class="mail_pc" type="hidden" name="mail_pc"
                       value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}">
                <button class="ml-3 btn btn-warning">
                  {{ __("horserace::be_form.btn_read")}}
                </button>
              </form>

            </div>

            <!-- Mail contact-->
            <div class="row mt-4 border p-2">
              <!-- info mail box -->
              <div class="col-md-6 anyClass mail-detail">
                <!-- Show Content Mail -->
                <?php $user_info_mail_pc=$item['user_info']->mail_pc; ?>
                  @foreach ( $item as $index => $mail)
                  @if($index !== "user_info")
                  <div class="mail-detail-item" style="display:none;">
                  @if($user_info_mail_pc!= $mail->mail_from_address)
                    <div class="d-flex collapsible" style="background-color: {{isset($mail->sys_send) ? '#C5C5C5' : '#ffb6c1 '}};padding: 10px;">
                  @else
                    <div class="d-flex collapsible" style="background-color:#F8B446; padding: 10px;">
                  @endif
                          <div class="flex-1 d-flex">
                            <div class="flex-1">
                              <div class="font-strong font-16 title">
                                <p>
                                  @if($mail->status == 0)
                                    <span class="text-danger">
                                    {{ __("horserace::be_form.user_sent") }}
                                  </span>
                                    -
                                  @else
                                    <span class="text-blue">
                                    {{ __("horserace::be_form.admin_sent") }}
                                  </span>
                                    -
                                  @endif
                                  {{ $mail->created_at }} -
                                  @if(is_null($mail->admin_read_at))
                                    <span class="text-danger">
                                    {{ __("horserace::be_form.unread") }}
                                  </span>
                                  @else
                                    <span class="text-blue">
                                    {{ __("horserace::be_form.read") }}
                                  </span>
                                  @endif
                                </p>
                                {{ $mail->mail_title }}
                              </div>
                              <div>
                                <span class="nick-name-user">{{  $mail->mail_from_name }}</span>
                                <span class="text-muted ml-2 mail-to-address">{{  $mail->mail_from_address }}</span>
                              </div>
                              {{--<div class="text-muted font-13 read-send">{{ $index}}</div>--}}
                            </div>
                          </div>
                        </div>
                        
                      @if($user_info_mail_pc!= $mail->mail_from_address)
                      <div class="content content-email" style="{{isset($mail->sys_send) ? 'display: none;' : 'display: block;'}}"> {!! ($mail->mail_body)!!}  </div>
                      @else
                      <div class="content content-email" style="display: block;"> {!! ($mail->mail_body)!!}  </div>
                      @endif
                        <hr>
                    </div>
                    @endif
                  @endforeach
                  <div style="text-align: center;"><button class="loadMore"  style="width: 100px;">続きを開く</button></div>

              <!-- Show Content Mail -->
              </div>
              <!-- send mail  -->
              <div class="col-md-6">
                <form id="frmAdminSendMailContact" action="{{ route("admin.mail_contact.send") }}" method="POST">
                  {{ csrf_field() }}
                  <div class="flexbox mb-4">
                  <span class="btn-icon-only btn-circle bg-primary-50 text-primary mr-3"><i
                      class="ti-support"></i></span>
                    <div class="flex-1 d-flex">
                      <div class="flex-1">
                        <span class="text-muted mr-2">{{ __("horserace::be_form.mail_from_address") }}:</span>
                        <div>{{ MAIL_FROM_ADDRESS }}</div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-4">
                    <div class="row">
                      <div class="col-md-4">
                        <label>{{ __("horserace::be_form.mail_template") }}</label>
                      </div>
                      <div class="col-md-6">
                        <select
                          class="show-tick form-control mail-template-{{ $arr_mail_contact[$key]['user_info']->id }}"
                          onchange="getNewVal(this, '{{ $arr_mail_contact[$key]['user_info']->id }}');"
                          name="mail_template">
                          <option value="0"
                                  data-mail-title=""
                                  data-mail-body="">
                            {{ __("horserace::be_form.unset") }}
                          </option>
                          @foreach($data["mail_template"] as $item)
                            <option value="{{ $item->id }}"
                                    data-mail-title="{{ $item->mail_title }}"
                                    data-mail-body="{{ $item->mail_body }}">
                              {{ $item->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-4">
                    <input class="user_id" type="hidden" name="user_id"
                           value="{{ $arr_mail_contact[$key]['user_info']->id }}">
                    <input class="{{'mail_to_name_'.$arr_mail_contact[$key]['user_info']->id}}" type="hidden" name="mail_to_name"
                           value="{{ $arr_mail_contact[$key]['user_info']->nickname }}">
                    @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
                    <input class="{{'mail_to_address_'.$arr_mail_contact[$key]['user_info']->id.' form-control form-control-line'}}" type="email"
                            value="{{ replaceStringEmail($arr_mail_contact[$key]['user_info']->mail_pc) }}" required>
                    <input class="{{'mail_to_address_'.$arr_mail_contact[$key]['user_info']->id.' form-control form-control-line'}}" style="display:none;" type="email"
                           name="mail_to_address" value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}"  required>
                    @else
                    <input class="{{'mail_to_address_'.$arr_mail_contact[$key]['user_info']->id.' form-control form-control-line'}}" type="email"
                           name="mail_to_address" value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}"  required>
                    @endif
                  </div>
                  <div class="form-group mb-4">
                    <input
                      class="form-control form-control-line mail-title-{{ $arr_mail_contact[$key]['user_info']->id }}"
                      type="text" name="mail_title" id="mail-title-{{ $arr_mail_contact[$key]['user_info']->id }}"
                      placeholder="{{ __("horserace::be_form.mail_title") }}">
                  </div>
                  <div class="form-group mb-4" style="white-space: pre-line;">
                  <!-- <textarea class="summernote mail-body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                            id="mail_body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                            data-plugin="summernote" data-air-mode="true"
                            name="mail_body" required></textarea>
                      {{--<textarea class="mail-body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                        id="mail_body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                        name="mail_body" required style="width:100%; min-height:150px;"></textarea>--}} -->
                    <textarea class="form-control mail-body-{{ $arr_mail_contact[$key]['user_info']->id }}" rows="15"
                        id="mail_body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                          data-air-mode="true"
                        name="mail_body" required></textarea>
                  {{--<textarea class="mail-body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                    id="mail_body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                    name="mail_body" required style="width:100%; min-height:150px;"></textarea>--}}
                  </div>
                  <div class="form-group text-right">
                    <button class="btn btn-info">
                      {{ __("horserace::be_form.btn_send") }}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="ibox {{ $arr_mail_contact[$key]['user_info']->admin_not_read > 0 ? "bg-peach" : "" }}">
          <div class="ibox-head">
            <div class="ibox-title">
              <label class="checkbox">
                <input type="checkbox" class="user_id_checkbox"
                       name="user_id_[{{ $key }}]"
                       value="{{ $key }}">
                <span class="input-span"></span>
                @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
                  {{ replaceStringEmail($key) }}
                @else
                  {{ $key }}
                @endif
              </label>
            </div>
            <div class="">
            </div>
          </div>
          <div class="ibox-body">
            <!-- User infor -->
            <div class="row">
              <!-- login id -->
              <div class="col-md-12 form-group d-flex">
                <label class="ml-3">{{ __("horserace::be_form.name")  . ": " }}
                  <strong>
                    {{ $arr_mail_contact[$key]['user_info']->nickname }}
                  </strong>
                </label>

                <label class="ml-3">{{ __("horserace::be_form.total_mail") . ': ' }}
                  <strong>
                    {{ $item['user_info']->total_mail . ' (' .
                    __("horserace::be_form.send") . ': ' . $arr_mail_contact[$key]['user_info']->admin_send . ' | ' .
                     __("horserace::be_form.receive") . ': ' . $arr_mail_contact[$key]['user_info']->user_send . ' )'}}
                  </strong>
                </label>
                <!-- Deleted mail contact user -->
                <form action="{{ route("admin.mail_contact.admin_deleted") }}" method="POST">
                  {{ csrf_field() }}
                  <input class="user_id" type="hidden" name="user_id"
                         value="{{ $arr_mail_contact[$key]['user_info']->id }}">
                  <input class="mail_pc" type="hidden" name="mail_pc"
                         value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}">
                  <button class="ml-3 btn btn-danger">
                    {{ __("horserace::be_form.btn_mail_contact")}}
                  </button>
                </form>

                <!-- Mail ban -->
                <form action="{{ route("admin.mail_contact.mail_ban") }}" method="POST">
                  {{ csrf_field() }}
                  <input class="mail_pc" type="hidden" name="mail_pc"
                         value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}">
                  <button class="ml-3 btn btn-danger">
                    {{ __("horserace::be_form.btn_mail_ban")}}
                  </button>
                </form>
              </div>
            </div>

            <div class="row">
              <!-- User stage -->
              <div class="col-sm-12 form-group">

              </div>
              <!-- Read mail contact user -->
              <form action="{{ route("admin.mail_contact.admin_read") }}" method="GET">
                <input class="user_id" type="hidden" name="user_id"
                       value="{{ $key }}">
                <input class="mail_pc" type="hidden" name="mail_pc"
                       value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}">
                <button class="ml-3 btn btn-warning">
                  {{ __("horserace::be_form.btn_read")}}
                </button>
              </form>

            </div>

            <!-- Mail contact-->
            <div class="row mt-4 border p-2">
              <!-- info mail box -->
              <div class="col-md-6 anyClass mail-detail">
                <!-- Show Content Mail -->
                <?php $user_info_mail_pc=$item['user_info']->mail_pc; ?>
                  @foreach ( $item as $index => $mail)
                  @if($index !== "user_info")
                  <div class="mail-detail-item" style="display:none;">
                  @if($user_info_mail_pc!= $mail->mail_from_address)
                    <div class="d-flex collapsible" style="background-color: {{isset($mail->sys_send) ? '#C5C5C5' : '#ffb6c1 '}};padding: 10px;">
                  @else
                    <div class="d-flex collapsible" style="background-color:#F8B446; padding: 10px;">
                  @endif
                          <div class="flex-1 d-flex">
                            <div class="flex-1">
                              <div class="font-strong font-16 title">
                                <p>
                                  @if($mail->status == 0)
                                    <span class="text-danger">
                                    {{ __("horserace::be_form.user_sent") }}
                                  </span>
                                    -
                                  @else
                                    <span class="text-blue">
                                    {{ __("horserace::be_form.admin_sent") }}
                                  </span>
                                    -
                                  @endif
                                  {{ $mail->created_at }} -
                                  @if(is_null($mail->admin_read_at))
                                    <span class="text-danger">
                                    {{ __("horserace::be_form.unread") }}
                                  </span>
                                  @else
                                    <span class="text-blue">
                                    {{ __("horserace::be_form.read") }}
                                  </span>
                                  @endif
                                </p>
                                {{ $mail->mail_title }}
                              </div>
                              <div>
                                <span class="nick-name-user">{{  $mail->mail_from_name }}</span>
                                <span class="text-muted ml-2 mail-to-address">{{  $mail->mail_from_address }}</span>
                              </div>
                              {{--<div class="text-muted font-13 read-send">{{ $index}}</div>--}}
                            </div>
                          </div>
                        </div>
                        
                      @if($user_info_mail_pc!= $mail->mail_from_address)
                      <div class="content content-email" style="{{isset($mail->sys_send) ? 'display: none;' : 'display: block;'}}"> {!! ($mail->mail_body)!!}  </div>
                      @else
                      <div class="content content-email" style="display: block;"> {!! ($mail->mail_body)!!}  </div>
                      @endif
                        <hr>
                    </div>
                    @endif
                  @endforeach
                  <div style="text-align: center;"><button class="loadMore"  style="width: 100px;">続きを開く</button></div>
              <!-- Show Content Mail -->
              </div>
              <!-- send mail  -->
              <div class="col-md-6">
                <form id="frmAdminSendMailContactGuest" action="{{ route("admin.mail_contact.send") }}" method="POST">
                  {{ csrf_field() }}
                  <div class="flexbox mb-4">
                  <span class="btn-icon-only btn-circle bg-primary-50 text-primary mr-3"><i
                      class="ti-support"></i></span>
                    <div class="flex-1 d-flex">
                      <div class="flex-1">
                        <span class="text-muted mr-2">{{ __("horserace::be_form.mail_from_address") }}:</span>
                        <div>{{ MAIL_FROM_ADDRESS }}</div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-4">
                    <div class="row">
                      <div class="col-md-4">
                        <label>{{ __("horserace::be_form.mail_template") }}</label>
                      </div>
                      <div class="col-md-6">
                        <select
                          class="show-tick form-control mail-template-{{ $arr_mail_contact[$key]['user_info']->id }}"
                          onchange="getNewVal(this, '{{ $arr_mail_contact[$key]['user_info']->id }}');"
                          name="mail_template">
                          <option value="0"
                                  data-mail-title=""
                                  data-mail-body="">
                            {{ __("horserace::be_form.unset") }}
                          </option>
                          @foreach($data["mail_template"] as $item)
                            <option value="{{ $item->id }}"
                                    data-mail-title="{{ $item->mail_title }}"
                                    data-mail-body="{{ $item->mail_body }}">
                              {{ $item->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-4">
                    <input class="user_id" type="hidden" name="user_id"
                           value="{{ $arr_mail_contact[$key]['user_info']->id }}">
                    <input class="{{'mail_to_name_'.$key}}" type="hidden" name="mail_to_name"
                           value="{{ $arr_mail_contact[$key]['user_info']->nickname }}">
                      @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
                      <input class="{{'mail_to_address_'.$arr_mail_contact[$key]['user_info']->id.' form-control form-control-line'}}" type="email"
                              value="{{ replaceStringEmail($arr_mail_contact[$key]['user_info']->mail_pc) }}" required>
                      <input class="{{'mail_to_address_'.$arr_mail_contact[$key]['user_info']->id.' form-control form-control-line'}}" style="display:none;" type="email"
                            name="mail_to_address" value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}"  required>
                      @else
                      <input class="{{'mail_to_address_'.$arr_mail_contact[$key]['user_info']->id.' form-control form-control-line'}}" type="email"
                            name="mail_to_address" value="{{ $arr_mail_contact[$key]['user_info']->mail_pc }}"  required>
                      @endif 
                  </div>
                  <div class="form-group mb-4">
                    <input
                      class="form-control form-control-line mail-title-{{ $arr_mail_contact[$key]['user_info']->id }}"
                      type="text" name="mail_title" id="mail-title-{{ $arr_mail_contact[$key]['user_info']->id }}"
                      placeholder="{{ __("horserace::be_form.mail_title") }}">
                  </div>
                  <div class="form-group mb-4" style="white-space: pre-line;">
                  <!-- <textarea class="summernote mail-body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                            id="mail_body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                            data-plugin="summernote" data-air-mode="true"
                            name="mail_body" required></textarea> -->
                      <textarea class="form-control mail-body-{{ $arr_mail_contact[$key]['user_info']->id }}"
                            id="mail_body-{{ $arr_mail_contact[$key]['user_info']->id }}" rows="15"
                             data-air-mode="true"
                            name="mail_body" required></textarea>
                  </div>
                  <div class="form-group text-right">
                    <button class="btn btn-info">
                      {{ __("horserace::be_form.btn_send") }}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    @endif
  @endforeach
@endif

<!-- Render Paginate -->
  <div class="mail_contact">
    {{--{{ $arr_mail_contact->render() }}--}}
    <?php $paginator = $array_obj_user; ?>
    @if ($array_obj_user!=null && $paginator->lastPage() > 1)
      <ul class="pagination" style="max-width: 100%; overflow: scroll;">
        @if($paginator->currentPage() == 1)
          <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
            <span class="page-link" aria-hidden="true">‹</span>
          </li>
        @else
          <?php $search["page"] = 1; ?>
          <li class="page-item">
            <a class="page-link" href="{{ route("admin.mail_contact", $search) }}" rel="prev"
               aria-label="« Previous">‹</a>
          </li>
        @endif

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
          <?php $search["page"] = $i; ?>
          <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ route("admin.mail_contact", $search) }}">{{ $i }}</a>
          </li>
        @endfor

        @if($paginator->currentPage() == $paginator->lastPage())
          <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
            <span class="page-link" aria-hidden="true">›</span>
          </li>
        @else
          <?php $search["page"] = $paginator->currentPage() + 1; ?>
          <li class="page-item">
            <a class="page-link" href="{{ route("admin.mail_contact", $search) }}" rel="next" aria-label="Next »">›</a>
          </li>
        @endif
      </ul>
    @endif
  </div>

  <!-- End Paginate -->
</div>
<!-- END PAGE CONTENT-->
 <!-- Popup-->
 @include('horserace::backend.popup.mail_replace')
@endsection
@section('javascript')
<script>
    $(document).ready(function () {
        let mail_contact_array = $(".mail-detail");
        mail_contact_array.each( (index, mail_contact) => {
          loadMore(mail_contact);
        })
        function loadMore(mail_contact) {
          $(mail_contact).find('.mail-detail-item:hidden').each( (index, item) => {
            if(index < 20){
              $(item).show();
            }
          });
        }
        $('.loadMore').click( function(){
          loadMore($(this).parents()[1]);
        })
        
    });
  </script>
  <!-- Choose mail template -->
  <script>
    // using text area
    $(function () {
      $('#summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
     
    });

    function getNewVal(item, user_id) {
      console.log(user_id);     
      var option_change = $(item).children('option');    
      var from = $(item).parents('form').get(0);  
      for (var i = 0; i < option_change.length; i++) {
        if (option_change[i].selected && option_change[i].value) {
          let mail_title = $(option_change[i]).data('mail-title');
          let mail_body = $(option_change[i]).data('mail-body');
          $(from).find('.mail-title-' + user_id).val(mail_title);
          $(from).find('.mail-body-'+user_id).val(mail_body);
          // $(from).find('.mail-body-'+user_id).summernote('code',mail_body);
          $(from).find('.mail-body-'+user_id).val(mail_body);           
        }
      }
    }
  </script>

 <!-- Get mail template-->
 <script>
    $(document).ready(function () {
      $(document).on('change', '#selectTemplateSendMorse', function () {
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


  <!-- Check all -->
  <script>

    // check all
    function check_on() {
      var check = document.getElementsByTagName('input');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    }

    // uncheck all
    function check_off() {
      var uncheck = document.getElementsByTagName('input');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    }

    /* $('.btn_check_on').click(function () {
      $('.user_id_checkbox').attr('checked', true)
    });

    $('.btn_check_off').click(function () {
      $('.user_id_checkbox').attr('checked', false)
    }); */

    // Read mail contact
    $('.mail_contact_read_all').click(function () {
      var checked = [];
      $(".user_id_checkbox:checked").each(function () {
        checked.push($(this).val());
      });
      $("#form_read_all .list_user_id").val(checked);
      $("#form_read_all").submit();
    })

    // Deleted mail contact
    $('.mail_contact_deleted_all').click(function () {
      var checked = [];
      $(".user_id_checkbox:checked").each(function () {
        checked.push($(this).val());
      });
      $("#form_deleted_all .list_user_id").val(checked);
      $("#form_deleted_all").submit();
      console.log("deleted");
    })


  </script>

<script>  
    $('#frmSearchMailContact').submit(function() 
    {
        var checked = [];
        $(".user_stage_checkbox:checked").each(function ()
        {         
          checked.push($(this).val()); 
        });     
        $("#frmSearchMailContact .list_user_stage").val(checked);
      
    });
  </script>

  <script>
    $('#frmSendListMail').submit(function() 
    {
      var checked = [];
      var list_mail_to_name =[];
      var list_mail_to_address=[];
      $(".user_id_checkbox:checked").each(function ()
      {
        checked.push($(this).val());

        var MailToName = document.getElementsByClassName("mail_to_name_"+$(this).val());
        list_mail_to_name.push($(MailToName).val());

        var MailToAddress = document.getElementsByClassName("mail_to_address_"+$(this).val());
        list_mail_to_address.push($(MailToAddress).val());
           
      });
      $("#frmSendListMail .list_user_id").val(checked);     
      $("#frmSendListMail .list_mail_to_name").val(list_mail_to_name); 
      $("#frmSendListMail .list_mail_to_address").val(list_mail_to_address);  

      var template_plaint_text = $("#frmSendListMail .summernote").val();
        var index_begin =  template_plaint_text.indexOf("<style");
        var index_end = template_plaint_text.indexOf("</style>");   
        template_plaint_text =  template_plaint_text.replace(template_plaint_text.substring(index_begin, index_end), "");
        template_plaint_text = template_plaint_text.replace(/<\/p>/gi, "\n")
                .replace(/<br\/?>/gi, "\n")
                .replace(/<\/?[^>]+(>|$)/gi, "");
        $("#frmSendListMail .summernote").val(template_plaint_text);

      if(checked.length==0)
      {
        return false; 
      }
      
     
    });
  </script>

  <script>    

    $('#frmAdminSendMailContact').submit(function() 
    {
      var template_plaint_text = $("#frmAdminSendMailContact .summernote").val();
      var index_begin =  template_plaint_text.indexOf("<style");
      var index_end = template_plaint_text.indexOf("</style>");   
      template_plaint_text =  template_plaint_text.replace(template_plaint_text.substring(index_begin, index_end), "");
      template_plaint_text = template_plaint_text.replace(/<\/p>/gi, "\n")
              .replace(/<br\/?>/gi, "\n")
              .replace(/<\/?[^>]+(>|$)/gi, "");
      $("#frmAdminSendMailContact .summernote").val(template_plaint_text);     
     
    });
  </script>
  <script>    
    $('#frmAdminSendMailContactGuest').submit(function() 
    {
      var template_plaint_text = $("#frmAdminSendMailContactGuest .summernote").val();
      var index_begin =  template_plaint_text.indexOf("<style");
      var index_end = template_plaint_text.indexOf("</style>");   
      template_plaint_text =  template_plaint_text.replace(template_plaint_text.substring(index_begin, index_end), "");
      template_plaint_text = template_plaint_text.replace(/<\/p>/gi, "\n")
              .replace(/<br\/?>/gi, "\n")
              .replace(/<\/?[^>]+(>|$)/gi, "");
      $("#frmAdminSendMailContactGuest .summernote").val(template_plaint_text);     
     
    });
  </script>

<script>
    $("#select_user_stage").on("click",function(){
      $("#custom-select-option-box").toggle();
    });
    function toggleFillColor(obj) {
      $("#custom-select-option-box").show();
      if($(obj).prop('checked') == true) {
        $(obj).parent().css("background",'#ebedee');
      } else {
        $(obj).parent().css("background",'#FFF');
      }
    }
    $(".custom-select-option").on("click", function() {
      var checkboxObj = $(this).children("input");
      $(checkboxObj).prop("checked",!($(checkboxObj).prop('checked')));
      if($(checkboxObj).attr('id') == "checkAllUserStage")
      {
        
        $(".user_stage_checkbox").each(function ()
        {
          $(this).prop("checked",$(checkboxObj).prop("checked"));           

        });

      }
      else
      {
        if($(checkboxObj).prop("checked")==false)
          $("#checkAllUserStage").prop("checked", false);        
      }
      $("#select_user_stage").html("");
      
      if($("#checkAllUserStage").prop("checked")== true) 
      {
        var user_stage_name = $("#divcheckAllUserStage").clone().children().remove().end().text();
          $("#select_user_stage").html(user_stage_name);
      }
      else
      {

        $(".user_stage_checkbox").each(function ()
        {
          if($(this).prop("checked") ==true)
          {
            var user_stage_name = $(this).parent().clone().children().remove().end().text();
            $("#select_user_stage").html($("#select_user_stage").html()+user_stage_name+", ");
          }
        });
      }

      toggleFillColor(checkboxObj);
    });
      
    $("body").on("click",function(e){
      if(e.target.id != "select_user_stage" && $(e.target).attr("class") != "custom-select-option") {
        $("#custom-select-option-box").hide();
      }
    });
    </script>

  <script>

    $( document ).ready(function()
    {
      $("#select_user_stage").html("");
      
      if($("#checkAllUserStage").prop("checked")== true) 
      {
        var user_stage_name = $("#divcheckAllUserStage").clone().children().remove().end().text();
          $("#select_user_stage").html(user_stage_name);
      }
      else
      {

        $(".user_stage_checkbox").each(function ()
        {
          if($(this).prop("checked") ==true)
          {
            var user_stage_name = $(this).parent().clone().children().remove().end().text();
            $("#select_user_stage").html($("#select_user_stage").html()+user_stage_name+", ");
          }
        });
      }
    });
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
     function MoreMailAjax(obj)
     {
       
       var user_id = $(obj).attr('id');
       var user_mail_pc = $(obj).attr('data-user-mail-pc');
       var page = parseInt($(obj).val());
       var urlParams = new URLSearchParams(window.location.search);
        $.ajax
        (
          {
              url: "{{  route('admin.mail_contact') }}" + "?"+urlParams+'&user_id=' + user_id +'&page='+page,
              type: "GET",
              dataType: "JSON",
              success: function (response)
              {
                /*$('.mail_from_address').val(response.mail_from_address);
                $('.mail_from_name').val(response.mail_from_name);
                $('.mail_title').val(response.mail_title);
                $('.mail_body').val(response.mail_body);
                $('#summernote').summernote('code', response.mail_body);*/
                var html='';
                for (i=0;i<response.length;i++)
                {
                  if(response[i]['mail_from_address'] !=user_mail_pc){
                    if(typeof  response[i]['sys_send']!== 'undefined' ){
                      html+= "<div class='d-flex collapsible' style='background-color: #C5C5C5; padding: 10px;'>";
                    }else{
                      html+= "<div class='d-flex collapsible' style='background-color: #ffb6c1; padding: 10px;'>";
                    }
                  }else{
                    html+= "<div class='d-flex collapsible' style='background-color:#F8B446; padding: 10px;'>";
                  }
                  
                  html+=   "<div class='flex-1 d-flex'>";
                  html+=     "<div class='flex-1'>";
                  html+=       "<div class='font-strong font-16 title'>";
                  html+=        "<p>";
                                if(response[i]['status'] == 0)
                                {
                  html+=                  "<span class='text-danger'>";
                  html+=                  "{{ __('horserace::be_form.user_sent') }}";
                  html+=                "</span>";
                  html+=                  "-";
                                }
                                  else
                                {
                  html+=                  "<span class='text-blue'>";
                  html+=                  "{{ __('horserace::be_form.admin_sent') }}";
                  html+=                "</span>";
                  html+=                  "-";
                                }
                  html+=                response[i]['created_at']+"-";
                                  if(response[i]['admin_read_at']==null)
                                  {
                  html+=                  "<span class='text-danger'>";
                  html+=                  "{{ __('horserace::be_form.unread') }}";
                  html+=                "</span>";
                                  }
                                  else
                                  {
                  html+=                 "<span class='text-blue'>";
                  html+=                  "{{ __('horserace::be_form.read') }}";
                  html+=                "</span>";
                                  }
                  html+=              "</p>";
                  html+=              response[i]['mail_title'];
                  html+=            "</div>";
                  html+=           "<div>";
                  html+=              "<span class='nick-name-user'>"+response[i]['mail_from_name']+"</span>";
                  html+=              "<span class='text-muted ml-2 mail-to-address'>"+response[i]['mail_from_address']+"</span>";
                  html+=           "</div>";
                  html+=          "</div>";
                  html+=        "</div>";
                  html+=      "</div>";
                  if(response[i]['mail_from_address'] !=user_mail_pc){
                    if(typeof  response[i]['sys_send']!== 'undefined' ){
                      html+=      "<div class='content content-email' style='display: none;'>" +response[i]['mail_body'] +"</div>";
                      html+=     "<hr>";
                    }else{
                      html+=      "<div class='content content-email' style='display: block;'>" +response[i]['mail_body'] +"</div>";
                      html+=     "<hr>";
                    }
                  }else{
                    html+=      "<div class='content content-email' style='display: block;'>" +response[i]['mail_body'] +"</div>";
                    html+=     "<hr>";
                  }
                }
                $("#mail_detail_"+user_id).html($("#mail_detail_"+user_id).html()+html );
                $(obj).val(parseInt($(obj).val())+1);
                
                var coll = document.getElementsByClassName("collapsible");
                var i;
                for (i = 0; i < coll.length; i++) {
                  coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                      content.style.display = "none";
                    } else {
                      content.style.display = "block";
                    }
                  });
                }
              }
          }
        );        
     }
  </script>
  <script>
    var coll = document.getElementsByClassName("collapsible");
    var i;
    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }
  </script>
@endsection
