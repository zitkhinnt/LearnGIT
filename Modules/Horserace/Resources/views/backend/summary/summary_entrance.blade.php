@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_entrance"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_entrance"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_entrance") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Calendar -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head" id="click_hidden">
          <div class="ibox-title">
            <i class="ti-arrow-down" id="icon_arrow"> </i> {{ __("horserace::be_sidebar.summary_entrance") }}
          </div>
        </div>
        <div class="ibox-body">
          <div id="hide_calendar">
            <div class="calendar-summary" id="calendarentrance"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Summary -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            <h5 class="title-time"></h5>
          </div>
        </div>
        <div class="ibox-body">
          <div style="overflow-x:auto;">
            <table id="table-report-entrance" class="table table-bordered table-hover mb-0">
              <thead class="thead-default">
              <tr>
                <th> {{ __('horserace::be_form.entrance_name') }}</th>
                <th> {{ __('horserace::be_form.access_count') }}</th>
                <th> {{ __('horserace::be_form.unique_number') }}</th>
                <th> {{ __('horserace::be_form.user_register') }}</th>
                <th> {{ __('horserace::be_form.total_amount_current_month') }}</th>
                <th> {{ __('horserace::be_form.total_amount_month_1') }}</th>
                <th> {{ __('horserace::be_form.total_amount_month_2') }}</th>
                <th> {{ __('horserace::be_form.total_amount_month_3') }}</th>
                <th> {{ __('horserace::be_form.amount_deposit') }}</th>
                <th> {{ __('horserace::be_form.number_deposit') }}</th>
                <th> {{ __('horserace::be_form.deposit_unit_price') }}</th>
                <th> {{ __('horserace::be_form.user_deposit') }}</th>
                <th> {{ __('horserace::be_form.to_page_login') }}</th>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
  {{--<script>--}}
  {{--$('#table-report-entrance').DataTable({--}}
  {{--pageLength: 50,--}}
  {{--fixedHeader: true,--}}
  {{--responsive: true,--}}
  {{--"scrollX": true,--}}
  {{--"sDom": 'rtip',--}}
  {{--"ordering": false,--}}
  {{--columnDefs: [{--}}
  {{--targets: 'no-sort',--}}
  {{--orderable: false--}}
  {{--}],--}}
  {{--"fnDrawCallback": function (oSettings) {--}}
  {{--if (oSettings._iDisplayLength == -1--}}
  {{--|| oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {--}}
  {{--jQuery(oSettings.nTableWrapper).find('.dataTables_paginate').hide();--}}
  {{--jQuery(oSettings.nTableWrapper).find('.dataTables_info').hide();--}}
  {{--} else {--}}
  {{--jQuery(oSettings.nTableWrapper).find('.dataTables_paginate').show();--}}
  {{--jQuery(oSettings.nTableWrapper).find('.dataTables_info').show();--}}
  {{--}--}}
  {{--},--}}
  {{--language: {--}}
  {{--"sEmptyTable": "データはありません。",--}}
  {{--"sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",--}}
  {{--"sInfoEmpty": " 0 件中 0 から 0 まで表示",--}}
  {{--"sInfoFiltered": "（全 _MAX_ 件より抽出）",--}}
  {{--"sInfoPostFix": "",--}}
  {{--"sInfoThousands": ",",--}}
  {{--"sLengthMenu": "_MENU_ 件表示",--}}
  {{--"sLoadingRecords": "読み込み中...",--}}
  {{--"sProcessing": "処理中...",--}}
  {{--"sSearch": "検索:",--}}
  {{--"sZeroRecords": "一致するレコードがありません",--}}
  {{--"oPaginate": {--}}
  {{--"sFirst": "先頭",--}}
  {{--"sLast": "最終",--}}
  {{--"sNext": "次",--}}
  {{--"sPrevious": "前"--}}
  {{--},--}}
  {{--"oAria": {--}}
  {{--"sSortAscending": ": 列を昇順に並べ替えるにはアクティブにする",--}}
  {{--"sSortDescending": ": 列を降順に並べ替えるにはアクティブにする"--}}
  {{--}--}}
  {{--}--}}
  {{--});--}}

  {{--</script>--}}
  <script>
    $('#calendarentrance').fullCalendar({
      locale: 'ja',
      height: 350,
      firstDay: 1,
      selectable: true,
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],

      customButtons: {
        buttonPrev: {
          icon: 'fc-icon fc-icon-left-single-arrow',
          click: function () {
            $('#calendarentrance').fullCalendar('prev');
            callReportEntrance();
          }
        },
        buttonNext: {
          icon: 'fc-icon fc-icon-right-single-arrow',
          click: function () {
            $('#calendarentrance').fullCalendar('next');
            callReportEntrance();
          }
        },
        buttonToday: {
          text: '今日',
          click: function () {
            $('#calendarentrance').fullCalendar('today');
            callReportEntrance();
          }
        },
      },

      header: {
        left: 'buttonPrev buttonNext buttonToday',
        center: 'title',
        right: 'buttonToday buttonPrev buttonNext'
      },

      eventSources: [
        {
          url: '{{ route('admin.holiday') }}', // use the `url` property
          color: 'yellow',    // an option!
          textColor: 'black'  // an option!
        }
      ],

      select: function (startDate, endDate) {
        callReportEntrance(true, startDate);
      },

      views: {
        month: {
          titleFormat: 'YYYY年MM月'
        }
      }
    });
  </script>

  <script>
    // Ready
    $(document).ready(function () {
      callReportEntrance();
    });

    // Call ajax
    function callReportEntrance(selected = false, startDate) {
      var start_month;
      if (selected) {
        start_month = startDate.format();
      }
      else {
        intervalStart = $('#calendarentrance').fullCalendar('getView').intervalStart;
        start_month = intervalStart.format();
      }

      $.ajax({
        type: 'get',
        url: '{{ route('admin.summary.entrance.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'start_month': start_month,
        },
        success: function (data) {
          result = JSON.parse(data);
          titleTime(result.year, result.month, result.day);
          tableReportentrance(result.entrance);
          console.log(result);
        },
      });
    }

    function titleTime(year, month, day) {
      if (day == '01') {
        $('.title-time').text(year + '年' + month + '月');
      }
      else {
        $('.title-time').text(year + '年' + month + '月' + day + '日');
      }
    }

    // Table report week
    function tableReportentrance(entrance) {
      $("#table-report-entrance tbody").empty();

      var trHTML = '';
      var number = 0;
      var trHTML_summary = '';
      $.each(entrance, function (number_week, report) {
        if (number_week != 'summary') {
          trHTML += '<tr>' +
            '<td class="text-bg-blue"><a target="_blank" href="' + report.link_entrance_detail + '">' + report.entrance_name + '</a></td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.number_access) + '件</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_interim) + '人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_register) + '人</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_0) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_1) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_2) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_3) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.amount) + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.deposit) + '件</td>' +
            '<td style="text-align:right;">¥' + report.deposit_unit_price + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_deposit) + '人</td>' +
            '<td class="text-bg-blue"><a target="_blank" href="' + '{{ route("login") }}' + '">' + 'ログイン前TOPページ' + '</td>' +
            '</tr>';
        }
        else {
          trHTML_summary += '<tr>' +
            '<td class="bg-yellow">合計</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.number_access) + '件</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_interim) + '人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_register) + '人</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_0) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_1) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_2) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_3) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.amount) + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.deposit) + '件</td>' +
            '<td style="text-align:right;">¥' + report.deposit_unit_price + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_deposit) + '人</td>' +
            '<td style="text-align:right;">' + '' + '</td>' +
            '</tr>';
        }
      });
      $('#table-report-entrance tbody').append(trHTML + trHTML_summary);
    }

  </script>



@endsection
