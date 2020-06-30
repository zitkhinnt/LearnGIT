@extends('horserace::backend.layouts.design')
@section('title',__("horserace::be_sidebar.summary_media"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.summary_media"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.summary_media") }}</li>
@endsection

<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
  <!-- Calendar -->
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head" id="click_hidden">
          <div class="ibox-title">
            <i class="ti-arrow-down" id="icon_arrow"> </i> {{ __("horserace::be_sidebar.summary_media") }}
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
          <div class="row">
            <div class="col-md-8 mb-3">
              <label>{{ __("horserace::be_form.period_time") }}</label>
              <div class="form-row">
                <div class="col d-flex">
                  <input type="number" min="2017" max="2030" class="form-control w-80 p-0 pl-2 pr-2 year_start"
                         name="year_start">
                  <span class="m-2">年</span>
                </div>
                <div class="col d-flex">
                  <input type="number" min="1" max="12" class="form-control w-80 p-0 pl-2 pr-2 month_start"
                         name="month_start">
                  <span class="m-2">月</span>
                </div>
                <div class="col d-flex">
                  <input type="number" class="form-control w-50 p-0 pl-2 pr-2 day_start" name="day_start">
                  <span class="m-2">日 ～</span>
                </div>
                <div class="col d-flex">
                  <input type="number" min="2017" max="2030" class="form-control w-80 p-0 pl-2 pr-2 year_end"
                         name="year_end">
                  <span class="m-2">年</span>
                </div>
                <div class="col d-flex">
                  <input type="number" min="1" max="12" class="form-control w-80 p-0 pl-2 pr-2 month_end"
                         name="month_end">
                  <span class="m-2">月</span>
                </div>
                <div class="col d-flex">
                  <input type="number" class="form-control w-50 p-0 pl-2 pr-2 day_end" name="day_end">
                  <span class="m-2">日</span>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-3">
              <label>{{ __("horserace::be_form.media_code") }}</label>
              <input type="text" class="form-control media_code w-50" name="media_code">
            </div>
            <div class="col-md-2 mb-3">
              <button class="btn btn-primary btn-search" style="margin-top: 1.9rem;" type="submit">
                {{ __("horserace::be_form.btn_search") }}
              </button>
            </div>
          </div>
          <div style="overflow-x:auto;">
            <table id="table-report-media" class="table table-bordered table-hover mb-0">
              <thead class="thead-default">
              <tr>
                <th style="cursor: pointer;" onclick="sortTable(0)"> {{ __('horserace::be_form.media_code') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(1)"> {{ __('horserace::be_form.media_name') }} <i class="fa fa-long-arrow-up" style="margin-left:260px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(2)"> {{ __('horserace::be_form.ad_type') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(3)"> {{ __('horserace::be_form.access_count') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(4)"> {{ __('horserace::be_form.unique_number_new') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(5)"> {{ __('horserace::be_form.user_register') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(6)"> {{ __('horserace::be_form.total_ad_cost') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(7)"> {{ __('horserace::be_form.total_amount_current_month') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(8)"> {{ __('horserace::be_form.total_amount_month_1') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(9)"> {{ __('horserace::be_form.total_amount_month_2') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(10)"> {{ __('horserace::be_form.total_amount_month_3') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(11)"> {{ __('horserace::be_form.amount_deposit') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(12)"> {{ __('horserace::be_form.number_deposit') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(13)"> {{ __('horserace::be_form.deposit_unit_price') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(14)"> {{ __('horserace::be_form.user_deposit') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(15)"> {{ __('horserace::be_form.total_new_deposit_user') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(16)"> {{ __('horserace::be_form.total_new_deposit_new_register_user') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
                <th style="cursor: pointer;" onclick="sortTable(17)"> {{ __('horserace::be_form.average_login_count') }} <i class="fa fa-long-arrow-up" style="margin-left:20px"></i><i class="fa fa-long-arrow-down"></i></th>
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
    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("table-report-media");
      switching = true;
      dir = "asc";
      while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 2); i++) {
          shouldSwitch = false;
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];

          if (n == 0 || n == 1 || n == 2){
            if (dir == "asc") {
              if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
              }
            } else if (dir == "desc") {
              if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
              }
            }
          }
          else{
            if (dir == "asc") {
              if (parseFloat(x.innerHTML.toLowerCase().replace(/[^0-9\.]/g, ''), 10) > parseFloat(y.innerHTML.toLowerCase().replace(/[^0-9\.]/g, ''), 10)) {
                shouldSwitch = true;
                break;
              }
            } else if (dir == "desc") {
              if (parseFloat(x.innerHTML.toLowerCase().replace(/[^0-9\.]/g, ''), 10) < parseFloat(y.innerHTML.toLowerCase().replace(/[^0-9\.]/g, ''), 10)) {
                shouldSwitch = true;
                break;
              }
            }
          }
        }
        if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          switchcount ++;
        } else {
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }
  </script>
  <script>
    $('#calendarmedia').fullCalendar({
      locale: 'ja',
      height: 350,
      firstDay: 1,
      selectable: true,
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],

      customButtons: {
        buttonPrev: {
          icon: 'fc-icon fc-icon-left-single-arrow',
          click: function () {
            $('#calendarmedia').fullCalendar('prev');
            callReportMedia();
          }
        },
        buttonNext: {
          icon: 'fc-icon fc-icon-right-single-arrow',
          click: function () {
            $('#calendarmedia').fullCalendar('next');
            callReportMedia();
          }
        },
        buttonToday: {
          text: '今月',
          click: function () {
            $('#calendarmedia').fullCalendar('today');
            callReportMedia();
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
        callReportMedia(true, startDate);
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
      callReportMedia();
    });

    // Call ajax
    function callReportMedia(selected = false, startDate) {
      var start_month;
      if (selected) {
        start_month = startDate.format();
        var date = startDate.date();
        var month = startDate.month() + 1;
        var year = startDate.year();
        var media_code = $('.media_code').val();

        $.ajax({
          type: 'get',
          url: '{{ route('admin.summary.media_sort.ajax') }}',
          data: {
            // '_token': $('input[name=_token]').val(),
            'year_start': year,
            'month_start': month,
            'day_start': date,
            'year_end': year,
            'month_end': month,
            'day_end': date,
            'media_code': media_code,
          },
          success: function (data) {
            result = JSON.parse(data);
            titleTime(result.year, result.month, result.day);
            endTimePeriod(result.year_end, result.month_end, result.day_end);
            tableReportMedia(result.media);
          },
        });
        return true;
      }
      else {
        intervalStart = $('#calendarmedia').fullCalendar('getView').intervalStart;
        start_month = intervalStart.format();
      }

      var res = start_month.split("-");
      var day_end = new Date(res[0], res[1], 0).getDate();
      var month_end = res[1];
      var year_end = res[0];
      
      var year_start = res[0];
      var month_start = res[1];
      var day_start = 1;

      var media_code = $('.media_code').val();

      $.ajax({
        type: 'get',
        url: '{{ route('admin.summary.media_sort.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'year_start': year_start,
          'month_start': month_start,
          'day_start': day_start,
          'year_end': year_end,
          'month_end': month_end,
          'day_end': day_end,
          'media_code': media_code,
        },
        success: function (data) {
          result = JSON.parse(data);
          titleTime(result.year, result.month, result.day);
          endTimePeriod(result.year_end, result.month_end, result.day_end);
          tableReportMedia(result.media);
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
      $('.year_start').val(year);
      $('.month_start').val(month);
      $('.day_start').val(day);
    }

    function endTimePeriod(year, month, day) {
      $('.year_end').val(year);
      $('.month_end').val(month);
      $('.day_end').val(day);
    }

    // Table report week
    function tableReportMedia(media) {
      $("#table-report-media tbody").empty();

      var trHTML = '';
      var number = 0;
      var trHTML_summary = '';
      let ad_type = '';
      $.each(media, function (number_week, report) {
        if (number_week != 'summary') {
          if (report.ad_type == 0)
            ad_type = 'AF';
          else if (report.ad_type == 1)
            ad_type = 'シェア';
          else
            ad_type = '純広';
          if (report.media_code == 'zzz') {
            trHTML += '<tr>' +
              '<td class="text-bg-blue"><a target="_blank"  href="' + report.link_media_code + '">' + report.media_code + '</a></td>' +
              '<td>' + report.name + '</td>' +
              '<td>' + ad_type + '</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.number_access) + '件</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_interim) + '人</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_register) + '人</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_ad_cost) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_1) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_2) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_3) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.amount) + '</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.deposit) + '件</td>' +
              '<td style="text-align:right;">¥' + report.deposit_unit_price + '</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_deposit) + '人</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.total_new_payment_users) + '人</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.total_new_registered_users) + '人</td>' +
              '<td style="text-align:right;">' + report.rate_login + ' 回</td>' +
              '</tr>';
          }
          else {
            trHTML += '<tr>' +
              '<td class="text-bg-blue"><a target="_blank" href="' + report.link_media_code + '">' + report.media_code + '</a></td>' +
              '<td class="text-bg-blue"><a target="_blank" href="' + report.link + '">' + report.name + '</a></td>' +
              '<td>' + ad_type + '</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.number_access) + '件</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_interim) + '人</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_register) + '人</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_ad_cost) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_1) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_2) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_3) + '</td>' +
              '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.amount) + '</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.deposit) + '件</td>' +
              '<td style="text-align:right;">¥' + report.deposit_unit_price + '</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_deposit) + '人</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.total_new_payment_users) + '人</td>' +
              '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.total_new_registered_users) + '人</td>' +
              '<td style="text-align:right;">' + report.rate_login + ' 回</td>' +
              '</tr>';
          }
        }
        else {
          trHTML_summary += '<tr>' +
            '<td class="bg-yellow" colspan="3">合計</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.number_access) + '件</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_interim) + '人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_register) + '人</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_ad_cost) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_1) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_2) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.total_amount_3) + '</td>' +
            '<td style="text-align:right;">¥' + new Intl.NumberFormat().format(report.amount) + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.deposit) + '件</td>' +
            '<td style="text-align:right;">¥' + report.deposit_unit_price + '</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.user_deposit) + '人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.total_new_payment_users) + '人</td>' +
            '<td style="text-align:right;">' + new Intl.NumberFormat().format(report.total_new_registered_users) + '人</td>' +
            '<td style="text-align:right;">' + report.rate_login + ' 回</td>' +
            '</tr>';
        }
      });
      $('#table-report-media tbody').append(trHTML + trHTML_summary);
    }

  </script>

  <!-- click search -->
  <script>
    $('.btn-search').click(function () {
      var year_start = $('.year_start').val();
      var month_start = $('.month_start').val();
      var day_start = $('.day_start').val();
      var year_end = $('.year_end').val();
      var month_end = $('.month_end').val();
      var day_end = $('.day_end').val();
      var media_code = $('.media_code').val();

      $.ajax({
        type: 'get',
        url: '{{ route('admin.summary.media_sort.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'year_start': year_start,
          'month_start': month_start,
          'day_start': day_start,
          'year_end': year_end,
          'month_end': month_end,
          'day_end': day_end,
          'media_code': media_code,
        },
        success: function (data) {
          result = JSON.parse(data);
          titleTime(result.year, result.month, result.day);
          endTimePeriod(result.year_end, result.month_end, result.day_end);
          tableReportMedia(result.media);
          console.log(result);
        },
      });

    })
  </script>


@endsection
