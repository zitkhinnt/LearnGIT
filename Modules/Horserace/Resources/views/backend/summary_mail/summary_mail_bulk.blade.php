@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_mail_bulk"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_mail_bulk"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_mail_bulk") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Calendar -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head" id="click_hidden">
          <div class="ibox-title">
            <i class="ti-arrow-down" id="icon_arrow"> </i> {{ __("horserace::be_sidebar.summary_mail_bulk") }}
          </div>
        </div>
        <div class="ibox-body">
          <div id="hide_calendar">
            <div class="calendar-summary" id="calendarmail_bulk"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table week -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            <h5 class="title-time"></h5>
          </div>
        </div>
        <div class="ibox-body">
          <table id="table-report-week-mail_bulk" class="table table-bordered table-hover">
            <thead class="thead-default">
            <tr>
              <th class="text-center">{{ __('horserace::be_form.week') }}</th>
              <th> {{ __('horserace::be_form.week_time') }}</th>
              <th class="text-center">{{ __('horserace::be_form.send_mail_success') }}</th>
              <th class="text-center">{{ __('horserace::be_form.read_number') }}</th>
              <th class="text-center">{{ __('horserace::be_form.rate_read') }}</th>
              <th class="text-center">{{ __('horserace::be_form.daemon') }}</th>
              <th class="text-center">{{ __('horserace::be_form.rate_daemon') }}</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart-->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            <h5 class="title-time"></h5>
          </div>
        </div>
        <div class="ibox-body">
          <div>
            <canvas id="bar_chart" style="height:350px;"></canvas>
            <input type="hidden">
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
            <h5>{{ __('horserace::be_form.daily') }}</h5>
          </div>
        </div>
        <div class="ibox-body">
          <table id="table-report-day-mail_bulk" class="table table-bordered  mb-5">
            <thead>
            <tr>
              <th>{{ __('horserace::be_form.date') }}</th>
              <th class="text-center">{{ __('horserace::be_form.send_mail_success') }}</th>
              <th class="text-center">{{ __('horserace::be_form.read_number') }}</th>
              <th class="text-center">{{ __('horserace::be_form.rate_read') }}</th>
              <th class="text-center">{{ __('horserace::be_form.daemon') }}</th>
              <th class="text-center">{{ __('horserace::be_form.rate_daemon') }}</th>
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
<!-- END PAGE CONTENT-->
@endsection
@section('javascript')
  <script>
    $('#calendarmail_bulk').fullCalendar({
      locale: 'ja',
      height: 350,
      firstDay: 1,
      selectable: true,
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],

      customButtons: {
        buttonPrev: {
          icon: 'fc-icon fc-icon-left-single-arrow',
          click: function () {
            $('#calendarmail_bulk').fullCalendar('prev');
            callReportMonthmail_bulk();
          }
        },
        buttonNext: {
          icon: 'fc-icon fc-icon-right-single-arrow',
          click: function () {
            $('#calendarmail_bulk').fullCalendar('next');
            callReportMonthmail_bulk();
          }
        },
        buttonToday: {
          text: '今日',
          click: function () {
            $('#calendarmail_bulk').fullCalendar('today');
            callReportMonthmail_bulk();
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
        callReportMonthmail_bulk(true, startDate);
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
      callReportMonthmail_bulk();
    });

    // Call ajax
    function callReportMonthmail_bulk(selected = false, startDate) {
      var start_month;
      if (selected) {
        start_month = startDate.format();
      }
      else {
        intervalStart = $('#calendarmail_bulk').fullCalendar('getView').intervalStart;
        start_month = intervalStart.format();
      }

      $.ajax({
        type: 'get',
        url: '{{ route('admin.summary.mail_bulk.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'start_month': start_month,
        },
        success: function (data) {
          result = JSON.parse(data);
          var send_success_number = [];
          var read_number = [];
          var daemon = []
          for (index in result.datetime) {
            send_success_number.push(result.datetime[index]['send_success_number']);
            read_number.push(result.datetime[index]['read_number']);
            daemon.push(result.datetime[index]['daemon']);
          }
          titleTime(result.year, result.month, result.day);
          // Bar char
          tableReportWeekMailBulk(result.weekly);
          tableReportDayMailBulk(result.datetime);
          barChar(result.date, send_success_number, read_number, daemon);

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

    // Char
    function barChar(date_time, send_success_number, read_number, daemon) {
      var barData = {
        labels: date_time,
        datasets: [
          {
            label: "実配信件数",
            backgroundColor: '#55efc4', // '#30C8B3'
            borderColor: "#fff",
            data: send_success_number
          },
          {
            label: "クリック件数",
            backgroundColor: '#fdcb6e',
            borderColor: "#fff",
            data: read_number
          },
          {
            label: "デーモン件数",
            backgroundColor: '#ff7675',
            borderColor: "#fff",
            data: daemon
          },
        ]
      };
      var barOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scaleShowValues: true,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
            }
          }],
          xAxes: [{
            ticks: {
              autoSkip: false
            }
          }],
        },
      };
      var ctx = document.getElementById("bar_chart").getContext("2d");
      new Chart(ctx, {type: 'bar', data: barData, options: barOptions})
    }

    // Table report day
    function tableReportDayMailBulk(report_day_month) {
      $("#table-report-day-mail_bulk tbody").empty();
      var trHTML = '';

      for (index in report_day_month) {
        trHTML += '<tr>' +
          '<td>' + report_day_month[index]['date'] + '</td>' +
          '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_day_month[index]['send_success_number']) + '件</td>' +
          '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_day_month[index]['read_number']) + '件</td>' +
          '<td style="text-align:right;">' + report_day_month[index]['rate_read_number'] + '%</td>' +
          '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_day_month[index]['daemon']) + ' 件</td>' +
          '<td style="text-align:right;">' + report_day_month[index]['rate_daemon'] + '%</td>' +
          '</tr>';
      }
      $('#table-report-day-mail_bulk tbody').append(trHTML);
    }

    // Table report week
    function tableReportWeekMailBulk(report_week_month) {
      $("#table-report-week-mail_bulk tbody").empty();

      var trHTML = '';
      var number = 0;
      $.each(report_week_month, function (number_week, report_week) {
        number += 1;
        if (number_week != 'summary') {
          trHTML += '<tr>' +
            '<td>' + number + '</td>' +
            '<td>' + report_week.from + ' ～ ' + report_week.to + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.send_success_number) + '件</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.read_number) + '件</td>' +
            '<td style="text-align:right;">' + report_week.rate_read_number + '%</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.daemon) + ' 件</td>' +
            '<td style="text-align:right;">' + report_week.rate_daemon + '%</td>' +
            '</tr>';
        }
        else {
          trHTML += '<tr>' +
            '<td class="bg-yellow" colspan="2">合計</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.send_success_number) + '件</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.read_number) + '件</td>' +
            '<td style="text-align:right;">' + report_week.rate_read_number + '%</td>' +
            '<td style="text-align:right;">' + report_week.daemon + '件</td>' +
            '<td style="text-align:right;">' + report_week.rate_daemon + '%</td>' +
            '</tr>';
        }
      });
      $('#table-report-week-mail_bulk tbody').append(trHTML);
    }

  </script>

@endsection
