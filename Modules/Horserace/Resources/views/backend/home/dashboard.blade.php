@extends('horserace::backend.layouts.design')
@section('title', __("horserace::be_sidebar.dashboard"))
@section('content')

  <!-- breadcumb -->
@section('page_title', __("horserace::be_sidebar.dashboard"))
@section('breadcrumb_item')
  <li class="breadcrumb-item">{{ __("horserace::be_sidebar.dashboard") }}</li>
@endsection
<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">

  @if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!}">
      {!! Session::get('flash_message') !!}
    </div>
@endif

<!-- info -->
  <div class="row mb-4">
    <!-- Payment -->
    <div class="col-lg-4 col-md-6">
      <div class="card mb-4">
        <div class="card-body flexbox-b">
          <div class="mr-4"
               data-percent="73"
               data-bar-color="#55efc4"
               data-size="80"
               data-line-width="8">
            <span class="easypie-data text-success" style="font-size:28px;">
              <i class="ti-shopping-cart"></i>
            </span>
          </div>
          <div>
            <h3 class="font-strong text-success">
              {{ number_format($data["number_payment"]) . '件' }}
              <br>
              {{  number_format($data["payment_point"]) . 'ポイント' }}
            </h3>
            <div class="text-muted">
              {{ __("horserace::be_sidebar.payment") }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Deposit -->
    <div class="col-lg-4 col-md-6">
      <div class="card mb-4">
        <div class="card-body flexbox-b">
          <div class="mr-4"
               data-bar-color="#5c6bc0"
               data-size="80"
               data-line-width="8">
            <span class="easypie-data text-primary" style="font-size:32px;">
              <i class="la la-money"></i>
            </span>
          </div>
          <div>
            <h3 class="font-strong text-primary">
              {{'¥' .  number_format($data["deposit_amount"]) }}
              <br>
              {{ number_format($data["deposit_point"]) . 'ポイント' }}
            </h3>
            <div class="text-muted">
              {{ __("horserace::be_sidebar.deposit") }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- User today login -->
    <div class="col-lg-4 col-md-6">
      <div class="card mb-4">
        <div class="card-body flexbox-b">
          <div class="mr-4"
               data-size="80"
               data-line-width="8">
            <span class="easypie-data text-pink" style="font-size:32px;">
              <i class="la la-users"></i>
            </span>
          </div>
          <div>
            <h3 class="font-strong text-pink">
              {{ number_format($data["user_access"]) . ' / ' . number_format($data["total_user"]) }}
              <br>
              {{  ' (' .  $data["rate_access"]. '%)' }}
            </h3>
            <div class="text-muted">
              {{ __("horserace::be_form.number_user_login") }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">
            {{ __("horserace::be_form.calendar") }}
          </div>
        </div>
        <div class="ibox-body">
          <div class="calendar" id="calendarDashboard"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- End Event Detail Dialog-->
  <div class="row" style="display: none;">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-body">
          <div class="form-group mb-4 row">
            <label class="col-sm-2 col-form-label">Advertisement Url</label>
            <div class="col-sm-10">
              <textarea class="form-control">http://ore-keiba.jp/?r=[****]</textarea>
            </div>

          </div>
          <div class="form-group mb-4 row">
            <label class="col-sm-2 col-form-label">Meta Tag</label>
            <div class="col-sm-10">
              <textarea class="form-control"><meta name="viewport"
                                                   content="width=device-width, initial-scale=1"/></textarea>
            </div>

          </div>
          <div class="form-group mb-4 row">
            <label class="col-sm-2 col-form-label">Meta Tag</label>
            <div class="col-sm-10">
                        <textarea class="form-control"><meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache"/> </textarea>
            </div>
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
    $('#calendarDashboard').fullCalendar({
      locale: 'ja',
      height: 450,
      firstDay: 1,
      selectable: true,
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],

      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'today, prev, next'
      },

      buttonText: {
        //Here I make the button show French date instead of a text.
        today: '今日'
      },

      eventSources: [
        {
          url: '{{ route('admin.holiday') }}', // use the `url` property
          color: 'yellow',    // an option!
          textColor: 'black'  // an option!
        }
      ],

      select: function (startDate, endDate) {
        // alert('selected ' + startDate.format() + ' to ' + endDate.format());
      },

      views: {
        month: {
          titleFormat: 'YYYY年MM月'
        }
      }
    });
  </script>
@endsection

