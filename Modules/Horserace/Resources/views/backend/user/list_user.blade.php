
@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.list_user"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.list_user"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">
    <a href="{{ route('admin.user.search') }}">
      {{ __("horserace::be_sidebar.search_user") }}
    </a>
  </li>
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.list_user") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Head -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.list_user") }}
      </div>
      <div class="ibox-title text-right">
        <a class="mb-0 ml-2 btn btn-success"
           href="{{ route('admin.user.add') }}">
          {{ __("horserace::be_form.add_new") }}
        </a>
      </div>
    </div>

    @if (Session::has('flash_message'))
      <div class="alert alert-{!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
      </div>
  @endif

  <!-- List user -->
    <div class="ibox-body">
      <div class="flexbox mb-4">
        <div class="input-group-icon input-group-icon-left mr-3">
          <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
          <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                 placeholder="{{ __("horserace::be_form.search") }}">
        </div>

      </div>
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="dataAjax">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.login_id") }}</th>
            <th>{{ __("horserace::be_form.mail_pc") }}</th>
            <th>{{ __("horserace::be_form.media_code") }}</th>
            <th>{{ __("horserace::be_form.point") }}</th>
            <th>{{ __("horserace::be_form.amount_user_paid") }}</th>
            <th>{{ __("horserace::be_form.number_user_paid") }}</th>
            <th>{{ __("horserace::be_form.register_time") }}</th>
            <th>{{ __("horserace::be_form.number_login") }}</th>
            <th>{{ __("horserace::be_form.initial_paid_time") }}</th>
            <th>{{ __("horserace::be_form.last_paid_time") }}</th>
            <th>{{ __("horserace::be_form.last_login") }}</th>    
            <th>{{ __("horserace::be_form.member_level") }}</th>
            <th>{{ __("horserace::be_form.user_stage") }}</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

    <div class="ibox-footer">
      <div class="row">
        <div class="col-md-6">
          <a class="btn btn-secondary" href="{{ route('admin.user.search')}}">
            {{ __("horserace::be_form.btn_back") }}
          </a>
          <!-- Add point -->
          <button class="btn btn-warning btn-bonus-point"
                  data-condition="{{ $data["condition"] }}"
                  data-toggle="modal"
                  data-target="#addGiftAll">
            {{ __('horserace::be_form.btn_bonus_point') }}
          </button>

          <!-- remove point -->
          <button class="btn btn-danger btn-remove-bonus-point"
                  data-condition="{{ $data["condition"] }}"
                  data-toggle="modal"
                  data-target="#removeGiftAll">
            {{ __('horserace::be_form.btn_remove_bonus_point') }}
          </button>
        </div>
        <div class="col-md-3">
          <!-- Send bulk -->
          <form method="POST" action="{{ route("admin.mail_bulk.add") }}">
          {{ csrf_field() }}
          <!-- Condition -->
            <input type="hidden" name="condition" value="{{ $data["condition"] }}">
            <button class="btn btn-primary" type="submit">
              {{ __("horserace::be_form.btn_send_mail_bulk") }}
            </button>
          </form>
        </div>
        <!-- <div class="col-md-3"> -->
          <!-- Export csv -->
          <!-- <form method="GET" action="{{ route("admin.user.export_csv") }}"> -->
          <!-- {{ csrf_field() }} -->
          <!-- Condition -->
            <!-- <input type="hidden" name="condition" value="{{ $data["condition"] }}"> -->
            <!-- <button class="btn btn-info" type="submit"> -->
              <!-- {{ __("horserace::be_form.btn_export_user") }} -->
            <!-- </button> -->
          <!-- </form> -->
        <!-- </div> -->
      </div>
    </div>
  </div>

  <!-- Add user stage -->
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{--<i class="ti-arrow-down"></i>--}}
        {{ __("horserace::be_form.user_stage_add") }}
        <button class="btn btn-dark ml-3 btn-add-all"
                type="button">
          {{ __("horserace::be_form.btn_user_stage_all") }}
        </button>

        <button class="btn btn-dark ml-3 btn-add-remove-all"
                type="button">
          {{ __("horserace::be_form.btn_user_stage_remove_all") }}
        </button>
      </div>
      <div class="">

      </div>
    </div>

    <div id="user_stage_all_add" class="ibox-body">
      <form action="{{ route("admin.user.add_user_stage") }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="condition" value="{{ $data["condition"] }}">
        <div class="row">
          <!-- User stage -->
          <div class="col-md-12 mb-3 row">
            @foreach($data["user_stage"] as $item)
              <div class="col-md-3">
                <div class="form-group">
                  <label class="checkbox checkbox-primary">
                    <input class="add_user_stage" name="user_stage_id[{{ $item->id }}]" type="checkbox"
                           value="{{ $item->id }}">
                    <span class="input-span"></span>
                    {{ $item->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row">
          <div class="col-sm-10 ">

          </div>
          <div class="col-sm-2 ">
            <div class="text-right">
              <button type="submit" class="btn btn-primary btn-air mr-2">
                {{ __("horserace::be_form.user_stage_add") }}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

  </div>

  <!-- Edit user stage -->
  <div style="display:none;" class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{--<i class="ti-arrow-down"></i>--}}
        {{ __("horserace::be_form.user_stage_edit") }}

        <button class="btn btn-dark ml-3 btn-edit-all"
                type="button">
          {{ __("horserace::be_form.btn_user_stage_all") }}
        </button>

        <button class="btn btn-dark ml-3 btn-edit-remove-all"
                type="button">
          {{ __("horserace::be_form.btn_user_stage_remove_all") }}
        </button>
      </div>
      <div class="">

      </div>
    </div>

    <div style="display: none;" id="user_stage_all_add" class="ibox-body">
      <form action="{{ route("admin.user.edit_user_stage") }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="condition" value="{{ $data["condition"] }}">
        <div class="row">
          <!-- User stage -->
          <div class="col-md-12 mb-3 row">
            @foreach($data["user_stage"] as $item)
              <div class="col-md-3">
                <div class="form-group">
                  <label class="checkbox checkbox-primary">
                    <input class="edit_user_stage" name="user_stage_id[{{ $item->id }}]" type="checkbox"
                           value="{{ $item->id }}">
                    <span class="input-span"></span>
                    {{ $item->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row">
          <div class="col-sm-10 ">

          </div>
          <div class="col-sm-2 ">
            <div class="text-right">
              <button type="submit" class="btn btn-info btn-air mr-2">
                {{ __("horserace::be_form.user_stage_edit") }}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

  </div>

  <!-- Delete user stage -->
  <div class="ibox">
    <div class="ibox-head">
      <div class="ibox-title">
        {{--<i class="ti-arrow-down"></i>--}}
        {{ __("horserace::be_form.user_stage_deleted") }}

        <button class="btn btn-dark ml-3 btn-deleted-all"
                type="button">
          {{ __("horserace::be_form.btn_user_stage_all") }}
        </button>

        <button class="btn btn-dark ml-3 btn-deleted-remove-all"
                type="button">
          {{ __("horserace::be_form.btn_user_stage_remove_all") }}
        </button>
      </div>
      <div class="">

      </div>
    </div>

    <div id="user_stage_all_add" class="ibox-body">
      <form action="{{ route("admin.user.deleted_user_stage") }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="condition" value="{{ $data["condition"] }}">
        <div class="row">
          <!-- User stage -->
          <div class="col-md-12 mb-3 row">
            @foreach($data["user_stage"] as $item)
              <div class="col-md-3">
                <div class="form-group">
                  <label class="checkbox checkbox-primary">
                    <input class="deleted_user_stage" name="user_stage_id[{{ $item->id }}]" type="checkbox"
                           value="{{ $item->id }}">
                    <span class="input-span"></span>
                    {{ $item->name }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="row">
          <div class="col-sm-10 ">
          </div>
          <div class="col-sm-2 ">
            <div class="text-right">
              <button type="submit" class="btn btn-warning btn-air mr-2">
                {{ __("horserace::be_form.user_stage_deleted") }}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

  </div>

</div>
<!-- Popup -->
@include('horserace::backend.popup.add_gift_all')
@include('horserace::backend.popup.remove_gift_all')
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
  <script>
    $(function () {
      var table = $('#dataAjax').DataTable({
        "scrollX": "1200px",
        "bProcessing": true,
        "bServerSide": true,
        "searching": false,
        "sPaginationType": "full_numbers",
        "sAjaxSource": "{{ route('admin.user.search.post.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [0, "desc" ],
        "aoColumns": [
          { "sName": "user_id"},
          { "sName": "login_id"},
          { "sName": "mail_pc"},     
          { "sName": "media_code"},
          { "sName": "point"},
          { "sName": "amount_user_paid"},
          { "sName": "number_user_paid"},          
          { "sName": "register_time"},
          { "sName": "number_login"},
          { "sName": "initial_paid_time"},
          { "sName": "last_paid_time"},
          { "sName": "last_login"},          
          { "sName": "member_level"},
          { "sName": "user_stage"},
        ],
        "fnServerParams": function ( aoData ) {
          aoData.push({ "name": "login_id", "value": "{{ json_decode($data["condition"])->login_id }}" } );
          aoData.push({ "name": "user_key", "value": "{{ json_decode($data["condition"])->user_key }}" } );
          aoData.push({ "name": "point_min", "value": "{{ json_decode($data["condition"])->point_min }}" } );
          aoData.push({ "name": "point_max", "value": "{{ json_decode($data["condition"])->point_max }}" } );
          aoData.push({ "name": "nickname", "value": "{{ json_decode($data["condition"])->nickname }}" } );
          aoData.push({ "name": "gender", "value": {!! json_encode($data['gender']) !!} } );
          aoData.push({ "name": "member_level", "value": "{{ json_decode($data["condition"])->member_level }}" } );
          aoData.push({ "name": "deposit_total_amount_min", "value": "{{ json_decode($data["condition"])->deposit_total_amount_min }}" } );
          aoData.push({ "name": "deposit_total_amount_max", "value": "{{ json_decode($data["condition"])->deposit_total_amount_max }}" } );
          aoData.push({ "name": "age", "value": "{{ json_decode($data["condition"])->age }}" } );
          aoData.push({ "name": "deposit_total_number_min", "value": "{{ json_decode($data["condition"])->deposit_total_number_min }}" } );
          aoData.push({ "name": "deposit_total_number_max", "value": "{{ json_decode($data["condition"])->deposit_total_number_max }}" } );
          aoData.push({ "name": "mail_pc", "value": "{{ json_decode($data["condition"])->mail_pc }}" } );
          aoData.push({ "name": "mail_mobile", "value": "{{ json_decode($data["condition"])->mail_mobile }}" } );
          aoData.push({ "name": "login_number_min", "value": "{{ json_decode($data["condition"])->login_number_min }}" } );
          aoData.push({ "name": "login_number_max", "value": "{{ json_decode($data["condition"])->login_number_max }}" } );
          aoData.push({ "name": "ip", "value": "{{ json_decode($data["condition"])->ip }}" } );
          aoData.push({ "name": "prediction_type", "value": "{{ json_decode($data["condition"])->prediction_type }}" } );
          aoData.push({ "name": "register_time_start", "value": "{{ json_decode($data["condition"])->register_time_start }}" } );
          aoData.push({ "name": "register_time_end", "value": "{{ json_decode($data["condition"])->register_time_end }}" } );
          aoData.push({ "name": "media_code", "value": "{{ json_decode($data["condition"])->media_code }}" } );
          aoData.push({ "name": "entrance_id", "value": "{{ json_decode($data["condition"])->entrance_id }}" } );
          aoData.push({ "name": "stop_mail", "value": "{{ json_decode($data["condition"])->stop_mail }}" } );
          aoData.push({ "name": "sns_register", "value": "{{ json_decode($data["condition"])->sns_register }}" } );
          aoData.push({ "name": "first_deposit_time_start", "value": "{{ json_decode($data["condition"])->first_deposit_time_start }}" } );
          aoData.push({ "name": "first_deposit_time_end", "value": "{{ json_decode($data["condition"])->first_deposit_time_end }}" } );
          aoData.push({ "name": "last_deposit_time_start", "value": "{{ json_decode($data["condition"])->last_deposit_time_start }}" } );
          aoData.push({ "name": "last_deposit_time_end", "value": "{{ json_decode($data["condition"])->last_deposit_time_end }}" } );
          aoData.push({ "name": "first_payment_time_start", "value": "{{ json_decode($data["condition"])->first_payment_time_start }}" } );
          aoData.push({ "name": "first_payment_time_end", "value": "{{ json_decode($data["condition"])->first_payment_time_end }}" } );
          aoData.push({ "name": "last_payment_time_start", "value": "{{ json_decode($data["condition"])->last_payment_time_start }}" } );
          aoData.push({ "name": "last_payment_time_end", "value": "{{ json_decode($data["condition"])->last_payment_time_end }}" } );
          aoData.push({ "name": "last_login_time_start", "value": "{{ json_decode($data["condition"])->last_login_time_start }}" } );
          aoData.push({ "name": "last_login_time_end", "value": "{{ json_decode($data["condition"])->last_login_time_end }}" } );
          aoData.push({ "name": "user_stage", "value": "{{ json_encode(json_decode($data["condition"])->user_stage_id) }}" } );
          aoData.push({ "name": "summernote", "value": "{{ json_decode($data["condition"])->summernote }}" } );
          aoData.push({ "name": "option_summer", "value": "{{ json_decode($data["condition"])->option_summer }}" } );
          aoData.push({ "name": "summernote_not", "value": "{{ json_decode($data["condition"])->summernote_not }}" } );
          aoData.push({ "name": "option_summer_not", "value": "{{ json_decode($data["condition"])->option_summer_not }}" } );
          aoData.push({ "name": "key_search", "value": $('#key-search').val() } );
          aoData.push({ "name": "search_match_type", "value": "{{ json_decode($data["condition"])->search_match_type }}" } );
        },
        language: {
          paginate: {
              first: '<<',
              previous: '前',
              next:     '次',
              last: '>>',
          },
          zeroRecords: "データはありません。",
        }
      });
      $('#key-search').keypress(function(event) {
        if (event.key === "Enter") {
          table.draw();
        }
      });
      $('#type-filter').on('change', function () {
        table.column(2).search($(this).val()).draw();
      });
    });
  </script>
  <script type="text/javascript">
    // Add bonus point
    $(document).on('click', 'button.btn-bonus-point', function () {
      $('#add-condition').val($(this).attr('data-condition'));
    });

    // Remove bonus point
    $(document).on('click', 'button.btn-remove-bonus-point', function () {
      $('#remove-condition').val($(this).attr('data-condition'));
    });
  </script>

  <script type="text/javascript">
    // Add all user stage
    $(document).on('click', 'button.btn-add-all', function () {
      var check = document.getElementsByClassName('add_user_stage');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    });

    // Add remove all user stage
    $(document).on('click', 'button.btn-add-remove-all', function () {
      var uncheck = document.getElementsByClassName('add_user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    });

    // Edit bonus all user stage
    $(document).on('click', 'button.btn-edit-all', function () {
      var check = document.getElementsByClassName('edit_user_stage');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    });

    // Edit remove all user stage
    $(document).on('click', 'button.btn-edit-remove-all', function () {
      var uncheck = document.getElementsByClassName('edit_user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    });

    // Deleted bonus all user stage
    $(document).on('click', 'button.btn-deleted-all', function () {
      var check = document.getElementsByClassName('deleted_user_stage');
      for (var i = 0; i < check.length; i++) {
        if (check[i].type == 'checkbox') {
          check[i].checked = true;
        }
      }
    });

    // Deleted remove all user stage
    $(document).on('click', 'button.btn-deleted-remove-all', function () {
      var uncheck = document.getElementsByClassName('deleted_user_stage');
      for (var i = 0; i < uncheck.length; i++) {
        if (uncheck[i].type == 'checkbox') {
          uncheck[i].checked = false;
        }
      }
    });
  </script>
@endsection