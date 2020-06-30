@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.user_buy_prediction"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.user_buy_prediction"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.user_buy_prediction") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Title -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.user_buy_prediction") }}
      </div>
      <div class="ibox-title text-right">

      </div>
    </div>

    <!-- List User buy -->
    <div class="ibox-body">
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif

      <div class="flexbox mb-4">
        <button class="btn btn-primary btn-add-buy"
                data-toggle="modal"
                data-target="#addUserBuyPrediction"
                data-pre-id={{ $data["prediction"]->id }}>
          {{ __('horserace::be_form.btn_add_user_buy_prediction') }}
        </button>
      </div>

      <div class="flexbox mb-4">
        <div class="flexbox">
          <label class="mb-0 mr-2">
            {{ __("horserace::be_form.member_level") }}
          </label>
          <select class="selectpicker show-tick form-control" id="type-filter"
                  title="{{ __("horserace::be_form.please_select") }}"
                  data-style="btn-solid" data-width="150px">
            <option value="">
              {{ __("horserace::be_form.search_all") }}
            </option>
            <option value="{{ __("horserace::be_form.member_level_trail") }}">
              {{ __("horserace::be_form.member_level_trail") }}
            </option>
            <option value="{{  __("horserace::be_form.member_level_gold") }}">
              {{ __("horserace::be_form.member_level_gold") }}
            </option>
            <option value="{{ __("horserace::be_form.member_level_diamond") }}">
              {{ __("horserace::be_form.member_level_diamond") }}
            </option>
            <option value="{{ __("horserace::be_form.member_level_crystal") }}">
              {{ __("horserace::be_form.member_level_crystal") }}
            </option>
          </select>
        </div>
        <div class="input-group-icon input-group-icon-left mr-3">
          <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
          <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text"
                 placeholder="{{ __("horserace::be_form.search") }}">
        </div>
      </div>

      <div class="table-responsive row">
        <form class="w-100"
              action="{{ route("admin.user.buy_prediction.delete") }}"
              method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="prediction_id" value="{{ $data["prediction"]->id }}">

          <table class="table table-bordered table-hover" id="datatable">
            <thead class="thead-default thead-lg">
            <tr>
              <th>#</th>
              <th>{{ __("horserace::be_form.login_id") }}</th>
              <th>{{ __("horserace::be_form.member_level") }}</th>
              <th>{{ __("horserace::be_form.info_name") }}</th>
              <th>{{ __("horserace::be_form.point") }}</th>
              <th>{{ __("horserace::be_form.purchase_time") }}</th>
              <th>{{ __("horserace::be_form.delete") }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data['user_buy'] as $item)
              <tr>
                <td>
                  <a class="text-muted font-16"
                     href="{{ route('admin.user.edit',$item->user_id ) }}">
                    <i class="ti-pencil-alt"></i>
                  </a>
                </td>
                <td>
                  <a href="{{ route('admin.user.edit',$item->user_id ) }}"
                     style="color: #f0932b;">
                    {{ $item->info->login_id }}
                  </a>
                </td>
                <td>{{ memberLevelStr($item->info->member_level) }}</td>
                <td>
                  <a href="{{ route("admin.prediction.edit", $data["prediction"]->id) }}" style="color: #0984e3;">
                    {{ $data["prediction"]->name }}
                  </a>
                </td>
                <td>{{ number_format($item->trans->point) }} pt</td>
                <td>{{ $item->trans->created_at }}</td>
                <td>
                  <div class="form-group">
                    <label class="checkbox checkbox-primary">
                      <input class="deleted_user_buy" name="user_buy_id[{{ $item->id }}]" type="checkbox"
                             value="{{ $item->id }}">
                      <span class="input-span"></span>
                    </label>
                  </div>
                </td>
              </tr>
            @endforeach

            </tbody>
          </table>

          <!-- Update -->
          <button class="btn btn-danger btn-remove-bonus-point ml-5">
            {{ __('horserace::be_form.btn_delete_checked') }}
          </button>
        </form>
      </div>
    </div>
    <!-- -->
    <div class="ibox-footer row mt-4">
      <div class="col-sm-10 ">
        <a class="btn btn-secondary" href="{{ route('admin.prediction')}}">
          {{ __("horserace::be_form.btn_back") }}
        </a>
      </div>
      <div class="col-sm-2 ">
        <div class="text-right">

        </div>
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
<!-- Popup -->
@include('horserace::backend.popup.add_user_buy_prediction')

@endsection
@section('javascript')
  <script>
    $(function () {

      var table = $('#datatable').DataTable();
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

  <!-- -->
  <script>
    $('.btn-add-buy').click(function () {
      var pre_id = $(this).attr("data-pre-id");
      $('.prediction_detail_id').val(pre_id);
    });
  </script>
@endsection