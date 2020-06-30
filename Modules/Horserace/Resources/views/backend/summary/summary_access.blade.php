@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_access"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_access"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_access") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Calendar -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head" id="click_hidden">
          <div class="ibox-title">
            <i class="ti-arrow-down" id="icon_arrow"> </i> {{ __("horserace::be_sidebar.summary_access") }}
          </div>
        </div>
        <div class="ibox-body">
          <div id="hide_calendar">
            <div class="calendar-summary" id="calendaraccess"></div>
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
          <table id="table-report-week-access" class="table table-bordered table-hover">
            <thead class="thead-default">
            <tr>
              <th class="text-center">{{ __('horserace::be_form.week') }}</th>
              <th> {{ __('horserace::be_form.week_time') }}</th>
              <th class="text-center">{{ __('horserace::be_form.number_user_login') }}</th>
              <th class="text-center">{{ __('horserace::be_form.number_access') }}</th>
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
            <canvas id="line_chart" style="height:350px;"></canvas>
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
          <table id="table-report-day-access" class="table table-bordered  mb-5">
            <thead>
            <tr>
              <th>{{ __('horserace::be_form.date') }}</th>
              <th class="text-center">{{ __('horserace::be_form.number_user_login') }}</th>
              <th class="text-center">{{ __('horserace::be_form.number_access') }}</th>
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
    $('#calendaraccess').fullCalendar({
      locale: 'ja',
      height: 350,
      firstDay: 1,
      selectable: true,
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],

      customButtons: {
        buttonPrev: {
          icon: 'fc-icon fc-icon-left-single-arrow',
          click: function () {
            $('#calendaraccess').fullCalendar('prev');
            callReportMonthaccess();
          }
        },
        buttonNext: {
          icon: 'fc-icon fc-icon-right-single-arrow',
          click: function () {
            $('#calendaraccess').fullCalendar('next');
            callReportMonthaccess();
          }
        },
        buttonToday: {
          text: '今日',
          click: function () {
            $('#calendaraccess').fullCalendar('today');
            callReportMonthaccess();
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
        // callReportMonthaccess(true, startDate);
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
      callReportMonthaccess();
      // lineChar();
    });

    // Call ajax
    function callReportMonthaccess(selected = false, startDate) {
      var start_month;
      if (selected) {
        start_month = startDate.format();
      }
      else {
        intervalStart = $('#calendaraccess').fullCalendar('getView').intervalStart;
        start_month = intervalStart.format();
      }

      $.ajax({
        type: 'get',
        url: '{{ route('admin.summary.access.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'start_month': start_month,
        },
        success: function (data) {
          result = JSON.parse(data);
          var number_user_login = [];
          var number_access = [];
          for (index in result.datetime) {
            number_user_login.push(result.datetime[index]['number_user_login']);
            number_access.push(result.datetime[index]['number_access']);
          }
          titleTime(result.year, result.month, result.day);
          tableReportWeekaccess(result.weekly);
          tableReportDayaccess(result.datetime);
          lineChar(result.date, number_user_login, number_access);

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

    function lineChar(date_time, number_user_login, number_access) {
      var lineData = {
        labels: date_time,
        datasets: [
          {
            label: "ログイン数(ユニーク)",
            backgroundColor: 'rgba(67,174,168,0.5)',
            borderColor: 'rgba(67,174,168,0.7)',
            pointBackgroundColor: 'rgba(67,174,168,1)',
            pointBorderColor: "#fff",
            data: number_user_login,
            //fill: false, // for removing background
          }, {
            label: "販売数",
            backgroundColor: 'rgba(213,217,219, 0.5)',
            borderColor: 'rgba(213,217,219, 1)',
            pointBorderColor: "#fff",
            data: number_access,
            //fill: false,
          }
        ]
      };
      var lineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              callback: function (value, index, values) {
                var monney = new Intl.NumberFormat().format(value);
                return monney;
              }
            }
          }],
          xAxes: [{
            ticks: {
              autoSkip: false
            }
          }],
        },
      };
      var ctx = document.getElementById("line_chart").getContext("2d");
      new Chart(ctx, {type: 'line', data: lineData, options: lineOptions});
    }

    // Char
    function barChar(date_time, point) {
      var barData = {
        labels: date_time,
        datasets: [
          {
            label: '{{ __('horserace::be_form.access') }}',
            backgroundColor: '#18C5A9', // '#30C8B3'
            borderColor: "#fff",
            data: point
          }
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
              callback: function (value, index, values) {
                var monney = new Intl.NumberFormat().format(value);
                return monney;
              }
            }
          }],
          xAxes: [{
            ticks: {
              autoSkip: false
            }
          }],
        },
        tooltips: {
          callbacks: {
            title: function (tooltipItem, data) {
              return data['labels'][tooltipItem[0]['index']];
            },
            label: function (tooltipItem, data) {
              var value = new Intl.NumberFormat().format(data['datasets'][0]['data'][tooltipItem['index']]);
              return value;
            },
          },
        }

      };
      var ctx = document.getElementById("bar_chart").getContext("2d");
      new Chart(ctx, {type: 'bar', data: barData, options: barOptions})
    }

    // Table report day
    function tableReportDayaccess(report_day_month) {
      $("#table-report-day-access tbody").empty();
      var trHTML = '';

      for (index in report_day_month) {
        trHTML += '<tr>' +
          '<td>' + report_day_month[index]['date'] + '</td>' +
          '<td>' + new Intl.NumberFormat().format(report_day_month[index]['number_user_login']) + '人</td>' +
          '<td>' + new Intl.NumberFormat().format(report_day_month[index]['number_access']) + '件</td>' +
          '</tr>';
      }
      $('#table-report-day-access tbody').append(trHTML);
    }

    // Table report week
    function tableReportWeekaccess(report_week_month) {
      $("#table-report-week-access tbody").empty();

      var trHTML = '';
      var number = 0;
      $.each(report_week_month, function (number_week, report_week) {
        number += 1;
        if (number_week != 'summary') {
          trHTML += '<tr>' +
            '<td>' + number + '</td>' +
            '<td>' + report_week.from + ' ～ ' + report_week.to + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.number_user_login) + ' 人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.number_access) + ' 件</td>' +
            '</tr>';
        }
        else {
          trHTML += '<tr>' +
            '<td class="bg-yellow" colspan="2">合計</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.number_user_login) + ' 人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report_week.number_access) + '件</td>' +
            '</tr>';
        }
      });
      $('#table-report-week-access tbody').append(trHTML);
    }

  </script>

@endsection
