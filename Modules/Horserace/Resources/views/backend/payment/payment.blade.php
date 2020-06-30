@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.payment"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.payment"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.payment") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Head -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.payment") }}
      </div>
    </div>

    <!-- List user -->
    <div class="ibox-body">
      @if (Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}">
          {!! Session::get('flash_message') !!}
        </div>
      @endif

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
            <th>{{ __("horserace::be_form.id") }}</th>
            <th>{{ __("horserace::be_form.created_at") }}</th>
            <th>{{ __("horserace::be_form.login_id") }}</th>
            <!-- <th>{{ __("horserace::be_form.member_level") }}</th> -->
            <th>{{ __("horserace::be_form.point") }}</th>
            <th>{{ __("horserace::be_form.prediction_name") }}</th>
          </tr>
          </thead>
          <tbody>
          {{-- @foreach($data["trans_payment"] as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->created_at }}</td>
              <td>
                <a href="{{ route("admin.user.edit", $item->user_id) }}">
                  {{ $item->login_id }}
                </a>
              </td>
              <!-- <td>{{ memberLevelStr($item->member_level) }}</td> -->
              <td>{{ number_format($item->point) . " pt" }}</td>
              <th>{{ $item->prediction_name }}</th>
            </tr>
          @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
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
        "sAjaxSource": "{{ route('admin.payment.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [0, "desc" ],
        "aoColumns": [
          { "sName": "id"},
          { "sName": "created_at"},
          { "sName": "login_id"},
          { "sName": "point"},
          { "sName": "prediction_name"}
        ],
        "fnServerParams": function ( aoData ) {
          aoData.push({ "name": "key_search", "value": $('#key-search').val() } );
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
@endsection