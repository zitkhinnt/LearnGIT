@extends('horserace::partner.layouts.design')
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
            <i class="ti-arrow-down" id="icon_arrow"> </i>
            {{ __("horserace::be_sidebar.summary_media_code") . " : " . $data["media"]->name }}
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
          <input class="media_code" type="hidden" name="media_code" value="{{ $data["media_code"] }}">
          <table id="table-report-day-media" class="table table-bordered  mb-5">
            <thead>
            <tr>
              <th>{{ __('horserace::be_form.date') }}</th>
              <th> {{ __('horserace::be_form.access_count') }}</th>
              <th style="display:none;"> {{ __('horserace::be_form.unique_number') }}</th>
              <th>{{ __('horserace::be_form.user_register') }}</th>
              <th>{{ __('horserace::be_form.average_login_count') }}</th>
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
        url: '{{ route('partner.summary.access_detail.ajax') }}',
        data: {
          // '_token': $('input[name=_token]').val(),
          'start_month': start_month,
          'media_code': media_code,
        },
        success: function (data) {
          result = JSON.parse(data);
          titleTime(result.year, result.month, result.day);
          console.log(result);
          tableReportDayMedia(result.access);

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

      for (index in report_day_month) {
        if (index != 'summary') {
          trHTML += '<tr>' +
            '<td>' + report_day_month[index]['date'] + '</td>' +
            '<td>' + new Intl.NumberFormat().format(report_day_month[index]['number_access']) + ' 件</td>' +
            '<td style="display:none;">' + new Intl.NumberFormat().format(report_day_month[index]['user_interim']) + ' 人</td>' +
            '<td>' + new Intl.NumberFormat().format(report_day_month[index]['user_register']) + ' 人</td>' +
            '<td>' + Number.parseFloat(report_day_month[index]['rate_login']).toFixed(2) + ' 回</td>' +
            '</tr>';
        }
        else {
          trHTML += '<tr>' +
            '<td class="bg-yellow">合計</td>' +
            '<td>' + new Intl.NumberFormat().format(report_day_month[index]['number_access']) + ' 件</td>' +
            '<td style="display:none;">' + new Intl.NumberFormat().format(report_day_month[index]['user_interim']) + ' 人</td>' +
            '<td>' + new Intl.NumberFormat().format(report_day_month[index]['user_register']) + ' 人</td>' +
            '<td>' + Number.parseFloat(report_day_month[index]['rate_login']).toFixed(2) + ' 回</td>' +
            '</tr>';
        }
      }
      $('#table-report-day-media tbody').append(trHTML);
    }
  </script>

@endsection
