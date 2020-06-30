@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.edit_user"))
<style>
 
  .panel-body
  {
    white-space: pre-line;
  }
</style>
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.edit_user"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.user.search') }}">
      {{ __("horserace::be_sidebar.search_user") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.edit_user") }}</li>
@endsection
<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <form id='frmAdminUserStore' action="{{ route('admin.user.store') }}" method="POST">
     @csrf
      <input type="hidden" name="id" value="{{ $data["user"]->user_id }}">
      <div class="ibox-head">
        <div class="ibox-title">
          {{ __("horserace::be_sidebar.edit_user") }}
        </div>
        <div class="ibox-title text-right">
          <a class="mb-0 ml-2 btn btn-success" target="_blank"
             href="{{ route('admin.mail_contact',["login_id" => $data["user"]->login_id, "read_unread" => 0]) }}">
            {{ __("horserace::be_form.btn_mail_user_detail") }}
          </a>
          <a class="mb-0 ml-2 btn btn-pink" target="_blank"
             href="{{ route('admin.user_login', $data["user"]->user_id) }}" >
            {{ __("horserace::be_form.btn_user_login") }}
          </a>
        </div>
      </div>
      <div class="ibox-body">
        <div class="row">
          <!-- login id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.login_id") }}</label>
            <input class="form-control" value="{{ $data["user"]->login_id }}"
                   type="text" name="login_id" readonly>
            @if ($errors->has('login_id'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('login_id') }}</strong>
              </span>
            @endif
          </div>
          <!-- user key -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.user_key") }}</label>
            <input class="form-control" value="{{ $data["user"]->user_key }}"
                   name="user_key" type="text" readonly>
          </div>
          <!-- mail pc-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.mail_pc") }}</label>
            @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
              <input class="form-control" type="email" value="{{ replaceStringEmail($data["user"]->mail_pc) }}" readonly>
              <input style="display:none;" class="form-control"   type="email" name="mail_pc" value="{{ $data["user"]->mail_pc }}" >
            @else
              <input class="form-control" type="email" name="mail_pc" value="{{ $data["user"]->mail_pc }}">
            @endif
            @if ($errors->has('mail_pc'))
              <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('mail_pc') }}</strong>
                </span>
            @endif
          </div>
          <!-- mail mobile-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.mail_mobile") }}</label>
            <input class="form-control" type="email" name="mail_mobile" value="{{ $data["user"]->mail_mobile }}">
            @if ($errors->has('mail_mobile'))
              <span class="invalid-feedback" style="color: red; display: block">
                  <strong>{{ $errors->first('mail_mobile') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="row">
          <!-- password-->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.password") }}</label>
            <input class="form-control" type="text" name="password"
                   value="{{ $data["user"]->password_text }}">
          </div>
          <!-- nick  name -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.nickname") }}</label>
            <input class="form-control" type="text" name="nickname" value="{{ $data["user"]->nickname }}">
            @if ($errors->has('nickname'))
              <span class="invalid-feedback" style="color: red; display: block">
                <strong>{{ $errors->first('nickname') }}</strong>
              </span>
            @endif
          </div>
          <!-- member level -->
          <div class="col-md-2 mb-3">
            <label class="form-control-label">
              {{ __("horserace::be_form.member_level") }}
            </label>
            <select class="selectpicker show-tick form-control" name="member_level">
               <option value="{{ MEMBER_LEVEL_TRIAL }}"
                {{ $data["user"]->member_level == MEMBER_LEVEL_TRIAL ? "selected" : "" }}>
                {{ __("horserace::be_form.member_level_trail") }}
              </option>

              <option value="{{ MEMBER_LEVEL_EXCEPT }}"
                {{ $data["user"]->member_level == MEMBER_LEVEL_EXCEPT ? "selected" : "" }}>
                {{ __("horserace::be_form.member_level_except") }}
              </option>
            </select>
          </div>

          <!-- age-->
          <div class="col-md-2 mb-3">
            <label>{{ __("horserace::be_form.age") }}</label>
            <select class="selectpicker show-tick form-control" name="age">
              <option value="{{ AGE_USER_20 }}"
                {{ $data["user"]->age == AGE_USER_20 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_20") }}
              </option>
              <option value="{{ AGE_USER_30 }}"
                {{  $data["user"]->age == AGE_USER_30 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_30") }}
              </option>
              <option value="{{ AGE_USER_40 }}"
                {{  $data["user"]->age == AGE_USER_40 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_40") }}
              </option>
              <option value="{{ AGE_USER_50 }}"
                {{  $data["user"]->age == AGE_USER_50 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_50") }}
              </option>
              <option value="{{ AGE_USER_60 }}"
                {{  $data["user"]->age == AGE_USER_60 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_60") }}
              </option>
              <option value="{{ AGE_USER_70 }}"
                {{  $data["user"]->age == AGE_USER_70 ? "selected" : "" }}>
                {{ __("horserace::be_form.age_70") }}
              </option>
            </select>
          </div>

          <!-- gender-->
          <div class="col-md-2 mb-3">
            <label>{{ __("horserace::be_form.gender") }}</label>
            <div class="d-flex mt-2">
              <label class="radio radio-inline radio-grey radio-primary">
                <input type="radio" name="gender" value="{{ MALE }}"
                  {{ $data["user"]->gender == MALE ? "checked" : "" }}>
                <span class="input-span"></span>
                {{ __("horserace::be_form.male") }}
              </label>
              <label class="radio radio-inline radio-grey radio-primary">
                <input type="radio" name="gender" value="{{ FEMALE }}"
                  {{  $data["user"]->gender == FEMALE ? "checked" : "" }}>
                <span class="input-span"></span>
                {{ __("horserace::be_form.female") }}
              </label>
            </div>
          </div>

        </div>

        <div class="row">
          <!-- point id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.point_owner") }}</label>
            <input class="form-control" value="{{ number_format($data["user"]->point) . " pt" }}"
                   type="text" readonly>
          </div>
          <!-- point deposit -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.point_deposit") }}</label>
            <input class="form-control" value="{{ number_format($data["user"]->point_deposit) . " pt" }}"
                   type="text" readonly>
          </div>
          <!-- point payment -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.point_payment") }}</label>
            <input class="form-control" value="{{ number_format($data["user"]->point_payment) . " pt" }}"
                   type="text" readonly>
          </div>
          <!-- point gift -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.point_gift") }}</label>
            <input class="form-control" value="{{ number_format($data["user"]->point_gift) . " pt" }}"
                   type="text" readonly>
          </div>

        </div>

        <div class="row">
          <!-- First deposit time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.first_deposit_time") }}</label>
            <input class="form-control" value="{{ $data["user"]->first_deposit_time }}"
                   type="text" readonly>
          </div>
          <!-- Last deposit time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_deposit_time") }}</label>
            <input class="form-control" value="{{ $data["user"]->last_deposit_time }}"
                   type="text" readonly>
          </div>
          <!-- First payment time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.first_payment_time") }}</label>
            <input class="form-control" value="{{ $data["user"]->first_payment_time }}"
                   type="text" readonly>
          </div>
          <!-- Last payment time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_payment_time") }}</label>
            <input class="form-control" value="{{ $data["user"]->last_payment_time }}"
                   type="text" readonly>
          </div>

        </div>

        <div class="row">
          <!-- login_number -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.login_number") }}</label>
            <input class="form-control" value="{{ $data["user"]->login_number }}"
                   type="number" readonly>
          </div>
          <!-- ip -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.ip") }}</label>
            <input class="form-control" value="{{ $data["user"]->ip }}"
                   type="text" readonly>
          </div>
          <!-- user_agent -->
          <div class="col-md-6 mb-3">
            <label>{{ __("horserace::be_form.user_agent") }}</label>
            <input class="form-control" value="{{ $data["user"]->user_agent }}"
                   type="text" readonly>
          </div>

        </div>

        <div class="row">
          <!-- Media -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.media_code") }}</label>
            <select class="selectpicker show-tick form-control" name="media_code">
              @foreach($data["media"] as $item)
                <option value="{{ $item->code }}"
                  {{  $data["user"]->media_code ==  $item->code ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
          </div>
          <!-- entrance_id -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.entrance") }}</label>
            <select class="selectpicker show-tick form-control" name="entrance_id">
              @foreach($data["entrance"] as $item)
                <option value="{{ $item->id }}"
                  {{ $data["user"]->entrance_id ==  $item->id ? "selected" : "" }}>
                  {{ $item->name }}
                </option>
              @endforeach
            </select>
          </div>
          <!-- stop_mail -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.stop_mail") }}</label>
            <select class="selectpicker show-tick form-control" name="stop_mail">
              <option value="{{ STOP_MAIL_DISABLE }}"
                {{ $data["user"]->stop_mail ==  STOP_MAIL_DISABLE ? "selected" : "" }}>
                {{ __("horserace::be_form.stop_mail_disable")  }}
              </option>
              <option value="{{ STOP_MAIL_ENABLE }}"
                {{ $data["user"]->stop_mail ==  STOP_MAIL_ENABLE ? "selected" : "" }}>
                {{ __("horserace::be_form.stop_mail_enable")  }}
              </option>
            </select>
          </div>
          <!-- SNS register -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.sns_register") }}</label>
            <input class="form-control" value="{{ $data["user"]->provider_user_id }}" type="text" readonly>
          </div>
          <!-- Deleted -->
          {{--<div class="col-md-3 mb-3">--}}
          {{--<label class="checkbox mt-5">--}}
          {{--<input class="form-control" type="checkbox" name="deleted_flg" value="{{ DELETED_ENABLE }}">--}}
          {{--<span class="input-span"></span>--}}
          {{--<span class="text-danger font-weight-bold">{{ __("horserace::be_form.deleted") }}</span>--}}
          {{--</label>--}}
          {{--</div>--}}
        </div>
        <div class="row">
          <!-- last_login_time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.last_login_time") }}</label>
            <input class="form-control" value="{{ $data["user"]->last_login_time }}"
                    type="text" readonly>
          </div>

          <!-- register_time -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.register_time") }}</label>
            <input class="form-control" value="{{ $data["user"]->register_time }}"
                    type="text" readonly>
          </div>
          <!-- payment_number -->
          <div class="col-md-3 mb-3">
            <label>{{ __("horserace::be_form.payment_number") }}</label>
            <input class="form-control" value="{{ $data["user"]->deposit_number }}"
                    type="text" readonly>
          </div>
        </div>

        <div class="row">
          <!-- User stage -->
          <label class="ml-3">{{ __("horserace::be_form.user_stage") }}</label>
          <button class="btn btn-dark ml-3 mb-3 btn-all"
                  type="button">
            {{ __("horserace::be_form.btn_user_stage_all") }}
          </button>

          <button class="btn btn-dark ml-3 mb-3 btn-remove-all"
                  type="button">
            {{ __("horserace::be_form.btn_user_stage_remove_all") }}
          </button>
          <div class="col-md-12 mb-3 row">
            @foreach($data["user_stage"] as $item)
              <div class="col-md-3">
                <div class="form-group">
                  <label class="checkbox checkbox-primary">
                    <input class="user_stage" name="user_stage_id[{{ $item->id }}]"
                           type="checkbox" value="{{ $item->id }}"
                      {{ isset($data["user"]->arr_user_stage[$item->id]) ? "checked" : "" }}>
                    <span class="input-span"></span>
                    {{ $item->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row">
          <!-- Memo -->
          <div class="col-lg-12 mb-3">
            <label>{{ __("horserace::be_form.memo") }}</label>
            <textarea class="summernote" id="summernote" data-plugin="summernote" data-air-mode="true"
          name="memo">{{$data['user']->memo}}</textarea>
          </div>
        </div>


      </div>

      <div class="ibox-footer d-flex">
        <div class="col-sm-2">
          <a class="btn btn-secondary" href="{{ route('admin.user.search')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
        </div>
        <div class="col-md-3">
          <button class="btn btn-info" type="button"
                 onclick="event.preventDefault(); document.getElementById('send-mail-bulk').submit();">
            {{ __("horserace::be_form.btn_send_mail_bulk") }}
          </button>
        </div>
        <div class="col-md-6 text-right">
          <button class="btn btn-primary mr-2" type="submit">
            {{ __("horserace::be_form.btn_edit_deleted") }}
          </button>
        </div>

      </div>
    </form>
    <!-- Send bulk -->
    <form id="send-mail-bulk" method="POST" action="{{ route("admin.mail_bulk.add") }}">
    {{ csrf_field() }}
    <!-- Condition -->
      <input type="hidden" name="condition" value="{{ $data["condition"] }}">
    </form>
  </div>
</div>

<!-- History transaction-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_form.transaction_history_user") }}
      </div>
      <div class="">
        <button class="btn btn-warning btn-add-bonus"
                data-login-id="{{ $data["user"]->login_id }}"
                data-toggle="modal"
                data-target="#transGift">
          {{ __('horserace::be_form.btn_bonus_point') }}
        </button>
      </div>
    </div>

    <div class="ibox-body">
      <!-- Transaction -->
      <div class="tab row">
        <div class="col-md-2">
          <button class="tablinks btn btn-primary w-100 active"
                  onclick="openCity(event, 'all')">
            {{ __("horserace::be_form.transaction_all") }}
          </button>
        </div>

        <div class="col-md-2">
          <button class="tablinks btn btn-primary w-100"
                  onclick="openCity(event, 'deposit')">
            {{ __("horserace::be_form.transaction_deposit") }}
          </button>
        </div>
        <div class="col-md-2">
          <button class="tablinks btn btn-primary w-100"
                  onclick="openCity(event, 'payment')">
            {{ __("horserace::be_form.transaction_payment") }}
          </button>
        </div>
        <div class="col-md-2">
          <button class="tablinks btn btn-primary w-100"
                  onclick="openCity(event, 'gift')">
            {{ __("horserace::be_form.transaction_gift") }}
          </button>
        </div>
        <div class="col-md-2">
          <button class="tablinks btn btn-primary w-100"
                  onclick="openCity(event, 'login_history')">
            {{ __("horserace::be_form.login_history") }}
          </button>
        </div>
      </div>
      <!-- Transaction All -->
      <div id="all" class="tabcontent" style="display: block">
        <div class="h1 mt-5 mb-3">
          {{ __("horserace::be_form.transaction_all") }}
        </div>
        <table class="table table-bordered table-hover dataTableTrans" id="trans-all-table">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th class="text-center">{{ __("horserace::be_form.updated_at") }}</th>
            <th class="text-center">{{ __("horserace::be_form.point") }}</th>
            <th class="text-center">{{ __("horserace::be_form.type") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data["trans"]["all"] as $key => $item)          
          <tr style="background:{{$item['status']==APPLY?'gray':''}};">
              <td width="10">{{ $key + 1 }}</td>
              <td class="text-left">{{ $item["updated_at"] }}</td>
              @switch($item["type"])
                @case(TRANSACTION_DEPOSIT)
                <td>{{ "+ " . number_format($item["point"]) . ' pt' }}</td>
                <td>{{'購入申込み('. ($item['method']==METHOD_BANK?__("horserace::be_form.method_bank"): __("horserace::be_form.method_credit")).')'}} </td>{{-- __("horserace::be_form.deposit") }}</td>--}}
                @break

                @case(TRANSACTION_PAYMENT)
                <td>{{ "- " . number_format($item["point"]) . ' pt'}}</td>
                <td> {{__("horserace::be_form.payment") }}</td>
                @break

                @case(TRANSACTION_GIFT)
                <td>{{($item["point"] >0?'+':'').number_format($item["point"]).'pt' }}</td>
                <td> {{ __("horserace::be_form.gift") }}</td>

                @break
              @endswitch
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- Transaction deposit -->
      <div id="deposit" class="tabcontent">
        <div class="h1 mt-5 mb-3">
          {{ __("horserace::be_form.transaction_deposit") }}
        </div>
        <table class="table table-bordered table-hover dataTableTrans" id="trans-deposit-table">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.id") }}</th>
            <th class="text-center">{{ __("horserace::be_form.updated_at") }}</th>
            <th class="text-center">{{ __("horserace::be_form.point") }}</th>
            <th class="text-center">{{ __("horserace::be_form.amount") }}</th>
            <th class="text-center">{{ __("horserace::be_form.status") }}</th>
            <th class="text-center">{{ __("horserace::be_form.method") }}</th>
            <th class="text-center">{{ __("horserace::be_form.transfer") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data["trans"]["deposit"] as $key => $item)
            <tr>
              <td>
                @if($item["status"] == NOT_APPLY)
                  <a class="trans-deposit" style="cursor: pointer"
                     data-id="{{ $item["id"] }}"
                     data-user-id="{{ $item["user_id"] }}"
                     data-login-id="{{ $item["login_id"] }}"
                     data-point="{{ $item["point"] }}"
                     data-amount="{{ $item["amount"] }}"
                     data-method="{{ $item["method"] }}"
                     data-toggle="modal"
                     data-target="#transDeposit">
                    <i class="ti-pencil-alt"></i>
                  </a>
                @endif
              </td>
              <td width="10">{{ $item["id"] }}</td>
              <td class="text-left">{{ $item["updated_at"] }}</td>
              <td>{{ number_format($item["point"]) . ' pt' }}</td>
              <td>{{ "¥ " . number_format($item["amount"]) }}</td>
              <td>{{ paymentStatusStr($item["status"]) }}</td>
              <td>{{ methodDepositStr($item["method"]) }}</td>
              <td>{{ transferStatusToStr($item["note"]) }}</td>
            </tr>
          @endforeach

          </tbody>
        </table>
      </div>
      <!-- Transaction payment -->
      <div id="payment" class="tabcontent">
        <div class="h1 mt-5 mb-3">
          {{ __("horserace::be_form.transaction_payment") }}
        </div>
        <table class="table table-bordered table-hover dataTableTrans" id="trans-payment-table">
          <thead class="thead-default thead-lg">
          <tr>
            <th>{{ __("horserace::be_form.id") }}</th>
            <th class="text-center">{{ __("horserace::be_form.updated_at") }}</th>
            <th class="text-center">{{ __("horserace::be_form.point") }}</th>
            <th class="text-center">{{ __("horserace::be_form.prediction_name") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data["trans"]["payment"] as $key => $item)
            <tr>
              <td width="10">{{ $item["id"] }}</td>
              <td class="text-left">{{ $item["updated_at"] }}</td>
              <td>{{ number_format($item["point"]) . ' pt' }}</td>
              <td class="text-left">{{ $item["prediction_name"] }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- Transaction gift -->
      <div id="gift" class="tabcontent">
        <div class="h1 mt-5 mb-3">
          {{ __("horserace::be_form.transaction_gift") }}
        </div>
        <table class="table table-bordered table-hover dataTableTrans" id="trans-gift-table">
          <thead class="thead-default thead-lg">
          <tr>
            <th>{{ __("horserace::be_form.id") }}</th>
            <th class="text-center">{{ __("horserace::be_form.updated_at") }}</th>
            <th class="text-center">{{ __("horserace::be_form.point") }}</th>
            <th class="text-center">{{ __("horserace::be_form.gift_name") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($data["trans"]["gift"] as $key => $item)
            <tr>
              <td width="10">{{ $item["id"] }}</td>
              <td class="text-left">{{ $item["updated_at"] }}</td>
              <td>{{ number_format($item["point"]) . ' pt' }}</td>
              <td class="text-left">{{ $item["gift_name"] }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- login_history -->
      <div id="login_history" class="tabcontent">
        <div class="h1 mt-5 mb-3">
          {{ __("horserace::be_form.login_history") }}
        </div>

        <table class="table table-bordered table-hover dataTableTrans" id="trans-gift-table">
          <thead class="thead-default thead-lg">
          <tr>
            <th></th>
            <th>{{ __("horserace::be_form.login_id") }}</th>
            <th>{{ __("horserace::be_form.login_time") }}</th>
            <th>{{ __("horserace::be_form.number_login") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($data['history'] as $item)
            <tr>
              <td width="5">{{ $item->id }}</td>
              <td>
                <a class="text-blue"
                   href="{{ route('admin.user.edit',$item->user_id ) }}">
                  {{ $item->login_id }}
                </a>
              </td>
              <td>{{ date("Y-m-d H:i:s", strtotime($item->login_date)) }}</td>
              <td>{{ number_format($item->login_number) }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
<!-- Popup -->
@include('horserace::backend.popup.trans_gift')
@include('horserace::backend.popup.trans_deposit')

@endsection
@section('javascript')
  <script>
    $(function () {
      $('.dataTableTrans').DataTable({
        pageLength: 20,
        fixedHeader: true,
        responsive: true,
        "sDom": 'rtip',
        "order": [[1, "desc"]],
        columnDefs: [{
          targets: 'no-sort',
          orderable: false
        }],
        language: {
          "sEmptyTable": "データはありません。",
          "sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",
          "sInfoEmpty": " 0 件中 0 から 0 まで表示",
          "sInfoFiltered": "（全 _MAX_ 件より抽出）",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": "_MENU_ 件表示",
          "sLoadingRecords": "読み込み中...",
          "sProcessing": "処理中...",
          "sSearch": "検索:",
          "sZeroRecords": "一致するレコードがありません",
          "oPaginate": {
            "sFirst": "先頭",
            "sLast": "最終",
            "sNext": "次",
            "sPrevious": "前"
          },
          "oAria": {
            "sSortAscending": ": 列を昇順に並べ替えるにはアクティブにする",
            "sSortDescending": ": 列を降順に並べ替えるにはアクティブにする"
          }
        }
      });
    });
  </script>

  <script>
    // using text area
    $(function () {
      $('.summernote').summernote();
      $('#summernote_air').summernote({
        airMode: true
      });
    });
  </script>

  <script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
  </script>

  <script>
    // Trans Deposit
    $(document).on('click', '.trans-deposit', function () {
      $('.id').val($(this).attr('data-id'));
      $('.user_id').val($(this).attr('data-user-id'));
      $('.login_id').val($(this).attr('data-login-id'));
      $('.point').val($(this).attr('data-point'));
      $('.amount').val($(this).attr('data-amount'));
      $('.status').val($(this).attr('data-status')).change();
      $('.method').val($(this).attr('data-method')).change();
    });

    //  Bonus gift
    $(document).on('click', '.btn-add-bonus', function () {
      $('.login_id').val($(this).attr('data-login-id'));
    });
  </script>

  <script type="text/javascript">
    // Add bonus point
    $(document).on('click', 'button.btn-all', function () {
      var check = document.getElementsByClassName('user_stage');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    });

    // Remove bonus point
    $(document).on('click', 'button.btn-remove-all', function () {
      var uncheck = document.getElementsByClassName('user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    });
  </script>
  <script>  
    $('#frmAdminUserStore').submit(function() 
    {
      
      var check_stage = document.getElementsByClassName('user_stage');
      var not_check_all = true;
      for (var i = 0; i < check_stage.length; i++)
      {
        if (check_stage[i].type == 'checkbox')
        {
          if(check_stage[i].checked == true)
          {
            not_check_all = false;
            break;
          }
        }
      }
      if(not_check_all == true)
      {
        var html_stage_id = "<input type='hidden' name='user_stage_id' value='0'>";
        $('#frmAdminUserStore').append(html_stage_id);
      }
      
      
    });
  </script>

@endsection
<script>
  /*window.addEventListener( "pageshow", function ( event )
  {
      if ( window.performance.navigation.type === 2 )
      {
      // Handle page restore.;
      window.location.reload();
      }
  });*/
 
</script>

