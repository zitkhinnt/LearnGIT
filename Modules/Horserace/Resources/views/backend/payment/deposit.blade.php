@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.deposit"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.deposit"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.deposit") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <div class="ibox">
    <!-- Head -->
    <div class="ibox-head">
      <div class="ibox-title">
        {{ __("horserace::be_sidebar.deposit") }}
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
        <div class="">
          <a class="mb-0 ml-2 btn btn-success"
              data-id=""
              data-user-id=""
              data-login-id=""
              data-member_leve=""
              data-point=""
              data-amount=""
              data-method=""
              data-toggle="modal"
              data-target="#addDeposit">
              {{ __("horserace::be_form.btn_manual_deposit") }}
          </a>
        </div>

      </div>
      <div class="table-responsive row">
        <table class="table table-bordered table-hover" id="dataAjax">
          <thead class="thead-default thead-lg">
          <tr>
            <th>#</th>
            <th>{{ __("horserace::be_form.id") }}</th>
            <th>{{ __("horserace::be_form.created_at") }}</th>
            <th>{{ __("horserace::be_form.payment_at") }}</th>
            <th>{{ __("horserace::be_form.login_id") }}</th>
            <th>{{ __("horserace::be_form.point") }}</th>
            <th>{{ __("horserace::be_form.amount") }}</th>
            <th>{{ __("horserace::be_form.amount_pay") }}</th>
            <th>{{ __("horserace::be_form.method") }}</th>
            <th>{{ __("horserace::be_form.status") }}</th>
            <th>{{ __("horserace::be_form.member_level") }}</th>
            <th>{{ __("horserace::be_form.transfer") }}</th>
          </tr>
          </thead>
          <tbody>
          {{-- @foreach($data["trans_deposit"] as $item)
            <tr class="{{ depositToClass($item) }}">
              <td>
                  <a class="trans-deposit" style="cursor: pointer"
                     data-id="{{ $item->id }}"
                     data-user-id="{{ $item->user_id }}"
                     data-login-id="{{ $item->login_id }}"
                     data-point="{{ $item->point }}"
                     data-amount="{{ $item->amount }}"
                     data-method="{{ $item->method }}"
                     data-toggle="modal"
                     data-target="#transDeposit">
                    <i class="ti-pencil-alt"></i>
                  </a>
              </td>
              <td>{{ $item->id }}</td>
              <td>{{ $item->created_at }}</td>
              <td>{{ $item->payment_at }}</td>
              <td>
                <a href="{{ route("admin.user.edit", $item->user_id) }}">
                  {{ $item->login_id }}
                </a>
              </td>
              <td>{{ number_format($item->point) }}</td>
              <td>{{ "¥ " .  number_format($item->amount) }}</td>
              <td>{{ "¥ " .  number_format($item->amount_pay) }}</td>
              <td>{{ methodDepositStr($item->method) }}</td>
              <td>{{ paymentStatusStr($item->status) }}</td>
              <td>{{ memberLevelStr($item->member_level) }}</td>
              @if(isset($item->first_trans_id))
                  @if($item->first_trans_id != NULL)
                  <td>スピ</td>
                  @endif
                @else
                <td>{{ transferStatusToStr($item->note) }}</td>
                @endif
            </tr>
          @endforeach --}}
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<!-- Popup -->
@include('horserace::backend.popup.trans_deposit')
@include('horserace::backend.popup.add_deposit')
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
        "sAjaxSource": "{{ route('admin.deposit.ajax') }}",
        "iDisplayLength": 20,
        "aaSorting": [1, "desc" ],
        "oPaginate": {
          "sFirst": "先頭",
          "sLast": "最終",
          "sNext": "次",
          "sPrevious": "前"
        },
        "aaSorting": [2, "desc" ],
        "aoColumns": [
          { "sName": "title_review_condition",'render': function ( data, type, row ) {
                    return `<a class="trans-deposit" style="cursor: pointer" data-id="${data.id}" data-user-id="${data.user_id}" data-login-id="${data.login_id}" data-point="${data.point}" data-amount="${data.amount}" data-method="${data.method}" data-toggle="modal" data-target="#transDeposit"><i class="ti-pencil-alt"></i></a>`;
                },},
          { "sName": "id"},
          { "sName": "created_at"},
          { "sName": "payment_at"},
          { "sName": "login_id"},
          { "sName": "point"},
          { "sName": "amount"},
          { "sName": "amount_pay"},
          { "sName": "method"},
          { "sName": "status"},
          { "sName": "member_level"},
          { "sName": "transfer"}
        ],
        "fnServerParams": function ( aoData ) {
          aoData.push({ "name": "key_search", "value": $('#key-search').val() } );
        },
        rowCallback: function (row, data) {
          $(row).addClass(data[12].class);
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
  <script>
    // Review mail
    $(document).on('click', '.trans-deposit', function () {
      $('.id').val($(this).attr('data-id'));
      $('.user_id').val($(this).attr('data-user-id'));
      $('.login_id').val($(this).attr('data-login-id'));
      $('.point').val($(this).attr('data-point'));
      $('.amount').val($(this).attr('data-amount'));
      $('.status').val($(this).attr('data-status')).change();
      $('.method').val($(this).attr('data-method')).change();
    });
  </script>


@endsection