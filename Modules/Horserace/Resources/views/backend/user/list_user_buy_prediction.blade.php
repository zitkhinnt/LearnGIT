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
        <table class="table table-bordered table-hover dataTableScroll" id="dataTableUser">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.login_id") }}</th>
            <th>{{ __("horserace::be_form.member_level") }}</th>
            <th>{{ __("horserace::be_form.mail_pc") }}</th>
            <th>{{ __("horserace::be_form.media_code") }}</th>
            <th>{{ __("horserace::be_form.point") }}</th>
            <th>{{ __("horserace::be_form.user_stage") }}</th>
            <th>{{ __("horserace::be_form.register_time") }}</th>
            <th>{{ __("horserace::be_form.last_login") }}</th>
            <th>{{ __("horserace::be_form.number_login") }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($data['user'] as $item)
            <tr>
              <td>
                <a class="text-muted font-16" href="{{ route('admin.user.edit',$item->user_id ) }}">
                  <i class="ti-pencil-alt"></i>
                </a>
              </td>
              <td>
                <a href="{{ route('admin.user.edit',$item->user_id ) }}">
                  {{ $item->login_id }}
                </a>
              </td>
              <td>{{ memberLevelStr($item->member_level) }}</td>
              <td>
                @if((Auth::guard('admin')->user()->role_email)== ROLE_EMAIL_HIDDEN)
                {{ replaceStringEmail($item->mail_pc) }}
                @else
                {{ $item->mail_pc }}
                @endif
              </td>
              <td>{{ $item->media_code }}</td>
              <td align="center">{{ number_format($item->point) . " pt" }}</td>
              <td>{{ $item->user_stage_str }}</td>
              <td>{{ $item->register_time }}</td>
              <td>{{ $item->last_login_time }}</td>
              <td align="center">{{ $item->login_number }} 回</td>
              {{-- <td>
                <a class="text-muted font-16" href="javascript:;"><i class="ti-trash"></i></a>
              </td> --}}
            </tr>
          @endforeach

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
      var table = $('#dataTableUser').DataTable();
      table.column('5:visible')
        .order('desc')
        .draw();
      $('#key-search').on('keyup', function () {
        table.search(this.value).draw();
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