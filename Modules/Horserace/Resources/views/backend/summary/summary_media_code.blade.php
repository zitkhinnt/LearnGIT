@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_media_code"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_media_code"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_media_code") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Calendar -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head" id="click_hidden">
          <div class="ibox-title">
            <i class="ti-arrow-down"
               id="icon_arrow"> </i> {{ __("horserace::be_sidebar.summary_media_code") . " : " . $data["media"]->name }}
          </div>
        </div>
        <div class="ibox-body">
          <div id="hide_calendar">
            <div class="calendar-summary" id="calendarmedia"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table list datetime-->
  <div class="row">
    <div class="col-xl-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            <h5 class="title-time"></h5>
          </div>
        </div>
        <div class="ibox-body">
          <div style="overflow-x:auto;">
            <input class="media_code" type="hidden" name="media_code" value="{{ $data["media_code"] }}">
            <table id="table-report-day-media" class="table table-bordered mb-0">
              <thead class="thead-default">
              <tr>
                <th>{{ __('horserace::be_form.date') }}</th>
                <th> {{ __('horserace::be_form.access_count') }}</th>
                <th> {{ __('horserace::be_form.unique_number_new') }}</th>
                <th> {{ __('horserace::be_form.user_register') }}</th>
                <th> {{ __('horserace::be_form.total_amount_current_month') }}</th>
                <th> {{ __('horserace::be_form.total_amount_month_1') }}</th>
                <th> {{ __('horserace::be_form.total_amount_month_2') }}</th>
                <th> {{ __('horserace::be_form.total_amount_month_3') }}</th>
                <th> {{ __('horserace::be_form.amount_deposit') }}</th>
                <th> {{ __('horserace::be_form.number_deposit') }}</th>
                <th> {{ __('horserace::be_form.deposit_unit_price') }}</th>
                <th> {{ __('horserace::be_form.user_deposit') }}</th>
                <th> {{ __('horserace::be_form.average_login_count') }}</th>
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
  <script>
    // $('#table-report-day-media').DataTable({
    //   pageLength: 50,
    //   fixedHeader: true,
    //   responsive: true,
    //   "scrollX": true,
    //   "sDom": 'rtip',
    //   "ordering": false,
    //   columnDefs: [{
    //     targets: 'no-sort',
    //     orderable: false
    //   }],
    //   "fnDrawCallback": function (oSettings) {
    //     if (oSettings._iDisplayLength == -1
    //       || oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
    //       jQuery(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
    //       jQuery(oSettings.nTableWrapper).find('.dataTables_info').hide();
    //     } else {
    //       jQuery(oSettings.nTableWrapper).find('.dataTables_paginate').show();
    //       jQuery(oSettings.nTableWrapper).find('.dataTables_info').show();
    //     }
    //   },
    //   language: {
    //     "sEmptyTable": "データはありません。",
    //     "sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",
    //     "sInfoEmpty": " 0 件中 0 から 0 まで表示",
    //     "sInfoFiltered": "（全 _MAX_ 件より抽出）",
    //     "sInfoPostFix": "",
    //     "sInfoThousands": ",",
    //     "sLengthMenu": "_MENU_ 件表示",
    //     "sLoadingRecords": "読み込み中...",
    //     "sProcessing": "処理中...",
    //     "sSearch": "検索:",
    //     "sZeroRecords": "一致するレコードがありません",
    //     "oPaginate": {
    //       "sFirst": "先頭",
    //       "sLast": "最終",
    //       "sNext": "次",
    //       "sPrevious": "前"
    //     },
    //     "oAria": {
    //       "sSortAscending": ": 列を昇順に並べ替えるにはアクティブにする",
    //       "sSortDescending": ": 列を降順に並べ替えるにはアクティブにする"
    //     }
    //   }
    // });

  </script>
  <script>
    $('#calendarmedia').fullCalendar({
      locale: 'ja',
      height: 350,
      firstDay: 1,
      selectable: true,
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
      defaultDate: moment('{{ $data["default_date"] }}'),

      customButtons: {
        buttonPrev: {
          icon: 'fc-icon fc-icon-left-single-arrow',
          click: function () {
            $('#calendarmedia').fullCalendar('prev');
            callReportMonthMedia();
          }
        },
        buttonNext: {
          icon: 'fc-icon fc-icon-right-single-arrow',
          click: function () {
            $('#calendarmedia').fullCalendar('next');
            callReportMonthMedia();
          }
        },
        buttonToday: {
          text: '今日',
          click: function () {
            $('#calendarmedia').fullCalendar('today');
            callReportMonthMedia();
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
        callReportMonthMedia(true, startDate);
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
      callReportMonthMedia();
    });

    // Call ajax
    function callReportMonthMedia(selected = false, startDate) {
      var start_month;
      if (selected) {
        start_month = startDate.format();
      }
      else {
        intervalStart = $('#calendarmedia').fullCalendar('getView').intervalStart;
        start_month = intervalStart.format();
      }

      // Media code
      var media_code = $('.media_code').val();

      $.ajax({
        type: 'get',
        url: '{{ route('admin.summary.media_code.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'start_month': start_month,
          'media_code': media_code,
        },
        success: function (data) {
          result = JSON.parse(data);
          titleTime(result.year, result.month, result.day);
          console.log(result);
          tableReportDayMedia(result.datetime);

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

    // Table report day
    function tableReportDayMedia(report_day_month) {
      $("#table-report-day-media tbody").empty();
      var trHTML = '';
      var trHTML_summary = '';

      $.each(report_day_month, function (date, report) {
        if (date != 'summary') {
          trHTML += '<tr>' +
            '<td style="text-align:right;">' + report.date + '</a></td>' +
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
            '<td style="text-align:right;">' + report.total_number_login + ' 回</td>' +
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
            '<td style="text-align:right;">' + report.rate_login + ' 回</td>' +
            '</tr>';
        }
      });
      $('#table-report-day-media tbody').append(trHTML + trHTML_summary);
    }
  </script>

@endsection
